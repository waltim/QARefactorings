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
        $this->loadModel('UserLanguage');
        $this->loadModel('Result');
        $this->loadModel('Question');
        $this->loadModel('Answer');
        $this->loadModel('Transformation');
        $this->loadModel('User');
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
            'recursive' => 4,
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
        foreach ($answers as $key => $usuario) {
            $UserLanguage = $this->UserLanguage->find('first', array(
                'recursive' => -1,
                'conditions' => array(
                    'UserLanguage.user_id' => $usuario['User']['id']
                )
            ));
            $answers[$key]['User']['UserLanguage'] = $UserLanguage['UserLanguage'];
        }
        $this->set('pesquisa', $pesquisa);
        $this->set(compact('answers'));
    }
}
