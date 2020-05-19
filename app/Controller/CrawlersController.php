<?php
App::uses('AppController', 'Controller');

class CrawlersController extends AppController
{

	//Com a garbage_statsextensão, descubra qual seção do seu código está acionando a coleta de lixo ineficientemente. Em solicitações da Web,
	//você pode usar a função gc_stats()para obter informações sobre execuções individuais de coleta de lixo.
	//Ligue gc_disable()antes que uma seção de código não eficiente em GC seja executada.
	//Ligue gc_enable()após a conclusão de uma seção de código que não seja eficiente em GC e depois gc_collect_cycles()para limpar.

	public function crawler($link = null)
	{
		ini_set('memory_limit', '4096M');
		set_time_limit (  0);

		$link = "https://stackoverflow.com/questions/tagged/lambda+java?tab=votes";
//		pr($link);

		if ($link == null) {
			$this->redirect(array('controller' => 'questions', 'action' => 'likert'));
		}

		$url = file_get_contents($link);
//		pr(memory_get_usage());



		$start = stripos($url, '<div class="s-pagination pager fl">');
		$end= stripos($url,'class="s-pagination--item js-pagination-item"') - 1120;

		$pagesCut = $start - $end;
		$content = substr($url, $start, $pagesCut);
//		pr($content);

		$doc1 = new \DOMDocument('1.0', 'UTF-8');
		$doc1->encoding = 'utf-8';
		$internalErrors = libxml_use_internal_errors(true);
		$doc1->loadHTML("<html><body>".utf8_encode($content)."</body></html>");
		libxml_use_internal_errors($internalErrors);
		$html =  $doc1->saveHTML();
//		pr($html);
		$dom1 = new \DOMDocument('1.0', 'UTF-8');
		$dom1->loadHTML($html);

		$classname="js-pagination-item";
		$finder = new DomXPath($dom1);
		$countPages = $finder->query("//*[contains(@class, '$classname')]");
		$arrayPages = array();
		$z = 0;
		foreach ($countPages as $pages){
			$arrayPages[$z] = trim($pages->nodeValue);
			$z++;
		}
		unset($arrayPages[array_search("Next",$arrayPages)]);
		$pages = max($arrayPages);
//		pr($pages);
		unset($url);

		$p = 1;
		while ($p <= $pages){

			pr("----------------------- EXTRACTING QUESTIONS OF PAGE : ".$p." ----------------------------");

			$page_url = file_get_contents("https://stackoverflow.com/questions/tagged/lambda%2bjava?tab=votes&page=".$p."&pagesize=50");

			$inicio = stripos($page_url, '<div id="questions" class="flush-left">');
			$fim = stripos($page_url,'class="s-pagination--item is-selected"') - 400;
			$qcut = $fim - $inicio;


			$conteudo = substr($page_url, $inicio, $qcut);
			$conteudo = str_replace("<div class=\"question-summary\"", "###<div class=\"question-summary\"", $conteudo);
			$questions = explode('###', $conteudo);


			$numberOfQuestions = sizeof($questions)-1;

			$this->extractQuestions($questions,$numberOfQuestions);
			$p++;
			unset($page_url);
		}
	}

	public function extractQuestions($array = null, $numberOfQuestions = null){

		ini_set('memory_limit', '4096M');
		set_time_limit (  0);

		$i = 1;
		$internalErrors = libxml_use_internal_errors(true);
		$objectQuestion = array();
		while ($i <= $numberOfQuestions) {

			$doc = new \DOMDocument('1.0', 'UTF-8');
			$doc->encoding = 'utf-8';
			$doc->loadHTML("<html><body>".utf8_decode($array[$i])."</body></html>");
			$html =  $doc->saveHTML();
			$dom = new \DOMDocument('1.0', 'UTF-8');
			$dom->loadHTML($html);

//			pr($html);

			$classname="question-hyperlink";
			$finder = new DomXPath($dom);
			$title = $finder->query("//*[contains(@class, '$classname')]");
			$qtitle = htmlspecialchars($title->item(0)->textContent);
			$qlink = htmlspecialchars($title->item(0)->attributes->item(0)->nodeValue);
			$objectQuestion["Question"]["title"] = $qtitle;
			$objectQuestion["Question"]["url"] = $qlink;

			$classname1="vote-count-post";
			$vote = $finder->query("//*[contains(@class, '$classname1')]");
			$qvote = htmlspecialchars($vote->item(0)->nodeValue);
			$objectQuestion["Question"]["votes"] = $qvote;

			$classname1="answered-accepted";
			$answered = $finder->query("//*[contains(@class, '$classname1')]");
			if($answered->length == 1){
				$objectQuestion["Question"]["answer_accepted"] = true;
			}else{
				$objectQuestion["Question"]["answer_accepted"] = false;
			}

			$classname2="views";
			$views = $finder->query("//*[contains(@class, '$classname2')]");
			$qviews = explode("k views",trim(htmlspecialchars($views->item(0)->textContent)));
			$objectQuestion["Question"]["views"] = $this->convertKtoThousand($qviews[0]);

			$classname3="status";
			$answers = $finder->query("//*[contains(@class, '$classname3')]");
			$qanswers = trim(htmlspecialchars($answers->item(0)->textContent));
			$qanswers = str_replace("answers","",$qanswers);
			$qanswers = str_replace("answer","",$qanswers);
			$objectQuestion["Question"]["qtd_answers"] = $qanswers;

			$classname7="user-action-time";
			$relativetime= $finder->query("//div[@class='".$classname7."']/span/@title");
			$qrelativetime = $relativetime->item(0)->textContent;
			$qrelativetime = date("Y-m-d", strtotime($qrelativetime));
			$objectQuestion["Question"]["date"] = $qrelativetime;

			$classname4="tags";
			$tags = $finder->query("//*[contains(@class, '$classname4')]");
			$tags = trim($tags->item(0)->textContent);
			$listTags = explode(" ",$tags);
			$objectQuestion["Question"]["Tags"] = $listTags;

			$classname5="user-details";
			$userDetails = $finder->query("//div[@class='".$classname5."']/a/@href");
			$userDetails = explode("/",$userDetails->item(0)->textContent);
			$user = $userDetails[3];
			$objectQuestion["Question"]["User"]["name"] = $user;

			$classname6="reputation-score";
			$reputation = $finder->query("//*[contains(@class, '$classname6')]");
			$userreputation = explode("k",trim($reputation->item(0)->textContent));
			$objectQuestion["Question"]["User"]["reputation"] = $this->convertKtoThousand($userreputation[0]);
			$objectQuestion["Question"]["description"] = null;
//			pr($objectQuestion);

			$answer_page = file_get_contents("https://stackoverflow.com".$objectQuestion["Question"]["url"]);
			$this->extractAnswers($answer_page,$objectQuestion);
			exit();
			$i++;
		}libxml_use_internal_errors($internalErrors);
		exit();
	}

	public function extractAnswers($url_resp = null, $objectQuestion = null){

		ini_set('memory_limit', '6000M');
		set_time_limit (  0);


		$start2 = stripos($url_resp, '<div id="answers">');
		$end2= stripos($url_resp,'class="bottom-notice"');
		$pagesCut2 = $start2 - intval($end2/2);
//		pr($start2);
//		pr($end2);
//		pr($pagesCut2);
		$content = substr($url_resp, $start2, $pagesCut2);
//		pr($content);exit();
		$conteudo = str_replace("<div id=\"answer-", "###<div id=\"answer-", $content);
//		pr($resps);exit();

		$doc2 = new \DOMDocument('1.0', 'UTF-8');
		$doc2->encoding = 'utf-8';
		$internalErrors = libxml_use_internal_errors(true);
		$doc2->loadHTML(utf8_encode($url_resp));
		libxml_use_internal_errors($internalErrors);
		$html =  $doc2->saveHTML();

		$dom2 = new \DOMDocument('1.0', 'UTF-8');
		$dom2->loadHTML($html);

		$classname="post-text";
		$finder = new DomXPath($dom2);
		$postText = $finder->query("//*[contains(@class, '$classname')]");
		$objectQuestion["Question"]["description"] = htmlspecialchars($postText->item(0)->nodeValue);

		$resps = explode('###', $conteudo);
		foreach ($resps as $key => $resp){
			if($key == 0){
				continue;
			}
//			pr($resp);

			$doc3 = new \DOMDocument('1.0', 'UTF-8');
			$doc3->encoding = 'utf-8';
			$internalErrors = libxml_use_internal_errors(true);
			$doc3->loadHTML("<html><body>".utf8_decode($resp)."</body></html>");
			libxml_use_internal_errors($internalErrors);
			$html2 =  $doc3->saveHTML();

			$dom3 = new \DOMDocument('1.0', 'UTF-8');
			$dom3->loadHTML($html2);

			$class="js-vote-count";
			$finder2 = new DomXPath($dom3);
			$answersv = $finder2->query("//*[contains(@class, '$class')]");
			$objectQuestion["Question"]["Answers"][$key]["votes"] = $answersv->item(0)->textContent;


			$class="post-text";
			$finder2 = new DomXPath($dom3);
			$answerspt = $finder2->query("//*[contains(@class, '$class')]");
			$objectQuestion["Question"]["Answers"][$key]["post-text"] = htmlspecialchars($answerspt->item(0)->textContent);

//			$class="post-text";
//			$finder2 = new DomXPath($dom3);
//			$answerspt = $finder2->query("//*[contains(@class, '$class')]");
//			$objectQuestion["Question"]["Answers"][$key]["post-text"] = htmlspecialchars($answerspt->item(0)->textContent);
//
//			$class="post-text";
//			$finder2 = new DomXPath($dom3);
//			$answerspt = $finder2->query("//*[contains(@class, '$class')]");
//			$objectQuestion["Question"]["Answers"][$key]["post-text"] = htmlspecialchars($answerspt->item(0)->textContent);

			$class="post-signature";
			$finder2 = new DomXPath($dom3);
			$postSignature = $finder2->query("//*[contains(@class, '$class')]");
//			pr($postSignature);

			foreach ($postSignature as $k => $sig){
				pr($sig);
				$array = array_filter(explode(" ",trim($sig->nodeValue)));
				pr($array);
				$string = $array[1];
				$month_number = date("n",strtotime($string));
				$postime = date("Y-m-d", strtotime(str_replace("'","",$array[3]).'-'.$month_number.'-'.$array[2]));

//				pr($array[0]);
//				pr($postime);

				if (array_key_exists("38", $array)) {
					$respname = $array[37].' '.$array[38];
					$respReputation = $this->convertKtoThousand($array[58]);
				}else{
					$respname = $array[37];
					$respReputation = $this->convertKtoThousand($array[57]);
				}

				$objectQuestion["Question"]["Answers"][$key]["Respondents"][$k]["action"] = $array[0];
				$objectQuestion["Question"]["Answers"][$key]["Respondents"][$k]["name"] = $respname;
				$objectQuestion["Question"]["Answers"][$key]["Respondents"][$k]["post_date"] = $postime;
				$objectQuestion["Question"]["Answers"][$key]["Respondents"][$k]["reputation"] = $respReputation;

			}

//			exit();
		}
		pr($objectQuestion);
	}

	public function convertKtoThousand($string = null){
		$string = explode("k",$string);
		$string = $string[0];
		if(strpos($string,".")){
			$string = $string."00";
			$string = str_replace(".","",$string);
		}else{
			$string = $string."000";
		}
		return $string;
	}
}
