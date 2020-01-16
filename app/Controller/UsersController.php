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

	public function login($ipadress = null)
	{
		$email = $ipadress;
//		pr($ipadress);
		if(isset($ipadress)){
			$ipadress = str_replace('.','',$ipadress);
			$email = $ipadress.'@ipadress.com';

		}
//		pr($email);
		if(isset($this->request)){
			if ($this->request->is('post') || $email != null) {
				if($email != null){
					$array['User']['email'] = $email;
				}
				$user = $this->User->findByEmail($this->request->data['User']['email']);
				if (empty($user)) {
					$this->register($this->request->data);
//				$this->Session->setFlash(__('Email ou senha inválidos, tente novamente.'), 'Flash/error');
				} else {
					$this->request->data['User']['username'] = $user['User']['username'];
					$this->request->data['User']['password'] = $this->psd();
//                pr($this->request->data);exit();
//                pr($user);exit();
					if ($user['User']['status'] == 1) {
						if ($this->Auth->login()) {
//						$this->Session->setFlash(__('Seja bem vindo!'), 'Flash/success');
							if($user['UserType']['description'] == 'administrador'){
								$this->redirect($this->Auth->redirect());
							}else{
								$this->redirect(array('controller' => 'questions','action' => 'likert'));
							}
						} else {
							$this->Session->setFlash(__('Email ou senha inválidos, tente novamente.'), 'Flash/error');
						}
					} else {
//					$this->Session->setFlash(__('Você foi banido.'), 'Flash/error');
						return false;
					}
				}
			}
		}else{
			$array = array('User'=>array('username'=>'','email'=>'','password'=>'','user_type_id'=>'','trophy'=>0,'ip_adress'=>''));
//			$array = array('User'=>array('email'=>''));
//			pr($array);exit();
			if ($email != null) {
//				pr('to aqui');exit();
				if($email != null){
					$array['User']['email'] = $email;
				}
				$user = $this->User->findByEmail($array['User']['email']);
				if (empty($user)) {
					$participantNumber = $this->User->find('count');
////					pr($participantNumber);exit();
					date_default_timezone_set('America/Sao_Paulo');
					$array['User']['username'] = 'participant'.$participantNumber;
					$array['User']['password'] = date('dmYHis');
					$array['User']['user_type_id'] = 1;
					$array['User']['ip_adress'] = 1;
//					pr($array);exit();
					$this->User->save($array);
//				$this->Session->setFlash(__('Email ou senha inválidos, tente novamente.'), 'Flash/error');
				}else{
//					pr('já tem o usuário!!');exit();
				}
			}
		}
	}

	public function getUserIpAddr(){
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			//ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			//ip pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	public function register($data = null)
	{
		if ($this->request->is('post')) {
			$this->request->data = $data;
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
			$this->request->data['User']['user_type_id'] = 1;
			$participantNumber = $this->User->find('count');
			date_default_timezone_set('America/Sao_Paulo');
			$this->request->data['User']['username'] = 'participant'.$participantNumber;
//			$this->request->data['User']['username'] = $this->sanitizeString($this->request->data['User']['username']);
			$this->request->data['User']['name'] = $this->request->data['User']['username'];
			$this->request->data['User']['password'] = $this->psd();
			$this->User->create();
			if ($this->User->validates() != false && $this->User->save($this->request->data)) {
//				$this->Session->setFlash(__('Usuário cadastrado com sucesso.'), 'Flash/success');
				$this->login($this->request->data['User']['email']);
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

	public function psd()
	{
		return '123321456';
	}
}
