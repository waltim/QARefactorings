<?php
App::uses('AppController', 'Controller');

class AnswersController extends AppController
{
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->layout = 'admin';
		$this->loadModel('TransformationType');
        $this->loadModel('Metric');
        $this->loadModel('Language');
        $this->loadModel('Result');
        $this->loadModel('Question');
		$this->loadModel('Answer');
		$this->loadModel('Transformation');
	}

	public function relatorios($pesquisa = null){

		if ($pesquisa == null) {
            $transformations = $this->Transformation->find('all', array(
                'order' => array('Transformation.id DESC'),
            ));
        } else {
            $transformations = $this->Transformation->find('all', array(
                'conditions' => array(
                    'Transformation.search_event_id' => $pesquisa,
                ),
                'order' => array('Transformation.id DESC'),
            ));
        }

        $this->set(compact('transformations'));
        $this->set('pesquisa', $pesquisa);

	}
}
