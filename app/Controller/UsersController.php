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
		$usuarios = $this->User->find('all', array(
			'order' => array('User.name DESC')
		));
		$this->set('usuarios', $usuarios);
	}

	public function view($id = null)
	{
		$usuario = $this->User->find('first', array(
			'conditions' => array('User.id' => $id)
		));
		$this->set(compact('usuario'));
	}

	public function edit($id = null)
	{
		$this->loadModel('UserType');
		if ($this->request->is('post')) {
			if ($this->request->data['User']['funcao'] == 'cancelar') {
				$this->redirect(array('controller' => 'users', 'action' => 'index'));
			}
			$this->User->id = $id;
			if ($this->request->data['User']['password'] != '' || $this->request->data['User']['password'] != null) {
				$update = array(
					'User' => array(
						'name' => $this->request->data['User']['name'],
						'sex' => $this->request->data['User']['sex'],
						'user_type_id' => $this->request->data['User']['user_type_id'],
						'password' => $this->request->data['User']['password']
					)
				);
			} else {
				$update = array(
					'User' => array(
						'name' => $this->request->data['User']['name'],
						'sex' => $this->request->data['User']['sex'],
						'user_type_id' => $this->request->data['User']['user_type_id']
					)
				);
			}
			if ($this->User->save($update)) {
				$this->Session->setFlash(__('Usuário atualizado com sucesso!'), 'Flash/success');
				$this->redirect(array('controller' => 'users', 'action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('Houve um erro, tente novamente.'), 'Flash/error');
				$this->redirect(array('controller' => 'users', 'action' => 'edit', $id));
			}
		}
		$usuario = $this->User->find('first', array(
			'conditions' => array('User.id' => $id)
		));
		$tipos = $this->UserType->find('list');
		$this->set(compact('usuario', 'tipos'));
	}

	public function alterar()
	{
		if ($this->request->is('post')) {
			if ($this->request->data['User']['funcao'] == 'cancelar') {
				$this->redirect(array('controller' => 'pages', 'action' => 'display'));
			}
			$this->User->id = $this->Auth->user('id');
			if ($this->request->data['User']['password'] != '' || $this->request->data['User']['password'] != null) {
				$update = array(
					'User' => array(
						'name' => $this->request->data['User']['name'],
						'sex' => $this->request->data['User']['sex'],
						'password' => $this->request->data['User']['password']
					)
				);
			} else {
				$update = array(
					'User' => array(
						'name' => $this->request->data['User']['name'],
						'sex' => $this->request->data['User']['sex']
					)
				);
			}
			if ($this->User->save($update)) {
				$this->Session->setFlash(__('Atualizado com sucesso! Suas alterações seram mostradas a partir do proxímo login.'), 'Flash/success');
				$this->redirect(array('controller' => 'pages', 'action' => 'display'));
			} else {
				$this->Session->setFlash(__('Houve um erro, tente novamente.'), 'Flash/error');
				$this->redirect(array('controller' => 'users', 'action' => 'alterar'));
			}
		}
	}

	public function status($id = null)
	{
		$this->User->id = $id;
		$usuario = $this->User->find('first', array(
			'conditions' => array('User.id' => $this->User->id)
		));
		if ($usuario['User']['status'] == 1) {
			$update = array(
				'User' => array(
					'status' => 0
				)
			);
			if ($this->User->save($update)) {
				$this->Session->setFlash(__('Usuário bloqueado com sucesso!'), 'Flash/success');
				$this->redirect(array('controller' => 'users', 'action' => 'index'));
			}
		} else {
			$update = array(
				'User' => array(
					'status' => 1
				)
			);
			if ($this->User->save($update)) {
				$this->Session->setFlash(__('Usuário liberado com sucesso!'), 'Flash/success');
				$this->redirect(array('controller' => 'users', 'action' => 'index'));
			}
		}
	}

	public function login()
	{
		if ($this->request->is('post')) {
			$user = $this->User->findByEmail($this->request->data['User']['email']);
			if (empty($user)) {
				$this->Session->setFlash(__('Email ou senha inválidos, tente novamente.'), 'Flash/error');
			} else {
				$this->request->data['User']['username'] = $user['User']['username'];
				if ($user['User']['status'] == 1) {
					if ($this->Auth->login()) {
						$this->Session->setFlash(__('Seja bem vindo!'), 'Flash/success');
						$this->redirect($this->Auth->redirect());
					} else {
						$this->Session->setFlash(__('Email ou senha inválidos, tente novamente.'), 'Flash/error');
					}
				} else {
					$this->Session->setFlash(__('Você foi banido.'), 'Flash/error');
					return false;
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
			$this->request->data['User']['trophy'] = 0;
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
