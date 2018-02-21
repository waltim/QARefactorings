<?php
App::uses('AppController', 'Controller');
// App::import('Controller', 'Transformations');
class QuestionsController extends AppController
{
	function beforeFilter()
	{
		parent::beforeFilter();
		if ($this->action == 'responder') {
			$this->layout = 'questionario';
		} else {
			$this->layout = 'admin';
		}
		$this->loadModel('Transformation');
		$this->loadModel('Result');
		$this->loadModel('Answer');
		$this->loadModel('Question');
	}

	public function index()
	{

	}

	public function add()
	{

	}

	public function edit()
	{

	}

	public function view()
	{

	}

	public function responder()
	{
		if ($this->request->is('post')) {
			if ($this->request->data['Answer']['choice'] == 'pular') {
				$this->redirect(array('action' => 'responder'));
			}
			if ($this->request->data['Answer']['choice'] == 'sair') {
				$this->redirect(array('controller'=>'pages','action' => 'home'));
			}
			$this->request->data['Answer']['user_id'] = $this->Auth->user('id');
			$contador = $this->Answer->find('count', array(
				'conditions' => array(
					'Answer.user_id' => $this->request->data['Answer']['user_id'],
					'Answer.question_id' => $this->request->data['Answer']['question_id']
				),
				'recursive' => -1,
				'contain' => array(
					'User',
					'Question'
				)
			));
			if ($contador < 1) {
				$this->Answer->create();
				$this->Answer->save($this->request->data);
				$this->Session->setFlash(__('Respondido com sucesso.'), 'Flash/success');
				$this->redirect(array('action' => 'responder'));
			} else {
				$this->Session->setFlash(__('Esta questão já foi respondida!'), 'Flash/info');
				$this->redirect(array('controller' => 'pages', 'action' => 'home'));
			}
		}

		$respondidas = $this->Answer->find('all', array(
			'conditions' => array(
				'Answer.user_id' => $this->Auth->user('id'),
			),
			'recursive' => -1,
			'contain' => array(
				'User',
				'Question'
			),
			'order' => array('Question.id ASC')
		));
		$array = array();
		$key = 0;
		foreach ($respondidas as $resp) {
			$array[$key]['Question.id !='] = $resp['Question']['id'];
			$key++;
		}

		$question = $this->Question->find('first', array(
			'conditions' => array(
				'Result.metric_id' => 4,
				'AND' => $array
			),
			'recursive' => -1,
			'order' => 'rand()',
			'contain' => array(
				'Result' => array(
					'Transformation'
				),
				'Answer'
			)
		));

		if (empty($question)) {
			$this->Session->setFlash(__('Você não possui questões para responder, volte mais tarde!'), 'Flash/info');
			$this->redirect(array('controller' => 'pages', 'action' => 'home'));
		}
		$this->set('question', $question);
	}
}
