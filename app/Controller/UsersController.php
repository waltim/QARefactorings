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

	public function alterar()
	{
		if ($this->request->is('post')) {
			if($this->request->data['User']['funcao'] == 'cancelar'){
				$this->redirect(array('controller'=>'pages', 'action' => 'display'));
			}
			//pr($this->request->data);exit();
			$this->User->id = $this->Auth->user('id');
			if($this->request->data['User']['password'] != '' || $this->request->data['User']['password'] != null){
				$update = array(
					'User' => array(
						'name' => $this->request->data['User']['name'],
						'sex' => $this->request->data['User']['sex'],
						'password' => $this->request->data['User']['password']
					)
				);
			}else{
				$update = array(
					'User' => array(
						'name' => $this->request->data['User']['name'],
						'sex' => $this->request->data['User']['sex']
					)
				);
			}
			if($this->User->save($update)){
				$this->Session->setFlash(__('Atualizado com sucesso! Suas alterações seram mostradas a partir do proxímo login.'), 'Flash/success');
				$this->redirect(array('controller'=>'pages', 'action' => 'display'));
			}else{
				$this->Session->setFlash(__('Houve um erro, tente novamente.'), 'Flash/error');
				$this->redirect(array('controller'=>'users', 'action' => 'alterar'));
			}
		}
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
			$this->request->data['User']['status'] = 1;
			$this->request->data['User']['username'] = $this->sanitizeString($this->request->data['User']['username']);
			$this->User->create();
			if ($this->User->validates() != false && $this->User->save($this->request->data)) {
				$this->Session->setFlash(__('Usuário cadastrado com sucesso.'), 'Flash/success');
				$this->redirect(array('action' => 'login'));
			} else {
				$errors = $this->User->validationErrors;
				if (count($errors) > 0) {
					foreach ($errors as $key => $err) {
						$this->Session->setFlash(__($key . ': ' . $err[0]), 'Flash/error');
					}
				} else {
					$this->Session->setFlash(__('Houve um erro com seu cadastro, tente novamente.'), 'Flash/error');
				}
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

	function sanitizeString($str)
	{
		$str = preg_replace('/[áàãâä]/ui', 'a', $str);
		$str = preg_replace('/[éèêë]/ui', 'e', $str);
		$str = preg_replace('/[íìîï]/ui', 'i', $str);
		$str = preg_replace('/[óòõôö]/ui', 'o', $str);
		$str = preg_replace('/[úùûü]/ui', 'u', $str);
		$str = preg_replace('/[ç]/ui', 'c', $str);
		$str = preg_replace('/[^a-z0-9]/i', '_', $str);
		$str = preg_replace('/_+/', '', $str);
		return $str;
	}
}
