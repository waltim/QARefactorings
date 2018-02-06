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
		if ($this->request->is('post')) {
			$user = $this->User->findByEmail($this->request->data['User']['email']);
			$this->request->data['User']['username'] = $user['User']['username'];
			if ($this->Auth->login()) {
				$this->Session->setFlash(__('Seja bem vindo!'));
				$this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__('Email ou senha inválidos, tente novamente.'));
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
				$this->Session->setFlash(__('Usuário cadastrado com sucesso.'));
				$this->redirect(array('action' => 'login'));
			} else {
				$this->Session->setFlash(__('Houve um erro com seu cadastro, tente novamente.'));
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
