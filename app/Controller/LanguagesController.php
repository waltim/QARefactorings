<?php
App::uses('AppController', 'Controller');

class LanguagesController extends AppController
{
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->layout = 'admin';
		$this->loadModel('User');
		$this->loadModel('UserLanguage');
	}

	public function index()
	{

	}

	public function add()
	{

	}

	public function languages($language = null)
	{
		if ($this->request->is('post')) {
			$this->request->data['UserLanguage']['users_id'] = $this->Auth->user('id');
			$this->UsersLanguage->create();
			if ($this->UsersLanguage->save($this->request->data)) {
				$this->Session->setFlash(__('Experiência vinculada com sucesso.'), 'Flash/success');
				$this->redirect(array('controller'=> 'questions', 'action' => 'responder'));
			}
		}
		$linguagem = $this->Language->find('first', array(
			'conditions' => array(
				'Language.id' => $language
			),
			'recursive' => -1
		));
		$this->set(compact('linguagem'));
	}

	public function edit()
	{

	}

	public function delete()
	{

	}
}
