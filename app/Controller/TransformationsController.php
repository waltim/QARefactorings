<?php
App::uses('AppController', 'Controller');

class TransformationsController extends AppController
{
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->layout = 'admin';
		$this->loadModel('TransformationType');
		$this->loadModel('Metric');
		$this->loadModel('Language');
		$this->loadModel('Result');
		$this->loadModel('Question');
		$this->loadModel('Answer');
		$this->loadModel('Transformation');
		$this->loadModel('SearchEvent');
	}

	public function loadAllTransformationByFolder($pesquisa = null)
	{
		$path = WWW_ROOT . 'files';
		$dirs = scandir($path);
		$language = 1;
		foreach ($dirs as $dir) {
			$folder = $path . '/' . $dir;
			if (is_dir($folder) && ($dir != ".") && ($dir != "..")) {
				$snippetPath = scandir($folder);
				$a = $folder . '/' . $snippetPath[2];
				$b = $folder . '/' . $snippetPath[3];
				//pr($folder);
				$HasAny = $this->Transformation->find('first', array(
					'conditions' => array('Transformation.diff_id' => $folder),
				));
				if(count($HasAny) > 0){
					continue;
				}
				$conteudo1 = file_get_contents($a);
				$conteudo2 = file_get_contents($b);

				$typeCode1 = $this->checkCodeHasLambda($conteudo1);
				$typeCode2 = $this->checkCodeHasLambda($conteudo2);

				if ($typeCode1 === 0 && $typeCode2 !== 0) {
					$apt = 'S';
				} else {
					$apt = 'N';
					$typeCode2 = 1;
				}
				$this->Transformation->create();

				$refactor = array(
					'Transformation' => array(
						'transformation_type_id' => $typeCode2,
						'language_id' => $language,
						'search_event_id' => $pesquisa,
						'diff_id' => $folder,
						'code_before' => $conteudo1,
						'old_code' => $a,
						'code_after' => $conteudo2,
						'new_code' => $b,
						'apt' => $apt
					),
				);
//				pr($refactor);
				$this->Transformation->save($refactor);

				$lastTransformationCreated = $this->Transformation->find('first', array(
					'conditions' => array('Transformation.diff_id' => $folder),
					'order' => array('Transformation.created DESC'),
				));

				$metricas = $this->Metric->find('all', array(
					'order' => array('Metric.created DESC'),
				)) ;
				foreach ($metricas as $metrica) {
					$this->Result->create();
					$result = array(
						'Result' => array(
							'transformation_id' => $lastTransformationCreated['Transformation']['id'],
							'metric_id' => $metrica['Metric']['id'],
						),
					);
					$this->Result->save($result);
				}
			}
		}
		$this->redirect(array('action' => 'index', $pesquisa));
	}

	public function get_string_between($string, $start, $end){
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return ".".substr($string, $ini, $len);
	}


	public function ClassifierOfTransformations($research = null){
		$this->loadModel('TransformationType');
		$kinds = array();

		$trfs = $this->Transformation->find("all", array(
			"recursive" => -1,
			"conditions" => array(
				"Transformation.search_event_id" => $research,
			)
		));
		foreach($trfs as $tr){
				$value = $this->updateTypeOfTransformation($tr["Transformation"]["id"]);
			$kinds[$tr["Transformation"]["id"]] = $value;
		}
		$kindsList = array_unique($kinds);

		foreach ($kindsList as $ty){
			$types = $this->TransformationType->find("first", array(
				"conditions" => array(
					"TransformationType.description" => $ty
				)
			));
			//$typesCount = $this->TransformationType->find("count");
			//pr($typesCount);
			if(sizeof($types) == 0){
			//pr($type);
				$this->TransformationType->create();
				$newType = array(
					'TransformationType' => array(
						//'id' => $typesCount+1,
						'description' => $ty,
					),
				);
				//pr($newType);
				if($this->TransformationType->save($newType)){
				}else{
					debug($this->TransformationType->validationErrors);
				}
			}else{
				continue;
			}
		}

		foreach($trfs as $tr){
			$value = $this->updateTypeOfTransformation($tr["Transformation"]["id"]);
			$typeChange = $this->TransformationType->find("first", array(
				"conditions" => array(
					"TransformationType.description" => $value
				)
			));
			$refactor = array(
				'Transformation' => array(
					'id' => $tr["Transformation"]["id"],
					'transformation_type_id' => $typeChange["TransformationType"]["id"]
				),
			);
			//pr($refactor);
			$this->Transformation->save($refactor);
		}
		//pr(sizeof($kinds));
		//$kindsList = array_unique($kinds);
		//pr(sizeof($kindsList));
		//pr($kindsList);
		//pr($kinds);
		//exit();
		$this->redirect(array('action' => 'index', $research));
	}

	public function updateTypeOfTransformation($transformation = null){

		$tr = $this->Transformation->find("first", array(
			"recursive" => -1,
			"conditions" => array(
				"Transformation.id" => $transformation,
			)
		));
		//pr($tr["Transformation"]["id"]);
		//pr($tr["Transformation"]["code_after"]);
		$isLoopOld = 0;
		$isLoopNew = 0;
		$array = explode("\n", file_get_contents($tr["Transformation"]["new_code"]));
			$verify = $this->parserType($array,$tr["Transformation"]["code_after"]);

		$isLoopOld = $isLoopOld + substr_count($tr["Transformation"]["code_before"], 'while (');
		$isLoopOld = $isLoopOld + substr_count($tr["Transformation"]["code_before"], 'for (');
		$isLoopOld = $isLoopOld + substr_count($tr["Transformation"]["code_before"], 'forEach(');

		$isLoopNew = $isLoopNew + substr_count($tr["Transformation"]["code_after"], '() ->');
//				pr($isLoop);
//				pr($verify);exit();
			if(strlen($verify) > 0 && $isLoopOld > 0 && $isLoopNew == 0) {
				$verify = str_replace(".","->",$verify);
				$verify = substr($verify, 2);
				if(substr_count($verify,"|") > 0){
					$verify = str_replace("|->","|",$verify);
					$lfin = substr($verify, -1);
					if(substr_count($verify,"|") == 1 && $lfin == "|"){
						//pr(strlen($verify));
						//pr($verify);
						$verify = str_replace("|","",$verify);
					}
				}
				//pr($verify);exit();
				return "Loop To ".$verify;
			}else{
				//pr("Anonymous Inner Class To Lambda Expression");
				return "Anonymous Inner Class To Lambda Expression";
			}//exit();
	}

	public function parserType($conteudo = null, $code = null){

		$kind = '';
		//pr($conteudo);
		//pr(array_search(end ($conteudo ),$conteudo));//exit();
		$functionsList = array();
		foreach ($conteudo as $key => $line){
			//pr($key.'-'.strlen($line));
			if(strlen($line) > 1) {
				$line = str_replace(".", ".#", $line);
				$pieces = explode(".", $line);
				//pr($pieces);
				foreach ($pieces as $piece){
					$changed = str_replace(" -> ","LAMBDAARROW",$piece);
					$changed = str_replace(")-> ","LAMBDAARROW",$changed);
					$changed = str_replace(")->{","LAMBDAARROW",$changed);
					$piece = str_replace("#", ".", $piece);
					//pr($changed);
					if(substr_count($changed, 'LAMBDAARROW') > 0 || substr_count($changed, 'collect(') > 0
						|| substr_count($changed, 'reduce(') > 0){
						//pr($piece);
						if(strlen($this->get_string_between($piece, '.', '(')) > 0){
							//$pos = strpos($code,$this->get_string_between($piece, '.', '('));
							//pr($pos);
							$functionsList[] = $this->get_string_between($piece, '.', '(');
							//pr($this->get_string_between($piece, '.', '('));
						}
						//pr($functionsList);
					}else{
						//pr($functionsList);
						continue;
					}

				}
			}elseif(($key != sizeof($conteudo)-1) && strlen($line) < 2 && sizeof($functionsList) > 0){
				$functionsList[] = "|";
			} else{
				continue;
			}
		}
		ksort($functionsList);
		$functionsList = array_unique($functionsList);
		//pr($functionsList);
		//exit();
		foreach ($functionsList as $func){
			$kind .= $func;
		}
		return $kind;
	}

	public function verifyIsChaining($research = null){

		$trfs = $this->Transformation->find("all", array(
			"recursive" => -1,
			"conditions" => array(
				"Transformation.search_event_id" => $research,
				//"Transformation.transformation_type_id !=" => 1
			)
		));

		foreach($trfs as $tr){
			$typeCode1 = $this->checkCodeHasLambda($tr["Transformation"]["code_before"]);
			$typeCode2 = $this->checkCodeHasLambda($tr["Transformation"]["code_after"]);
			if ($typeCode1 === 0 && $typeCode2 !== 0) {
				$apt = 'S';
			} else {
				$apt = 'N';
				$typeCode2 = 1;
			}
//			pr($tr["Transformation"]["id"]);
			//pr($tr["Transformation"]["code_after"]);
			//pr($apt);
			if($apt === 'S'){
				$verify = $this->parserChaining($tr["Transformation"]["code_after"]);
//				pr($verify);
				if(strlen($verify) > 0) {
					$pieces = explode(".", $verify);
					$sizeChain = sizeof($pieces) - 1;
					if($sizeChain > 1){
						$chain = "CHAINING";
					}else{
						$chain = "NOT CHAINING";
					}
				}else{
					$chain = "NOT CHAINING";
				}
				$refactor = array(
					'Transformation' => array(
						'id' => $tr["Transformation"]["id"],
						'is_cascade' => $chain
					),
				);
				$this->Transformation->save($refactor);
			}
		}
		$this->redirect(array('action' => 'index', $research));
	}

	public function parserChaining($conteudo = null){

		$chaining = '';

		pr($conteudo);exit();

		$tokenFilter = substr_count($conteudo, '.filter(');
		$tokenCount = substr_count($conteudo, '.count(');
		$tokenCollect = substr_count($conteudo, '.collect(');
		$tokenMap = substr_count($conteudo, '.map(');
		$tokenReduce = substr_count($conteudo, '.reduce(');
		$tokenForeach = substr_count($conteudo, '.forEach(');
		$tokenAnyMatch = substr_count($conteudo, '.anyMatch(');
		$tokenFlatMap = substr_count($conteudo, '.flatMap(');
		$tokenForeachOrdered = substr_count($conteudo, '.forEachOrdered(');
		if($tokenFilter > 0){
			$chaining .= ".filter";
		}
		if($tokenCount > 0){
			$chaining .= ".count";
		}
		if($tokenCollect > 0){
			$chaining .= ".collect";
		}
		if($tokenMap > 0){
			$chaining .= ".map";
		}
		if($tokenReduce > 0){
			$chaining .= ".reduce";
		}
		if($tokenForeach > 0){
			$chaining .= ".forEach";
		}
		if($tokenForeachOrdered > 0){
			$chaining .= ".forEachOrdered";
		}
		if($tokenAnyMatch > 0){
			$chaining .= ".anyMatch";
		}
		if($tokenFlatMap > 0){
			$chaining .= ".flatMap";
		}
		return $chaining;
	}

	public function checkCodeHasLambda($conteudo = null)
	{
		$changed = str_replace(" -> ","LAMBDAARROW",$conteudo);
		$changed = str_replace(")-> ","LAMBDAARROW",$changed);
		$changed = str_replace(")->{","LAMBDAARROW",$changed);
		if (strpos($changed, "LAMBDAARROW") === false) {
			$transformationType = 0;
			return $transformationType;
		}

		$tokenFilter = strpos($conteudo, '.filter');
		$tokenCount = strpos($conteudo, '.count');
		$tokenCollect = strpos($conteudo, '.collect');
		$tokenMap = strpos($conteudo, '.map');
		$tokenReduce = strpos($conteudo, '.reduce');
		$tokenForeach = strpos($conteudo, '.forEach');
		$tokenAnyMatch = strpos($conteudo, '.anyMatch');
		$tokenFlatMap = strpos($conteudo, '.flatMap');

		if ($tokenFilter != null) {
			$transformationType = 3;
		} elseif ($tokenForeach != null) {
			$transformationType = 2;
		} elseif ($tokenMap != null) {
			$transformationType = 5;
		} elseif ($tokenAnyMatch != null) {
			$transformationType = 4;
		} elseif ($tokenFlatMap != null) {
			$transformationType = 16;
		} else {
			$transformationType = 1;
		}

		if ($tokenFilter != null && $tokenCount != null) {
			$transformationType = 8;
		} elseif ($tokenFilter != null && $tokenCollect != null) {
			$transformationType = 9;
		} elseif ($tokenMap != null && $tokenCollect != null) {
			$transformationType = 7;
		} elseif ($tokenMap != null && $tokenReduce != null) {
			$transformationType = 6;
		} elseif ($tokenFilter != null && $tokenFlatMap != null) {
			$transformationType = 11;
		} elseif ($tokenMap != null && $tokenFlatMap != null) {
			$transformationType = 13;
		} elseif ($tokenForeach != null && $tokenFlatMap != null) {
			$transformationType = 14;
		} elseif ($tokenMap != null && $tokenCount != null) {
			$transformationType = 15;
		} elseif ($tokenFilter != null && $tokenForeach != null) {
			$transformationType = 10;
		} elseif ($tokenFilter != null) {
			$transformationType = 3;
		} elseif ($tokenForeach != null) {
			$transformationType = 2;
		} elseif ($tokenMap != null) {
			$transformationType = 5;
		} elseif ($tokenAnyMatch != null) {
			$transformationType = 4;
		} elseif ($tokenFlatMap != null) {
			$transformationType = 16;
		} else {
			$transformationType = 1;
		}
		return $transformationType;
	}


	public function MatchDiffsAndReturnMetricsForAllCodes()
	{
		$arquivo = fopen('/home/walterlucas/export-data_survey/metrics-buse.txt', 'r');
		$linhas = array();
		while (!feof($arquivo)) {
			$linhas[] = fgets($arquivo, 1024);
		}
		fclose($arquivo);
		foreach ($linhas as $linha) {
			//pr($linha);
			$pos = strpos($linha,"snippet");
			if($pos === false){
				continue;
			}
			$diff = explode(" - ", $linha);
			//pr($diff);
			$transformation = $this->Transformation->find('first', array(
				'recursive' => -1,
				'conditions' => array(
					'Transformation.diff_id LIKE' => '%'.$diff[0].'%'
				),
			));
			//pr($transformation['Transformation']);
			if (empty($transformation)) {
				continue;
			}
			$metric = explode(" | ", $diff[1]);
			//pr($metric);
			$this->Result->create();
			$result = array(
				'Result' => array(
					'transformation_id' => $transformation['Transformation']['id'],
					'metric_id' => 5,
					'before' => str_replace(',', '.', $metric[0]),
					'after' => str_replace(',', '.', $metric[1]
					),
				)
			);
			$this->Result->save($result);
		}//exit();
		$this->redirect(array('controller' => 'SearchEvents', 'action' => 'index'));
	}


	public function countTransformationByProject()
	{
		$transformations = $this->Transformation->find('all', array(
			'recursive' => -1,
			'order' => array('Transformation.id DESC'),
			'conditions' => array(
				"Transformation.apt" => "S",
				"Transformation.id <=" => 1072
			)

		));
		$projects = array();
		foreach ($transformations as $tr) {
//			pr($tr['Transformation']['site_link']);
			$aux = explode('/', $tr['Transformation']['site_link']);
//           pr($aux);
			$projects[] = $aux[4];
		}
//		exit();
		pr(array_count_values($projects));
		exit();
	}

	public
	function index($pesquisa = null)
	{
		if ($pesquisa == null) {
			$transformations = $this->Transformation->find('all', array(
				'order' => array('Transformation.id DESC'),
			));
		} else {
			$transformations = $this->Transformation->find('all', array(
				'conditions' => array(
					'Transformation.search_event_id' => $pesquisa,
				),
				'order' => array('Transformation.id DESC'),
			));
		}

		$arrayInterc = array(554,553,552,551,550,546,544,542,541,
			540,539,538,537,536,535,534,533,528,527,525,
			524,523,522,515,507,506,505,498,491,487,486,477,476,475,
			474,473,470,469,468,466,465,464,463,461,460,459,458,457,456);
//		pr($arrayInterc);exit();
		foreach ($transformations as $key => $trf){
			if(in_array($trf["Transformation"]['id'], $arrayInterc)){
				$transformations[$key]["Transformation"]["intersection"] = "true";
			}else{
				$transformations[$key]["Transformation"]["intersection"] = "false";
			}
		}
//		pr($transformations);exit();
		$this->set(compact('transformations'));
		$this->set('pesquisa', $pesquisa);
	}

	public
	function add($id = null)
	{
		if ($this->request->is('post')) {
			$uid = $id;
			$refactoring['Transformation'] = $this->request->data['Transformation'];
			$refactoring['Transformation']['search_event_id'] = $uid;
			unset($refactoring['Transformation']['metricas']);
			$metricas = $this->request->data['Transformation']['metricas'];
			$conteudo = $refactoring['Transformation']['conteudo'];
			$conteudo = strip_tags($conteudo, '<br>');
			$conteudo = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $conteudo);
			$cortaLink = explode("#", $refactoring['Transformation']['site_link']);

			// pr($conteudo);
			// exit();
			$conditions = array(
				'search_event_id' => $refactoring['Transformation']['search_event_id'],
				'site_link' => $refactoring['Transformation']['site_link'],
				'line_start' => strtoupper($refactoring['Transformation']['line_start']),
				'line_end' => strtoupper($refactoring['Transformation']['line_end']),
			);
			if ($this->Transformation->hasAny($conditions)) {
				$this->Session->setFlash(__("A refatoração: <b>" . $refactoring['Transformation']['site_link'] . "</b> já foi cadastrada nesta pesquisa!"), 'Flash/info');
			} else {
				$anomesdiahora = date('YmdHis');
				$this->Transformation->create();
				$refactor = array(
					'Transformation' => array(
						'transformation_type_id' => $refactoring['Transformation']['transformation_type_id'],
						'language_id' => $refactoring['Transformation']['language_id'],
						'search_event_id' => $refactoring['Transformation']['search_event_id'],
						'diff_id' => $cortaLink[1] . "-" . $anomesdiahora,
						'site_link' => $refactoring['Transformation']['site_link'],
						'line_start' => strtoupper($refactoring['Transformation']['line_start']),
						'line_end' => strtoupper($refactoring['Transformation']['line_end']),
					),
				);
				// pr($refactor);exit();
				$this->Transformation->save($refactor);

				$lastTransformationCreated = $this->Transformation->find('first', array(
					'conditions' => array('Transformation.search_event_id' => $refactoring['Transformation']['search_event_id']),
					'order' => array('Transformation.created DESC'),
				));

				foreach ($metricas as $metrica) {
					$this->Result->create();
					$result = array(
						'Result' => array(
							'transformation_id' => $lastTransformationCreated['Transformation']['id'],
							'metric_id' => $metrica,
						),
					);
					$this->Result->save($result);
				}
				//pr($conteudo);exit();
				$nomecode = $cortaLink[1] . "-" . $anomesdiahora;
				$pasta = WWW_ROOT . "files/" . $nomecode . "/";
				$caminho = $pasta;
				$oldmask = umask(0);
				if (file_exists($pasta)) {
					echo "O arquivo $pasta existe";
				} else {
					mkdir($pasta, 0777, true);
				}
				$caminho = $caminho . "ab.txt";
				$fp = fopen($caminho, "w+");
				$breaks = array("<br />", "<br>", "<br/>");
				$conteudo = str_ireplace($breaks, "\r\n", $conteudo);
				$conteudo = str_replace("&nbsp;", "", $conteudo);
				$escreve = fwrite($fp, utf8_encode($conteudo));
				fclose($fp);
				umask($oldmask);

				$this->separaAnteriorETransformado($lastTransformationCreated['Transformation']['id'], $pasta, $caminho);
				// pr($lastTransformationCreated);//exit();
				$this->Session->setFlash(__('Transformação cadastrada com sucesso.'), 'Flash/success');
				$this->redirect(array('action' => 'add', $lastTransformationCreated['Transformation']['search_event_id']));
			}

		}
		$this->set('languages', $this->Language->find('list', array('fields' => 'Language.description')));
		$this->set('types', $this->TransformationType->find('list', array('fields' => 'TransformationType.description')));
		$this->set('metrics', $this->Metric->find('list', array('fields' => 'Metric.acronym')));
		$this->set('pesquisa', $id);
	}

	public
	function separaAnteriorETransformado($transformation = null, $pasta = null, $arquivo = null)
	{
		//pr($arquivo);exit();
		//Variável $fp armazena a conexão com o arquivo e o tipo de ação.
		$fp = fopen($arquivo, "r");

		//Lê o conteúdo do arquivo aberto.
		$oldmask = umask(0);
		$a = fopen($pasta . "a.txt", "w+");
		$b = fopen($pasta . "b.txt", "w+");
		$Aconteudo = '';
		$Bconteudo = '';
		$Cconteudo = '';
		$Dconteudo = '';
		while (!feof($fp)) {
			$valor = fgets($fp, 4096);
			if (strstr($valor, "+   ")) {
				$Cconteudo .= $valor . '<br/>';
				$valor = str_replace("+   ", "    ", $valor);
				$Bconteudo .= fwrite($b, utf8_encode($valor));
			} elseif (strstr($valor, "-   ")) {
				$Dconteudo .= $valor . '<br/>';
				$valor = str_replace("-   ", "    ", $valor);
				$Aconteudo .= fwrite($a, utf8_encode($valor));
			} else {
				$Aconteudo .= fwrite($a, utf8_encode($valor));
				$Bconteudo .= fwrite($b, utf8_encode($valor));
				$Cconteudo .= $valor . '<br/>';
				$Dconteudo .= $valor . '<br/>';
			}
		}
		fclose($a);
		fclose($b);
		umask($oldmask);
		//Fecha o arquivo.
		fclose($fp);
		//retorna o conteúdo.
		$this->Transformation->id = $transformation;
		$refactor = array(
			'Transformation' => array(
				'code_before' => "<p>" . $Dconteudo . "</p>",
				'old_code' => $pasta . "a.txt",
				'code_after' => "<p>" . $Cconteudo . "</p>",
				'new_code' => $pasta . "b.txt",
			),
		);
		$this->Transformation->save($refactor);

		$this->manipulaMetricas($transformation);
	}

	public
	function edit($id = null)
	{
		if ($this->request->is('post')) {
			$refactoring['Transformation'] = $this->request->data['Transformation'];
			$refactoring['Transformation']['id'] = $id;
			// pr($refactoring);exit();
			if ($this->Transformation->save($refactoring)) {

//				$transformationModificada = $this->Transformation->find('first', array(
//					'conditions' => array(
//						'Transformation.id' => $refactoring['Transformation']['id'],
//					),
//				));
//
//				$nomecode = $transformationModificada['Transformation']['diff_id'];
//				$pasta = WWW_ROOT . "files/" . $nomecode . "/";
//				$caminho = $pasta;
//				$oldmask = umask(0);
//
//				$path = str_replace('a.txt', "", $transformationModificada['Transformation']['old_code']);
//				$this->delTree($path);
//
//				if (file_exists($pasta)) {
//					echo 'já existe';
//				} else {
//					mkdir($pasta, 0777, true);
//				}
//
//				$a = fopen($pasta . "a.txt", "w+");
//				$b = fopen($pasta . "b.txt", "w+");
//
//				$valorA = str_replace("+   ", "", $refactoring['Transformation']['code_after']);
//				$valorA = str_replace("    +", "", $refactoring['Transformation']['code_after']);
//				$valorA = strip_tags($valorA);
//				fwrite($b, utf8_encode($valorA));
//				$valorB = str_replace("-   ", "", $refactoring['Transformation']['code_before']);
//				$valorB = str_replace("   -", "", $refactoring['Transformation']['code_before']);
//				$valorB = strip_tags($valorB);
//				fwrite($a, utf8_encode($valorB));
//
//				fclose($a);
//				fclose($b);
//
//				umask($oldmask);

				$this->Session->setFlash(__('Transformação atualizada com sucesso.'), 'Flash/success');
				$this->redirect(array('action' => 'view', $refactoring['Transformation']['id']));
			}
		}

		$transformation = $this->Transformation->findById($id);
		$metricas = $this->Metric->find('list', array('fields' => 'Metric.acronym'));
		foreach ($transformation['Metric'] as $filter) {
			if (in_array($filter['acronym'], $metricas)) {
				$key = array_search($filter['acronym'], $metricas);
				unset($metricas[$key]);
			}
		}
		$this->set('transformation', $transformation);
		$this->set('languages', $this->Language->find('list', array('fields' => 'Language.description')));
		$this->set('types', $this->TransformationType->find('list', array('fields' => 'TransformationType.description')));
		$this->set('metrics', $metricas);
	}

	public
	static function delTree($dir)
	{
		$files = array_diff(scandir($dir), array('.', '..'));
		foreach ($files as $file) {
			(is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
		}
		return rmdir($dir);
	}

	public
	function delete($id = null, $pesquisa = null)
	{
		$Selected = $this->Transformation->find('first', array(
			'conditions' => array('Transformation.id' => $id),
		));
		if (empty($Selected)) {
			$this->Session->setFlash(__('Transformação não encontrada.'), 'Flash/error');
		} else {
			$this->Transformation->delete($id);
//			$path = str_replace('a.txt', "", $Selected['Transformation']['old_code']);
//			$this->delTree($path);
			$this->Session->setFlash(__('Deletada com sucesso!'), 'Flash/success');
			$this->redirect(array('action' => 'index', $pesquisa));
		}
	}

	public
	function deleteAll($pesquisa = null)
	{
		$Selected = $this->Transformation->find('all', array(
			'conditions' => array('Transformation.search_event_id' => $pesquisa),
		));
		foreach ($Selected as $todel) {
			$this->Transformation->delete($todel['Transformation']['id']);
			//$path = str_replace('a.txt', "", $todel['Transformation']['old_code']);
			//$this->delTree($path);
		}
		$this->Session->setFlash(__('Deletadados com sucesso!'), 'Flash/success');
		$this->redirect(array('action' => 'index', $pesquisa));
	}

	public
	function view($id = null)
	{
		if ($id == null) {
			$this->Session->setFlash(__('Esta transformação não existe!'), 'Flash/error');
			$this->redirect(array('action' => 'index'));
		}

		if ($this->request->is('post')) {
			$this->Transformation->id = $id;
			if (array_key_exists("deletions", $this->request->data['Transformation'])) {
				$result = array(
					'Transformation' => array(
						'transformation_id' => $id,
						'deletions' => $this->request->data['Transformation']['deletions'],
					),
				);
			} else {
				$result = array(
					'Transformation' => array(
						'transformation_id' => $id,
						'additions' => $this->request->data['Transformation']['additions'],
					),
				);
			}
			if ($this->Transformation->save($result)) {
				$this->Session->setFlash(__('linhas destacadas com sucesso.'), 'Flash/success');
				$this->redirect(array('action' => 'view', $id));
			}
		}

		$show = $this->Transformation->find('first', array(
			'conditions' => array('Transformation.id' => $id),
		));
		$qualitativas = $this->Transformation->Result->find('all', array(
			'conditions' => array(
				'Metric.metric_type_id' => 2,
				'Transformation.id' => $id,
			),
		));
		$quantitativas = $this->Transformation->Result->find('all', array(
			'conditions' => array(
				'Metric.metric_type_id' => 3,
				'Transformation.id' => $id,
			),
		));

		$questao = $this->Result->find('first', array(
			'conditions' => array(
				'Metric.metric_type_id' => 2,
				'Transformation.id' => $id,
			),
		));
//		pr($questao);exit();
		if (!empty($questao['ResultQuestion'])) {
			$k = 0;
			foreach ($questao['ResultQuestion'] as $rq) {
				$itemresp = $this->Answer->find('all', array(
					'conditions' => array(
						'Answer.result_question_id' => $rq['id'],
					),
				));

				foreach ($itemresp as $itrp){
					$itrp['Answer']['question_id'] = $this->getQuestion($itrp['ResultQuestion']['question_id']);
//					pr($itrp);exit();
					$respostas[$k] = $itrp['Answer'];
					$k++;
				}
//				pr($itemresp);exit();

//				$respostas[$k];
//				$k++;
			}
//			$respostas = array_filter($respostas);
//			pr($respostas);exit();
			$this->set('respostas', $respostas);
		}

		$this->set('transformation', $show);
		$this->set('quantitativas', $quantitativas);
		$this->set('qualitativas', $qualitativas);
	}

	public function getQuestion($id = null){

		$name = $this->Question->find('first',array(
			'conditions' => array(
				'Question.id' => $id,
			),
		));
		return $name["Question"]["description"];
	}

	public
	function locAndAmloc($string = null)
	{
		$numLoc = substr_count($string, "\n");
		return $numLoc+1;
	}

	public
	function accm($string = null)
	{
		$complex = 1;
		$complex = $complex + substr_count($string, 'if (');
		$complex = $complex + substr_count($string, 'while (');
		$complex = $complex + substr_count($string, 'for (');
		$complex = $complex + substr_count($string, 'forEach(');
		$complex = $complex + substr_count($string, 'catch (');
		$complex = $complex + substr_count($string, ' ? ');
		$complex = $complex + substr_count($string, ' && ');
		$complex = $complex + substr_count($string, 'case ');
		$complex = $complex + substr_count($string, ' || ');
		$complex = $complex + substr_count($string, 'continue;');
		$complex = $complex + substr_count($string, 'goto ');
		return $complex;
	}



	public
	function manipulaMetricas($id = null)
	{
		$this->loadModel('Result');

		$this->autoRender = false;

		$metrics = $this->Result->find('all', array(
			'conditions' => array(
				'Transformation.id' => $id,
			),
		));

		foreach ($metrics as $metricas) {
			if ($metricas['Metric']['acronym'] == 'LOC') {
				$this->Result->id = $metricas['Result']['id'];
				$result = array(
					'Result' => array(
						'before' => (int)$this->locAndAmloc($metricas['Transformation']['code_before']),
						'after' => (int)$this->locAndAmloc($metricas['Transformation']['code_after']),
					),
				);
				$this->Result->save($result);
			} elseif ($metricas['Metric']['acronym'] == 'ACCM') {
				$this->Result->id = $metricas['Result']['id'];
				$result = array(
					'Result' => array(
						'before' => $this->accm($metricas['Transformation']['code_before']),
						'after' => $this->accm($metricas['Transformation']['code_after']),
					),
				);
				$this->Result->save($result);
			}else{

			}
		}
	}

	public
	function atualizaTodasAsMetricas($id = null)
	{
		$this->loadModel('Metric');

		$pesquisa = $this->SearchEvent->find('first', array(
			'recursive' => 2,
			'conditions' => array(
				'SearchEvent.id' => $id
			)
		));

		foreach ($pesquisa['Transformation'] as $trasnformation) {
			$metricas = $this->Metric->find('list', array('fields' => 'Metric.acronym'));
			foreach ($trasnformation['Metric'] as $filter) {
				if (in_array($filter['acronym'], $metricas)) {
					$key = array_search($filter['acronym'], $metricas);
					unset($metricas[$key]);
				}
			}
//			pr($metricas);exit();
			if (!empty($metricas)) {
//				foreach ($metricas as $key => $metrica) {
//                    //pr($key);exit();
//					$this->Result->create();
//					$result = array(
//						'Result' => array(
//							'transformation_id' => $trasnformation['id'],
//							'metric_id' => $key,
//						),
//					);
//					$this->Result->save($result);
//				}
			}
			$this->manipulaMetricas($trasnformation['id']);
		}

		$this->redirect(array('action' => 'index', $id));
	}

	public
	function AtualizaMetricasIndividual($id = null)
	{
		$this->manipulaMetricas($id);
		$this->redirect(array('action' => 'view', $id));
	}
}
