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


    public function MatchDiffsAndReturnMetricsForAllCodes()
    {
        $arquivo = fopen('C:\Users\03873243130\Desktop\lambdaanalysisresults\allTransformationMetrics\estatisticaExtratorCodigo.txt', 'r');
        $linhas = array();
        while (!feof($arquivo)) {
            $linhas[] = fgets($arquivo, 1024);
        }
        fclose($arquivo);
        foreach ($linhas as $linha) {
            $diff = explode(" - ", $linha);
            $transformation = $this->Transformation->find('first', array(
                'recursive' => -1,
                'conditions' => array(
                    'Transformation.diff_id' => $diff[0]
                ),
            ));
            pr($transformation['Transformation']['id']);
            if (!empty($transformation)) {
                $metric = explode(" | ", $diff[1]);
            }
            $this->Result->create();
            $result = array(
                'Result' => array(
                    'transformation_id' => $transformation['Transformation']['id'],
                    'metric_id' => 28,
                    'before' => str_replace(',', '.', $metric[0]),
                    'after' => str_replace(',', '.', $metric[1]
                    ),
                )
            );
            $this->Result->save($result);
        }
        $this->redirect(array('controller'=>'SearchEvents','action' => 'index'));
    }


    public function countTransformationByProject()
    {
        $transformations = $this->Transformation->find('all', array(
            'recursive' => -1,
            'order' => array('Transformation.id DESC'),
        ));
        $projects = array();
        foreach ($transformations as $tr) {
//            pr($tr['Transformation']['site_link']);
            $aux = explode('/', $tr['Transformation']['site_link']);
//            pr($aux);exit();
            $projects[] = $aux[3];
        }
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

                $transformationModificada = $this->Transformation->find('first', array(
                    'conditions' => array(
                        'Transformation.id' => $refactoring['Transformation']['id'],
                    ),
                ));

                $nomecode = $transformationModificada['Transformation']['diff_id'];
                $pasta = WWW_ROOT . "files/" . $nomecode . "/";
                $caminho = $pasta;
                $oldmask = umask(0);

                $path = str_replace('a.txt', "", $transformationModificada['Transformation']['old_code']);
                $this->delTree($path);

                if (file_exists($pasta)) {
                    echo 'já existe';
                } else {
                    mkdir($pasta, 0777, true);
                }

                $a = fopen($pasta . "a.txt", "w+");
                $b = fopen($pasta . "b.txt", "w+");

                $valorA = str_replace("+   ", "", $refactoring['Transformation']['code_after']);
                $valorA = str_replace("    +", "", $refactoring['Transformation']['code_after']);
                $valorA = strip_tags($valorA);
                fwrite($b, utf8_encode($valorA));
                $valorB = str_replace("-   ", "", $refactoring['Transformation']['code_before']);
                $valorB = str_replace("   -", "", $refactoring['Transformation']['code_before']);
                $valorB = strip_tags($valorB);
                fwrite($a, utf8_encode($valorB));

                fclose($a);
                fclose($b);

                umask($oldmask);

                $this->Session->setFlash(__('Transformação atualizada com sucesso.'), 'Flash/success');
                $this->redirect(array('action' => 'edit', $refactoring['Transformation']['id']));
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
            $path = str_replace('a.txt', "", $Selected['Transformation']['old_code']);
            $this->delTree($path);
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
            $path = str_replace('a.txt', "", $todel['Transformation']['old_code']);
            $this->delTree($path);
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
        //pr($questao);exit();
        if (!empty($questao['ResultQuestion'])) {
            $k = 0;
            foreach ($questao['ResultQuestion'] as $rq) {
                $respostas[$k] = $this->Answer->find('first', array(
                    'conditions' => array(
                        'Answer.result_question_id' => $rq['id'],
                    ),
                ));
                $k++;
            }
            $respostas = array_filter($respostas);
            $this->set('respostas', $respostas);
        }

        $this->set('transformation', $show);
        $this->set('quantitativas', $quantitativas);
        $this->set('qualitativas', $qualitativas);
    }

    function array_iunique($array)
    {
        return array_intersect_key(
            $array,
            array_unique(array_map("strtolower", $array))
        );
    }

    public
    function clearString($string = null)
    {
        $string = str_replace("+   ", "    ", $string);
        $string = str_replace("-   ", "    ", $string);
        return $string;
    }

    public
    function posnetReadability($string = null)
    {
        $readability = 8.87 - (0.033 * $this->HalsteadV($string)) + (0.40 * $this->locAndAmloc($string)) - (1.5 * $this->entropy($string));
        $part1 = 8.87 - (0.033 * $this->HalsteadV($string));
        $part2 = (0.40 * $this->locAndAmloc($string));
        $part3 = (1.5 * $this->entropy($string));
        $val = $part1;
//        pr($part1);
//        pr($val = $val + $part2);
//        pr($val = $val - $part3);
//        exit();
        return round($readability, 2);
    }

    public
    function posnetReadabilityToken($string = null)
    {
        $readability = 8.87 - (0.033 * $this->HalsteadV($string)) + (0.40 * $this->locAndAmloc($string)) - (1.5 * $this->entropyByTokens($string));
        return round($readability, 2);
    }

    public
    function entropyByTokens($string = null)
    {
        $h = 0;
        $string = $this->clearString($string);
        $size = strlen($string);
        $frequencies = array_count_values(str_word_count($string, 1));
        $frequencies['=='] = substr_count($string, '==');
        $frequencies['!='] = substr_count($string, '!=');
        $frequencies['!='] = substr_count($string, '!=');
        $frequencies['&gt;'] = substr_count($string, '&gt;');
        $frequencies['&lt;'] = substr_count($string, '&lt;');
        $frequencies['&gt;='] = substr_count($string, '&gt;=');
        $frequencies['&lt;='] = substr_count($string, '&lt;=');
        $frequencies['&&'] = substr_count($string, '&&');
        $frequencies['||'] = substr_count($string, '||');
        $frequencies['+'] = substr_count($string, '+');
        $frequencies['-'] = substr_count($string, '-');
        $frequencies['*'] = substr_count($string, '*');
        $frequencies['%'] = substr_count($string, '%');
        $frequencies['/'] = substr_count($string, '/');
        $frequencies['{'] = substr_count($string, '{');
        $frequencies['}'] = substr_count($string, '}');
        $frequencies['('] = substr_count($string, '(');
        $frequencies[')'] = substr_count($string, ')');
//        $frequencies[' '] = substr_count($string, ' ');
        foreach ($frequencies as $key => $fr) {
            if ($fr == 0) {
                unset($frequencies[$key]);
            }
        }
        foreach ($frequencies as $v) {
            $p = $v / $size;
            $h -= $p * log($p) / log(2);
        }
        return round($h, 2);
    }

    public
    function entropy($string = null)
    {
        $string = $this->clearString($string);
        $h = 0;
        $size = strlen($string);
        foreach (count_chars($string, 1) as $v) {
            $p = $v / $size;
            $h -= $p * log($p) / log(2);
        }
        $entropy = round($h, 2);
        return $entropy;
    }

    public
    function HalsteadV($string = null)
    {
        $vocabulary = $this->hln1($string) + $this->hln2($string);
//        if($vocabulary == 0){
//            $vocabulary = 1;
//        }
        $lenght = $this->hl_N1($string) + $this->hl_N2($string);
//        if($lenght == 0){
//            $lenght = 1;
//        }
        $volume = $lenght * log($vocabulary, 2);
        return round($volume, 2);
    }

    public
    function hl_N2($string = null)
    {
        $string = $this->clearString($string);
        $keywords = 'abstract,continue,forEach,for,new,switch,assert,default,goto,package,synchronized,boolean,do,if,private,this,break,double,implements,protected,throw,byte,else,import,public,throws,case,enum,instanceof,return,transient,catch,extends,int,short,try,char,final,interface,static,void,class,finally,long,strictfp,volatile,const,float,native,super,while,null';
        $keywords = explode(',', $keywords);

        $operators = " - , + ,+=,-=,*=,/=,%=,&=,^=,|=, = ,expr++,expr--,++expr,--expr,+expr,-expr, ~ , ! ,*, / , % ,==,!=, & ,^, | , && , || , ? , : ,instanceof,&gt;=,&lt;=, &lt; , &gt; ," .
            "&lt;&lt;,&gt;&gt;,&gt;&gt;&gt;,&lt;&lt;=,&gt;&gt;=,&gt;&gt;&gt;=";
        $operators = explode(',', $operators);

        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayOperator = array();
        $arrayComp = array();
        foreach ($str as $key => $line) {
            $checkOperators = 0;
            foreach ($operators as $operator) {
                if (strstr($line, $operator)) {
                    $checkOperators++;
                    $arrayOperator[] = $operator;
                }
            }
            if ($checkOperators >= 1) {
                $arrayComp[$key] = $line;
            }
        }
        $arrayOperator = array_unique($arrayOperator);
        $totalWords = 0;
        $divideString = array();
        foreach ($arrayComp as $kk => $value) {
            foreach ($arrayOperator as $opr) {
//                pr($opr);
                $divideString[] = explode($opr, $value);
            }
        }
        foreach ($divideString as $ky => $divide) {
            if (sizeof($divide) <= 1) {
                unset($divideString[$ky]);
            } else {
                $totalWords += count($divide);
            }
        }
        return $totalWords;
    }

    public
    function hln2($string = null)
    {
        $string = $this->clearString($string);
        $keywords = 'abstract,continue,forEach,for,new,switch,assert,default,goto,package,synchronized,boolean,do,if,private,this,break,double,implements,protected,throw,byte,else,import,public,throws,case,enum,instanceof,return,transient,catch,extends,int,short,try,char,final,interface,static,void,class,finally,long,strictfp,volatile,const,float,native,super,while,null';
        $keywords = explode(',', $keywords);

        $operators = " - , + ,+=,-=,*=,/=,%=,&=,^=,|=, = ,expr++,expr--,++expr,--expr,+expr,-expr, ~ , ! ,*, / , % ,==,!=, & ,^, | , && , || , ? , : ,instanceof,&gt;=,&lt;=, &lt; , &gt; ," .
            "&lt;&lt;,&gt;&gt;,&gt;&gt;&gt;,&lt;&lt;=,&gt;&gt;=,&gt;&gt;&gt;=";
        $operators = explode(',', $operators);

        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayOperator = array();
        $arrayComp = array();
        foreach ($str as $key => $line) {
            $checkOperators = 0;
            foreach ($operators as $operator) {
                if (strstr($line, $operator)) {
                    $checkOperators++;
                    $arrayOperator[] = $operator;
                }
            }
            if ($checkOperators >= 1) {
                $arrayComp[$key] = $line;
            }
        }
        $arrayOperator = array_unique($arrayOperator);
        $totalWords = 0;
        $divideString = array();
        foreach ($arrayComp as $kk => $value) {
            foreach ($arrayOperator as $opr) {
//                pr($opr);
                $divideString[] = explode($opr, $value);
            }
        }

        foreach ($divideString as $ky => $divide) {
            if (sizeof($divide) <= 1) {
                unset($divideString[$ky]);
            } else {
                $totalWords += count($divide);
            }
        }
        foreach ($divideString as $yk => $str) {
            foreach ($str as $kkyy => $value) {
                foreach ($keywords as $key) {
                    if (strstr($value, $key)) {
                        $value = str_replace($key, ' ', $value);
                    }
                }
                $value = strip_tags($value);
                $value = str_replace('&gt', ' ', $value);
                $value = str_replace('&lt', ' ', $value);
                $value = preg_replace('/\s+/', ' ', trim($value));
                $value = preg_replace('/[^A-Za-z0-9\-]/', ' ', $value);
                $value = str_replace('-', ' ', $value);
                $value = str_replace('+', ' ', $value);
                $value = str_replace('%', ' ', $value);
                $value = str_replace('@', ' ', $value);
                $divideString[$yk][$kkyy] = $value;
                $words = explode(" ", $value);
                $words = array_filter($words);
            }
        }
        foreach ($divideString as $yk => $str) {
            foreach ($str as $kkyy => $val) {
                $divideString[$yk][$kkyy] = trim($val);
            }
        }

        foreach ($divideString as $yk => $str) {
            foreach ($str as $st => $ss) {
                $contador = 1;
                $check = explode(' ', $str[$st]);
                foreach ($divideString as $jk => $valid) {
                    foreach ($valid as $kkyy => $val) {
                        if (count($check) > 1) {
                            if ($check[1] == $val) {
                                $contador++;
                            }
                        }
                    }
                }
                if ($contador > 1) {
                    unset($divideString[$yk][$st]);
                }
            }
        }

        $arrayOperandosUnicos = array();
        foreach ($divideString as $yk => $str) {
            foreach ($str as $kkyy => $val) {
                $arrayOperandosUnicos[] = strtolower($val);
            }
        }
        return count($arrayOperandosUnicos);
    }

    public
    function hln1($string = null)
    {
        $string = $this->clearString($string);
        $operators = " - , + ,+=,-=,*=,/=,%=,&=,^=,|=, = ,expr++,expr--,++expr,--expr,+expr,-expr, ~ , ! ,*, / , % ,==,!=, & ,^, | , && , || , ? , : ,instanceof,&gt;=,&lt;=, &lt; , &gt; ," .
            "&lt;&lt;,&gt;&gt;,&gt;&gt;&gt;,&lt;&lt;=,&gt;&gt;=,&gt;&gt;&gt;=";
        $arrayOperators = explode(',', $operators);
        $list = array();
//        pr($string);
        foreach ($arrayOperators as $operator) {
            $validate = substr_count($string, $operator);
            if ($validate != 0) {
                $list[] = $operator;
            }
        }
        return count(array_unique($list));
    }

    public
    function hl_N1($string = null)
    {
        $string = $this->clearString($string);
        $operators = " - , + ,+=,-=,*=,/=,%=,&=,^=,|=, = ,expr++,expr--,++expr,--expr,+expr,-expr, ~ , ! ,*, / , % ,==,!=, & ,^, | , && , || , ? , : ,instanceof,&gt;=,&lt;=, &lt; , &gt; ," .
            "&lt;&lt;,&gt;&gt;,&gt;&gt;&gt;,&lt;&lt;=,&gt;&gt;=,&gt;&gt;&gt;=";
        $arrayOperators = explode(',', $operators);
        $list = array();
        foreach ($arrayOperators as $key => $operator) {
            $validate = substr_count($string, $operator);
            if ($validate != 0) {
                $list[$operator] = $validate;
            }
        }
        return array_sum($list);
    }

    public
    function locAndAmloc($string = null)
    {
        $string = $this->clearString($string);
        $numLoc = substr_count($string, "\n");
        return $numLoc;
    }

    public
    function countblanklines($string)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        foreach ($str as $value) {
            $value = preg_replace('/\s+/', '', $value);
            $value = trim($value);
            if ($value !== '') {
                $arrayComp[] = 0;
            } else {
                $arrayComp[] = 1;
            }
        }
        return array_sum($arrayComp);
    }

    public
    function countatribution_max($string)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        foreach ($str as $value) {
            $occ1 = substr_count($value, ' = ');
            $arrayComp[] = $occ1;
        }
        return max($arrayComp);
    }

    public
    function countatribution_avg($string)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        $average = 0;
        foreach ($str as $value) {
            $occ1 = substr_count($value, ' = ');
            $arrayComp[] = $occ1;
        }
        if (max($arrayComp) > 0) {
            $arrayComp = array_filter($arrayComp);
            $average = array_sum($arrayComp) / count($arrayComp);
        }
        return $average;
    }

    public
    function countcomparators_max($string)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        foreach ($str as $value) {
            $occ1 = substr_count($value, '==');
            $occ1 += substr_count($value, '!=');
            $occ1 += substr_count($value, '!=');
            $occ1 += substr_count($value, ' &gt; ');
            $occ1 += substr_count($value, ' &lt; ');
            $occ1 += substr_count($value, '&gt;=');
            $occ1 += substr_count($value, '&lt;=');
            $occ1 += substr_count($value, '&&');
            $occ1 += substr_count($value, '||');
            $arrayComp[] = $occ1;
        }
        return max($arrayComp);
    }

    public
    function countcomparators_avg($string)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        $average = 0;
        foreach ($str as $value) {
            $occ1 = substr_count($value, '==');
            $occ1 += substr_count($value, '!=');
            $occ1 += substr_count($value, '!=');
            $occ1 += substr_count($value, ' &gt; ');
            $occ1 += substr_count($value, ' &lt; ');
            $occ1 += substr_count($value, '&gt;=');
            $occ1 += substr_count($value, '&lt;=');
            $occ1 += substr_count($value, '&&');
            $occ1 += substr_count($value, '||');
            $arrayComp[] = $occ1;
        }
        if (max($arrayComp) > 0) {
            $arrayComp = array_filter($arrayComp);
            $average = array_sum($arrayComp) / count($arrayComp);
        }
        return $average;
    }

    public
    function countoperations_max($string)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        foreach ($str as $value) {
            $occ1 = substr_count($value, '+');
            $occ1 += substr_count($value, '-');
            $occ1 += substr_count($value, '*');
            $occ1 += substr_count($value, '%');
            $occ1 += substr_count($value, '/');
            $arrayComp[] = $occ1;
        }
        return max($arrayComp);
    }

    public
    function countoperations_avg($string)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        $average = 0;
        foreach ($str as $value) {
            $occ1 = substr_count($value, '+');
            $occ1 += substr_count($value, '-');
            $occ1 += substr_count($value, '*');
            $occ1 += substr_count($value, '%');
            $occ1 += substr_count($value, '/');
            $arrayComp[] = $occ1;
        }
        if (max($arrayComp) > 0) {
            $arrayComp = array_filter($arrayComp);
            $average = array_sum($arrayComp) / count($arrayComp);
        }
        return $average;
    }

    public
    function countparents_max($string)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        foreach ($str as $value) {
            $occ1 = substr_count($value, '(');
            $arrayComp[] = $occ1;
        }
        return max($arrayComp);
    }

    public
    function countparents_avg($string)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        $average = 0;
        foreach ($str as $value) {
            $occ1 = 0;
            $occ2 = 0;
            $occ1 = substr_count($value, '(');
            $arrayComp[] = $occ1;
        }
        if (max($arrayComp) > 0) {
            $arrayComp = array_filter($arrayComp);
            $average = array_sum($arrayComp) / count($arrayComp);
        }
        return $average;
    }

    public
    function countspaces_max($string)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        foreach ($str as $value) {
            $occ1 = substr_count($value, ' ');
            $arrayComp[] = $occ1;
        }
//        pr($arrayComp);exit();
        return max($arrayComp);
    }

    public
    function countspaces_avg($string)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        $average = 0;
        foreach ($str as $value) {
            $occ1 = 0;
            $occ2 = 0;
            $occ1 = substr_count($value, ' ');
            $arrayComp[] = $occ1;
        }
        if (max($arrayComp) > 0) {
            $arrayComp = array_filter($arrayComp);
            $average = array_sum($arrayComp) / count($arrayComp);
        }
        return $average;
    }

    public
    function countvirgulas_max($string)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        foreach ($str as $value) {
            $occ1 = substr_count($value, ',');
            $arrayComp[] = $occ1;
        }
        return max($arrayComp);
    }

    public
    function countvirgulas_avg($string)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        $average = 0;
        foreach ($str as $value) {
            $occ1 = 0;
            $occ2 = 0;
            $occ1 = substr_count($value, ',');
            $arrayComp[] = $occ1;
        }
        if (max($arrayComp) > 0) {
            $arrayComp = array_filter($arrayComp);
            $average = array_sum($arrayComp) / count($arrayComp);
        }
        return $average;
    }

    public
    function countperiods_max($string)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        foreach ($str as $value) {
            $occ1 = substr_count($value, '.');
            $arrayComp[] = $occ1;
        }
        return max($arrayComp);
    }

    public
    function countperiods_avg($string)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        $average = 0;
        foreach ($str as $value) {
            $occ1 = 0;
            $occ2 = 0;
            $occ1 = substr_count($value, '.');
            $arrayComp[] = $occ1;
        }
        if (max($arrayComp) > 0) {
            $arrayComp = array_filter($arrayComp);
            $average = array_sum($arrayComp) / count($arrayComp);
        }
        return $average;
    }

    public
    function countComments_max($string)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        foreach ($str as $value) {
            $occ1 = substr_count($value, '//');
            $occ2 = substr_count($value, '/*');
            $arrayComp[] = $occ1 + $occ2;
        }
        return max($arrayComp);
    }

    public
    function countComments_avg($string)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        $average = 0;
        foreach ($str as $value) {
            $occ1 = 0;
            $occ2 = 0;
            $occ1 = substr_count($value, '//');
            $occ2 = substr_count($value, '/*');
            $arrayComp[] = $occ1 + $occ2;
        }
        if (max($arrayComp) > 0) {
            $arrayComp = array_filter($arrayComp);
            $average = array_sum($arrayComp) / count($arrayComp);
        }
        return $average;
    }

    public
    function countDigits_max($string)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        foreach ($str as $value) {
            $arrayComp[] = preg_match_all("/[0-9]/", $value);
        }
        return max($arrayComp);
    }

    public
    function countDigits_avg($string)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        $average = 0;
        foreach ($str as $value) {
            $arrayComp[] = preg_match_all("/[0-9]/", $value);
        }
        if (max($arrayComp) > 0) {
            $arrayComp = array_filter($arrayComp);
            $average = array_sum($arrayComp) / count($arrayComp);
        }
        return $average;
    }

    public
    function qtd_identifiers_max($string = null)
    {
        $string = $this->clearString($string);
        $keywords = 'abstract,continue,forEach,for,new,switch,assert,default,goto,package,synchronized,boolean,do,if,private,this,break,double,implements,protected,throw,byte,else,import,public,throws,case,enum,instanceof,return,transient,catch,extends,int,short,try,char,final,interface,static,void,class,finally,long,strictfp,volatile,const,float,native,super,while,null';
        $keywords = explode(',', $keywords);

        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $str = array_filter($str);
        $arrayComp = array();
        foreach ($str as $value) {
            foreach ($keywords as $key) {
                if (strstr($value, $key)) {
                    $value = str_replace($key, ' ', $value);
                }
            }
            $value = strip_tags($value);
            $value = str_replace('&gt', ' ', $value);
            $value = str_replace('&lt', ' ', $value);
            $value = preg_replace('/\s+/', ' ', trim($value));
            $value = preg_replace('/[^A-Za-z0-9\-]/', ' ', $value);
            $value = str_replace('-', ' ', $value);
            $value = str_replace('+', ' ', $value);
            $value = str_replace('%', ' ', $value);
            $value = str_replace('@', ' ', $value);

            $words = explode(" ", $value);
            $words = array_filter($words);

            $arrayComp[] = count($words);
        }
        return max($arrayComp);
    }

    public
    function qtd_identifiers_avg($string = null)
    {
        $string = $this->clearString($string);
        $keywords = 'abstract,continue,forEach,for,new,switch,assert,default,goto,package,synchronized,boolean,do,if,private,this,break,double,implements,protected,throw,byte,else,import,public,throws,case,enum,instanceof,return,transient,catch,extends,int,short,try,char,final,interface,static,void,class,finally,long,strictfp,volatile,const,float,native,super,while,null';
        $keywords = explode(',', $keywords);

        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $str = array_filter($str);
        $arrayComp = array();
        foreach ($str as $value) {
            foreach ($keywords as $key) {
                if (strstr($value, $key)) {
                    $value = str_replace($key, ' ', $value);
                }
            }
            $value = strip_tags($value);
            $value = str_replace('&gt', ' ', $value);
            $value = str_replace('&lt', ' ', $value);
            $value = preg_replace('/\s+/', ' ', trim($value));
            $value = preg_replace('/[^A-Za-z0-9\-]/', ' ', $value);
            $value = str_replace('-', ' ', $value);
            $value = str_replace('+', ' ', $value);
            $value = str_replace('%', ' ', $value);
            $value = str_replace('@', ' ', $value);

            $words = explode(" ", $value);
            $words = array_filter($words);
            $arrayComp[] = count($words);
        }
        if (count($arrayComp)) {
            $arrayComp = array_filter($arrayComp);
            $average = array_sum($arrayComp) / count($arrayComp);
            return $average;
        }
    }

    public
    function uq_qtd_identifiers_max($string = null)
    {
        $string = $this->clearString($string);
        $keywords = 'abstract,continue,forEach,for,new,switch,assert,default,goto,package,synchronized,boolean,do,if,private,this,break,double,implements,protected,throw,byte,else,import,public,throws,case,enum,instanceof,return,transient,catch,extends,int,short,try,char,final,interface,static,void,class,finally,long,strictfp,volatile,const,float,native,super,while,null';
        $keywords = explode(',', $keywords);

        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        foreach ($str as $value) {
            foreach ($keywords as $key) {
                if (strstr($value, $key)) {
                    $value = str_replace($key, ' ', $value);
                }
            }
            $value = strip_tags($value);
            $value = str_replace('&gt', ' ', $value);
            $value = str_replace('&lt', ' ', $value);
            $value = preg_replace('/\s+/', ' ', trim($value));
            $value = preg_replace('/[^A-Za-z0-9\-]/', ' ', $value);
            $value = str_replace('-', ' ', $value);
            $value = str_replace('+', ' ', $value);
            $value = str_replace('%', ' ', $value);
            $value = str_replace('@', ' ', $value);

            $words = explode(" ", $value);
            $words = array_filter($words);
            $words = array_unique($words);
            $arrayComp[] = count($words);
        }
        return max($arrayComp);
    }

    public
    function uq_qtd_identifiers_avg($string = null)
    {
        $string = $this->clearString($string);
        $keywords = 'abstract,continue,forEach,for,new,switch,assert,default,goto,package,synchronized,boolean,do,if,private,this,break,double,implements,protected,throw,byte,else,import,public,throws,case,enum,instanceof,return,transient,catch,extends,int,short,try,char,final,interface,static,void,class,finally,long,strictfp,volatile,const,float,native,super,while,null';
        $keywords = explode(',', $keywords);

        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        foreach ($str as $value) {
            foreach ($keywords as $key) {
                if (strstr($value, $key)) {
                    $value = str_replace($key, ' ', $value);
                }
            }
            $value = strip_tags($value);
            $value = str_replace('&gt', ' ', $value);
            $value = str_replace('&lt', ' ', $value);
            $value = preg_replace('/\s+/', ' ', trim($value));
            $value = preg_replace('/[^A-Za-z0-9\-]/', ' ', $value);
            $value = str_replace('-', ' ', $value);
            $value = str_replace('+', ' ', $value);
            $value = str_replace('%', ' ', $value);
            $value = str_replace('@', ' ', $value);

            $words = explode(" ", $value);
            $words = array_filter($words);
            $words = array_unique($words);

            $arrayComp[] = count($words);
        }
        if (count($arrayComp)) {
            $arrayComp = array_filter($arrayComp);
            $average = array_sum($arrayComp) / count($arrayComp);
            return $average;
        }
    }

    public
    function qtd_keywords_max($string = null)
    {
        $string = $this->clearString($string);
        $keywords = 'abstract,continue,forEach,for,new,switch,assert,default,goto,package,synchronized,boolean,do,if,private,this,break,double,implements,protected,throw,byte,else,import,public,throws,case,enum,instanceof,return,transient,catch,extends,int,short,try,char,final,interface,static,void,class,finally,long,strictfp,volatile,const,float,native,super,while,null';
        $keywords = explode(',', $keywords);

        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        foreach ($str as $value) {
            $count = 0;
            foreach ($keywords as $key) {
                if (strstr($string, $key)) {
                    $count++;
                }
            }
            $arrayComp[] = $count;
        }
        return max($arrayComp);
    }

    public
    function qtd_keywords_avg($string = null)
    {
        $string = $this->clearString($string);
        $keywords = 'abstract,continue,forEach,for,new,switch,assert,default,goto,package,synchronized,boolean,do,if,private,this,break,double,implements,protected,throw,byte,else,import,public,throws,case,enum,instanceof,return,transient,catch,extends,int,short,try,char,final,interface,static,void,class,finally,long,strictfp,volatile,const,float,native,super,while,null';
        $keywords = explode(',', $keywords);
        $average = 0;
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        foreach ($str as $value) {
            $count = 0;
            foreach ($keywords as $key) {
                if (strstr($string, $key)) {
                    $count++;
                }
            }
            $arrayComp[] = $count;
        }
        if (max($arrayComp) > 0) {
            $arrayComp = array_filter($arrayComp);
            $average = array_sum($arrayComp) / count($arrayComp);
        }
        return $average;
    }

    public
    function cl_max($string = null)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        $arrayComp = array();
        foreach ($str as $value) {
            $value = preg_replace('~[\r\n]+~', '', $value);
            $value = trim(preg_replace('/\s+/', ' ', $value));
            $arrayComp[] = strlen($value);
        }
        return max($arrayComp);
    }

    public
    function cl_average($string = null)
    {
        $string = $this->clearString($string);
        $str = explode("<br/>", $string);
        if (count($str) == 1) {
            $str = explode("<br>", $string);
        }
        foreach ($str as $value) {
            $value = preg_replace('~[\r\n]+~', '', $value);
            $value = trim(preg_replace('/\s+/', ' ', $value));
            $arrayComp[] = strlen($value);
        }
        if (count($arrayComp)) {
            $arrayComp = array_filter($arrayComp);
            $average = array_sum($arrayComp) / count($arrayComp);
            return $average;
        }
    }

    public
    function accm($string = null)
    {
        $string = $this->clearString($string);
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
            } elseif ($metricas['Metric']['acronym'] == 'LINELENGHT') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => (int)$this->cl_max($metricas['Transformation']['code_before']),
                        'after' => (int)$this->cl_max($metricas['Transformation']['code_after']),
                        'avg_before' => (int)$this->cl_average($metricas['Transformation']['code_before']),
                        'avg_after' => (int)$this->cl_average($metricas['Transformation']['code_after']),
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'QTDIDENT') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->qtd_identifiers_max($metricas['Transformation']['code_before']),
                        'after' => $this->qtd_identifiers_max($metricas['Transformation']['code_after']),
                        'avg_before' => $this->qtd_identifiers_avg($metricas['Transformation']['code_before']),
                        'avg_after' => $this->qtd_identifiers_avg($metricas['Transformation']['code_after']),
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'QTDIDENTUNIQUE') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->uq_qtd_identifiers_max($metricas['Transformation']['code_before']),
                        'after' => $this->uq_qtd_identifiers_max($metricas['Transformation']['code_after']),
                        'avg_before' => $this->uq_qtd_identifiers_avg($metricas['Transformation']['code_before']),
                        'avg_after' => $this->uq_qtd_identifiers_avg($metricas['Transformation']['code_after']),
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'QTDKEYWORDS') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->qtd_keywords_max($metricas['Transformation']['code_before']),
                        'after' => $this->qtd_keywords_max($metricas['Transformation']['code_after']),
                        'avg_before' => $this->qtd_keywords_avg($metricas['Transformation']['code_before']),
                        'avg_after' => $this->qtd_keywords_avg($metricas['Transformation']['code_after']),
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'QTDNUMBERS') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->countDigits_max($metricas['Transformation']['code_before']),
                        'after' => $this->countDigits_max($metricas['Transformation']['code_after']),
                        'avg_before' => $this->countDigits_avg($metricas['Transformation']['code_before']),
                        'avg_after' => $this->countDigits_avg($metricas['Transformation']['code_after']),
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'QTDCOMMENTS') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->countComments_max($metricas['Transformation']['code_before']),
                        'after' => $this->countComments_max($metricas['Transformation']['code_after']),
                        'avg_before' => $this->countComments_avg($metricas['Transformation']['code_before']),
                        'avg_after' => $this->countComments_avg($metricas['Transformation']['code_after']),
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'QTDPERIODS') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->countperiods_max($metricas['Transformation']['code_before']),
                        'after' => $this->countperiods_max($metricas['Transformation']['code_after']),
                        'avg_before' => $this->countperiods_avg($metricas['Transformation']['code_before']),
                        'avg_after' => $this->countperiods_avg($metricas['Transformation']['code_after']),
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'QTDVIRGULAS') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->countvirgulas_max($metricas['Transformation']['code_before']),
                        'after' => $this->countvirgulas_max($metricas['Transformation']['code_after']),
                        'avg_before' => $this->countvirgulas_avg($metricas['Transformation']['code_before']),
                        'avg_after' => $this->countvirgulas_avg($metricas['Transformation']['code_after']),
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'QTDSPACES') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->countspaces_max($metricas['Transformation']['code_before']),
                        'after' => $this->countspaces_max($metricas['Transformation']['code_after']),
                        'avg_before' => $this->countspaces_avg($metricas['Transformation']['code_before']),
                        'avg_after' => $this->countspaces_avg($metricas['Transformation']['code_after']),
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'QTDPARENTHESES') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->countparents_max($metricas['Transformation']['code_before']),
                        'after' => $this->countparents_max($metricas['Transformation']['code_after']),
                        'avg_before' => $this->countparents_avg($metricas['Transformation']['code_before']),
                        'avg_after' => $this->countparents_avg($metricas['Transformation']['code_after']),
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'QTDCOMPARATIONS') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->countcomparators_max($metricas['Transformation']['code_before']),
                        'after' => $this->countcomparators_max($metricas['Transformation']['code_after']),
                        'avg_before' => $this->countcomparators_avg($metricas['Transformation']['code_before']),
                        'avg_after' => $this->countcomparators_avg($metricas['Transformation']['code_after']),
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'QTDATRIBUTIONS') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->countatribution_max($metricas['Transformation']['code_before']),
                        'after' => $this->countatribution_max($metricas['Transformation']['code_after']),
                        'avg_before' => $this->countatribution_avg($metricas['Transformation']['code_before']),
                        'avg_after' => $this->countatribution_avg($metricas['Transformation']['code_after']),
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'QTDBLANKLINES') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->countblanklines($metricas['Transformation']['code_before']),
                        'after' => $this->countblanklines($metricas['Transformation']['code_after']),
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'QTDARITHMETICS') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->countoperations_max($metricas['Transformation']['code_before']),
                        'after' => $this->countoperations_max($metricas['Transformation']['code_after']),
                        'avg_before' => $this->countoperations_avg($metricas['Transformation']['code_before']),
                        'avg_after' => $this->countoperations_avg($metricas['Transformation']['code_after']),
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'HLn1') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->hln1($metricas['Transformation']['code_before']),
                        'after' => $this->hln1($metricas['Transformation']['code_after'])
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'HL_N1') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->hl_N1($metricas['Transformation']['code_before']),
                        'after' => $this->hl_N1($metricas['Transformation']['code_after'])
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'HLn2') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->hln2($metricas['Transformation']['code_before']),
                        'after' => $this->hln2($metricas['Transformation']['code_after'])
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'HL_N2') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->hl_N2($metricas['Transformation']['code_before']),
                        'after' => $this->hl_N2($metricas['Transformation']['code_after'])
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'SHEntropy') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->entropy($metricas['Transformation']['code_before']),
                        'after' => $this->entropy($metricas['Transformation']['code_after'])
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'HalsteadV') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->HalsteadV($metricas['Transformation']['code_before']),
                        'after' => $this->HalsteadV($metricas['Transformation']['code_after'])
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'PostnetReadability') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->posnetReadability($metricas['Transformation']['code_before']),
                        'after' => $this->posnetReadability($metricas['Transformation']['code_after'])
                    ),
                );
                $this->Result->save($result);
            } elseif ($metricas['Metric']['acronym'] == 'PostnetReadabilityToken') {
                $this->Result->id = $metricas['Result']['id'];
                $result = array(
                    'Result' => array(
                        'before' => $this->posnetReadabilityToken($metricas['Transformation']['code_before']),
                        'after' => $this->posnetReadabilityToken($metricas['Transformation']['code_after'])
                    ),
                );
                $this->Result->save($result);
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
            if (!empty($metricas)) {
                foreach ($metricas as $key => $metrica) {
//                    pr($key);exit();
                    $this->Result->create();
                    $result = array(
                        'Result' => array(
                            'transformation_id' => $trasnformation['id'],
                            'metric_id' => $key,
                        ),
                    );
                    $this->Result->save($result);
                }
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
