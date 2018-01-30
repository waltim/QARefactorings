<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController
{
	function beforeFilter()
	{
		if ($this->action == 'login' || $this->action == 'register'
			|| $this->action == 'forgot') {
			parent::beforeFilter();
			$this->layout = 'authentication';
		}
	}

	public function login()
	{

	}

	public function register()
	{

	}

	public function forgot()
	{

	}
}
