<?php
App::uses('AppController', 'Controller');

class AnswersController extends AppController
{
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->layout = 'admin';
	}

	public function relatorios(){

	}
}
