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
        $this->loadModel('ResultQuestion');
        $this->loadModel('User');
        $this->loadModel('UserLanguage');
        $this->loadModel('Participant');
    }

    public function index()
    {

    }

    public function survey($id = null)
    {

        $transformacoes = $this->Transformation->find('all', array(
            'conditions' => array(
                'Transformation.search_event_id' => $id
            )
        ));
        if ($transformacoes) {
            foreach ($transformacoes as $transformation) {
                $resultado = $this->Result->find('first', array(
                    'conditions' => array(
                        'Result.transformation_id' => $transformation['Transformation']['id'],
                        'Result.metric_id' => 4
                    )
                ));
                $questoes = $this->Participant->find('all', array(
                    'conditions' => array(
                        'Participant.search_event_id' => $id,
                        'Participant.participant_type_id' => 4
                    )
                ));

                foreach ($questoes as $participations) {
                    foreach ($participations['Question'] as $question) {
                        $this->ResultQuestion->create();
                        $survey = array(
                            'ResultQuestion' => array(
                                'result_id' => $resultado['Result']['id'],
                                'question_id' => $question['id']
                            )
                        );
                        $this->ResultQuestion->save($survey);
                    }
                }
            }

            $this->Session->setFlash(__('Survey gerado com sucesso!'), 'Flash/success');
            $this->redirect(array('controller' => 'searchEvents', 'action' => 'index'));
        }
    }

    public function cadastrar($pesquisa = null)
    {
        if ($this->request->is('post')) {

            $uid = $this->Auth->user('id');

            $this->Participant->create();

            $participant = array(
                'Participant' => array(
                    'user_id' => $uid,
                    'search_event_id' => $pesquisa,
                    'participant_type_id' => 4
                )
            );

            $this->Participant->save($participant);

            $participation = $this->Participant->find('first',
                array(
                    'conditions' => array(
                        'Participant.user_id' => $uid
                    ),
                    'order' => 'Participant.id DESC'
                )
            );


            $this->Question->create();

            $question = array(
                'Question' => array(
                    'description' => $this->request->data['Question']['description'],
                    'question_type_id' => $pesquisa,
                    'participant_id' => $participation['Participant']['id']
                )
            );

            if ($this->Question->save($question)) {
                $this->Session->setFlash(__('Questão cadastrada com sucesso!'), 'Flash/success');
                $this->redirect(array('controller' => 'searchEvents', 'action' => 'index'));
            }
        }

        $transformacao = $this->Transformation->find('first', array(
            'order' => 'rand()'
        ));

        $this->set('transformation', $transformacao);
        $this->set('pesquisa', $pesquisa);


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
                $this->redirect(array('controller' => 'pages', 'action' => 'home'));
            }
            $this->request->data['Answer']['user_id'] = $this->Auth->user('id');
            $contador = $this->Answer->find('count', array(
                'conditions' => array(
                    'Answer.user_id' => $this->request->data['Answer']['user_id'],
                    'Answer.result_question_id' => $this->request->data['Answer']['result_question_id']
                ),
                'recursive' => -1,
                'contain' => array(
                    'User',
                    'ResultQuestion' => array(
                        'Question'
                    )
                )
            ));
            if ($contador < 1) {
                $this->Answer->create();
                $this->request->data['Answer']['end_time'] = date('H:i:s');
                if ($this->Answer->save($this->request->data)) {
                    $this->User->id = $this->Auth->user('id');
                    $usuario = $this->User->find('first', array(
                        'conditions' => array(
                            'User.id' => $this->Auth->user('id'),
                        )
                    ));
                    $update = array(
                        'User' => array(
                            'trophy' => $usuario['User']['trophy'] + 1
                        )
                    );
                    $this->User->save($update);
                    $this->Session->setFlash(__('Respondido com sucesso.'), 'Flash/success');
                    $this->redirect(array('action' => 'responder'));
                }
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
                'ResultQuestion'
            ),
            'order' => array('Answer.result_question_id ASC')
        ));

        $array = $question = $this->Answer->find('all', array(
            'recursive' => 1,
            'conditions' => array(
                'Answer.user_id' => $this->Auth->user('id')
            )
        ));

        $arrayFiltrado = array();
        $k = 0;
        foreach ($array as $ar) {
            $arrayFiltrado[$k]['ResultQuestion.id !='] = $ar['ResultQuestion']['id'];
            $k++;
        }

        $question = $this->ResultQuestion->find('first', array(
            'recursive' => 3,
            'order' => 'rand()',
            'conditions' => array(
                'AND' => $arrayFiltrado
            )
        ));

        if (empty($question)) {
            $this->Session->setFlash(__('Você não possui questões para responder, volte mais tarde!'), 'Flash/info');
            $this->redirect(array('controller' => 'pages', 'action' => 'home'));
        }

        $userLanguage = $this->UserLanguage->find('count', array(
            'conditions' => array(
                'UserLanguage.language_id' => $question['Result']['Transformation']['language_id'],
                'UserLanguage.user_id' => $this->Auth->user('id')
            )
        ));

        if ($userLanguage < 1) {
            $this->Session->setFlash(__('Qual sua experiência com a linguagem abaixo?'), 'Flash/info');
            $this->redirect(array('controller' => 'languages', 'action' => 'languages', $question['Result']['Transformation']['language_id']));
        }
        $this->set('question', $question);
    }
}
