<?php
App::uses('AppController', 'Controller');

class TransformationsController extends AppController
{
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->layout = 'admin';
		$this->loadModel('TransformationType');
		$this->loadModel('Metric');
		$this->loadModel('Language');
	}

	public function index()
	{

	}

	public function add()
	{
		if ($this->request->is('post')) {
			$uid = $this->Auth->user('id');
			$refactoring['Transformation'] = $this->request->data['Transformation'];
			$refactoring['Transformation']['user_id'] = $uid;
			unset($refactoring['Transformation']['metricas']);
			$metricas['Metrics'] = $this->request->data['Transformation']['metricas'];
			$this->Transformation->create();
			if ($this->Transformation->validates() != false && $this->Transformation->save($refactoring)) {
				if (count($metricas) > 0) {
					$this->loadModel('Result');
					$lastCreated = $this->Transformation->find('first', array(
						'conditions' => array('Transformation.user_id' => $uid),
						'order' => array('Transformation.id DESC')
					));
					$this->Result->create();
					foreach ($metricas as $metrica) {
						$result['Result']['transformation_id'] = $lastCreated['Transformation']['id'];
						$result['Result']['metric_id'] = $metrica;
						//$this->Result->save($result);
					}
					$this->Session->setFlash(__('Transformação cadastrada com sucesso.'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('Transformação cadastrada com sucesso.'));
					$this->redirect(array('action' => 'index'));
				}
			} else {
				$this->Session->setFlash(__('Houve um erro ao salvar, tente novamente.'));
			}
		}
		$this->set('languages', $this->Language->find('list', array('fields' => 'Language.description')));
		$this->set('types', $this->TransformationType->find('list', array('fields' => 'TransformationType.description')));
		$this->set('metrics', $this->Metric->find('list', array('fields' => 'Metric.acronym')));
	}

	public function edit()
	{

	}

	public function view()
	{

	}
}
