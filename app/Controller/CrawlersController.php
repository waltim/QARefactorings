<?php
App::uses('AppController', 'Controller');

class CrawlersController extends AppController
{

	public function crawler($link = null)
	{
		ini_set('memory_limit', '4096M');

		$link = "https://stackoverflow.com/questions/tagged/lambda+java?tab=votes";
		pr($link);

		if ($link == null) {
			$this->redirect(array('controller' => 'questions', 'action' => 'likert'));
		}

		$url = file_get_contents($link);
		$inicio = stripos($url, '<div id="questions" class="flush-left">');
		$fim = stripos($url,'class="s-pagination--item is-selected"') - 400;
		$quantopula = $fim - $inicio;

//		pr('inicio = '.$inicio);
//		pr('final = '.$fim);
//		pr($quantopula);
		$conteudo = substr($url, $inicio, $quantopula);
//		pr($conteudo);
		$conteudo = str_replace("<div class=\"question-summary\"", "###<div class=\"question-summary\"", $conteudo);
		$questions = explode('###', $conteudo);
		pr($questions[1]);
		$numberOfQuestions = sizeof($questions)-1;
//		pr($numberOfQuestions);
		$this->extractQuestions($questions,$numberOfQuestions);

	}

	public function extractQuestions($array = null, $numberOfQuestions = null){
		$i = 1;
//		pr($array);exit();
		while ($i <= $numberOfQuestions) {
			$doc = new DOMDocument();
			$doc->encoding = 'utf-8';
			$doc->loadHTML("<html><body>".utf8_decode($array[$i])."</body></html>");
			$html =  $doc->saveHTML();
			$dom = new DOMDocument();
			$dom->loadHTML($html);

			$classname="question-hyperlink";
			$finder = new DomXPath($dom);
			$title = $finder->query("//*[contains(@class, '$classname')]");
			$qtitle = htmlspecialchars($title->item(0)->textContent);
			$qlink = htmlspecialchars($title->item(0)->attributes->item(0)->nodeValue);
			pr($i.' - '.$qtitle);
			pr($i.' - '.$qlink);

			$classname1="vote-count-post";
			$vote = $finder->query("//*[contains(@class, '$classname1')]");
			$qvote = htmlspecialchars($vote->item(0)->nodeValue);
			pr($i.' - '.$qvote);

			$classname2="views";
			$views = $finder->query("//*[contains(@class, '$classname2')]");
			$qviews = str_replace("k views","000",trim(htmlspecialchars($views->item(0)->textContent)));
			pr($i.' - '.$qviews);

			$classname3="status";
			$answers = $finder->query("//*[contains(@class, '$classname3')]");
			$qanswers = trim(htmlspecialchars($answers->item(0)->textContent));
			$qanswers = str_replace("answers","",$qanswers);
			$qanswers = str_replace("answer","",$qanswers);
			pr($i.' - '.$qanswers);

			$classname4="tags";
			$tags = $finder->query("//*[contains(@class, '$classname4')]");
			$tags = trim($tags->item(0)->textContent);
			$listTags["Tags"] = explode(" ",$tags);
			pr($listTags);

			$classname5="user-details";
			$userDetails = $finder->query("//div[@class='".$classname5."']/a/@href");
			$userDetails = explode("/",$userDetails->item(0)->textContent);
			$user = $userDetails[3];
			pr($i.' - '.$user);

			$classname6="reputation-score";
			$reputation = $finder->query("//*[contains(@class, '$classname6')]");
			$userreputation = str_replace("k","000",trim($reputation->item(0)->textContent));
			pr($userreputation);


			$classname7="user-action-time";
			$relativetime= $finder->query("//div[@class='".$classname7."']/span/@title");
			$qrelativetime = $relativetime->item(0)->textContent;
			$qrelativetime = date("Y-m-d", strtotime($qrelativetime));
			pr($qrelativetime);exit();


			$i++;
		}exit();
	}



}
