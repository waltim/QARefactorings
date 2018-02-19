<?php
App::uses('AppController', 'Controller');
App::import('Controller', 'Transformations');
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
			$this->Answer->create();
			$this->request->data['Answer']['user_id'] = $this->Auth->user('id');
			$this->Answer->save($this->request->data);
			$this->Session->setFlash(__('Respondido com sucesso.'), 'Flash/success');
			$this->redirect(array('action' => 'responder'));
		}

		$random = $this->Question->find('first', array(
			'conditions' => array(
				'Result.metric_id' => 4,
			),
			'order' => 'rand()',
			'recursive' => -1,
			'contain' => array(
				'Answer',
				'Result'
			)
		));

		$contador = $this->Answer->find('count', array(
			'conditions' => array(
				'Answer.user_id' => $this->Auth->user('id'),
				'Answer.question_id' => $random['Question']['id'],
			),
			'recursive' => -1,
			'contain' => array(
				'User',
				'Question'
			)
		));
		if ($contador > 0) {
			$respostas = $this->Answer->find('count', array(
				'conditions' => array(
					'Answer.user_id' => $this->Auth->user('id'),
				),
				'recursive' => -1,
				'contain' => array(
					'User',
					'Question'
				)
			));
			$respondidas = $this->Question->find('count', array(
				'conditions' => array(
					'Result.metric_id' => 4,
				),
				'recursive' => -1,
				'contain' => array(
					'Answer',
					'Result'
				)
			));
			if ($respostas >= $respondidas) {
				$this->Session->setFlash(__('Você não possui questões para responder, volte mais tarde!'), 'Flash/error');
				$this->redirect(array('controller' => 'pages', 'action' => 'home'));
			} else {
				$question = $this->Question->find('first', array(
					'conditions' => array(
						'Result.metric_id' => 4,
						'Question.id !=' => $random['Question']['id'],
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
			}
		} else {
			$question = $this->Question->find('first', array(
				'conditions' => array(
					'Result.metric_id' => 4,
					'Question.id' => $random['Question']['id'],
				),
				'recursive' => -1,
				'contain' => array(
					'Result' => array(
						'Transformation'
					),
					'Answer'
				)
			));
		}
		if (empty($question)) {
			$this->Session->setFlash(__('Você não possui questões para responder, volte mais tarde!'), 'Flash/error');
			$this->redirect(array('controller' => 'pages', 'action' => 'home'));
		}

		$transformation = new TransformationsController();
		$this->set('variable', $transformation);
		$this->set('question', $question);
	}
}
