<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController
{
	function beforeFilter()
	{
		parent::beforeFilter();
		if ($this->action == 'login' || $this->action == 'register'
			|| $this->action == 'forgot') {
			$this->layout = 'authentication';
		} else {
			$this->layout = 'admin';
		}
	}

	public function index()
	{

	}

	public function status()
	{

	}

	public function login()
	{
		if ($this->request->is('post')) {
			$user = $this->User->findByEmail($this->request->data['User']['email']);
			if (empty($user)) {
				$this->Session->setFlash(__('Email ou senha inválidos, tente novamente.'), 'Flash/error');
			} else {
				$this->request->data['User']['username'] = $user['User']['username'];
				if ($this->Auth->login()) {
					$this->Session->setFlash(__('Seja bem vindo!'), 'Flash/success');
					$this->redirect($this->Auth->redirect());
				} else {
					$this->Session->setFlash(__('Email ou senha inválidos, tente novamente.'), 'Flash/error');
				}
			}
		}
	}

	public function register()
	{
		if ($this->request->is('post')) {
			if ($this->request->params['action'] == 'register') {
				$this->request->data['User']['user_type_id'] = 1;
			}
			$name = explode('@', $this->request->data['User']['email']);
			$conditions = array(
				'User.username' => $name[0]
			);
			if ($this->User->hasAny($conditions)) {
				$date = date('Hi');
				$this->request->data['User']['username'] = $name[0] . $date;
			} else {
				$this->request->data['User']['username'] = $name[0];
			}

			$this->User->create();
			if ($this->User->validates() != false && $this->User->save($this->request->data)) {
				$this->Session->setFlash(__('Usuário cadastrado com sucesso.'), 'Flash/success');
				$this->redirect(array('action' => 'login'));
			} else {
				$this->Session->setFlash(__('Houve um erro com seu cadastro, tente novamente.'), 'Flash/error');
			}
		}
	}

	public function forgot()
	{

	}

	public function logout()
	{
		$this->redirect($this->Auth->logout());
	}
}
