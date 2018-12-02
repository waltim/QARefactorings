<?php
App::uses('AppController', 'Controller');

class AnswersController extends AppController
{
    public function beforeFilter()
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

    public function relatorios($pesquisa = null)
    {

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
        $this->set('pesquisa', $pesquisa);
        $this->set(compact('transformations'));
    }

    public function respostas($pesquisa = null)
    {
        ini_set('memory_limit', '512M');
        $answers = $this->Answer->find('all', array(
            'order' => array('Answer.id DESC'),
            'recursive' => -1,
            'contain' => array(
                'User',
                'ResultQuestion' => array(
                    'Question',
                    'Result' => array(
                        'Transformation' => array(
                            'SearchEvent',
                            'TransformationType',
                            'Language'
                        ),
                    ),
                ),
            ),
        ));
        $this->set('pesquisa', $pesquisa);
        $this->set(compact('answers'));
    }
}
