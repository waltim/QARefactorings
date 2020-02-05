<?php
App::uses('AppController', 'Controller');
App::import('Controller', 'Users');
// App::import('Controller', 'Transformations');
class QuestionsController extends AppController
{
    public function beforeFilter()
    {
        parent::beforeFilter();
        if ($this->action == 'responder') {
            $this->layout = 'questionario';
        } elseif ($this->action == 'likert') {
            $this->layout = 'survey';
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
        $this->loadModel('TransformationType');
    }

    public function index()
    {

    }

    public function deleteSurvey()
    {
        $questoesSurvey = $this->ResultQuestion->find('all');
        foreach ($questoesSurvey as $resquestion) {
            $this->ResultQuestion->delete($resquestion['ResultQuestion']['id']);
        }
        $this->redirect(array('controller' => 'searchEvents', 'action' => 'index'));
    }

    public function survey($id = null)
    {
        $numberOfTransformations = $this->Transformation->find('count', array(
            'conditions' => array(
                'Transformation.search_event_id' => $id,
                'Transformation.apt' => "S",
            ),
        ));

        $numberOfTypes = $this->TransformationType->find('count');

        // $getAmostration = ($numberOfTransformations / $numberOfTypes);
//        $getAmostration = 100;
        // pr($getAmostration);
        // pr(ceil($getAmostration));
        // exit();
        $allTransformationType = $this->TransformationType->find('all', array(
            'recursive' => -1
        ));

//        pr($allTransformationType);exit();
        $arrayFiltradoWeBMiner = array();
        $arrayFiltradoRjtl = array();
        $arrayFiltrado = array();

        $k = 0;
        $y = 0;
        foreach ($allTransformationType as $type) {

            $transfPorTipo = $this->Transformation->find('all', array(
                'recursive' => -1,
                'order' => 'rand()',
                'conditions' => array(
                    'Transformation.search_event_id' => $id,
                    'Transformation.apt' => "S",
                    'Transformation.transformation_type_id' => $type['TransformationType']['id'],
                    //'Transformation.id <=' => 10
                ),
//                'limit' => ceil($getAmostration)
            ));

//             pr($type);

//             if(sizeof($transfPorTipo2) > 0){
            foreach ($transfPorTipo as $ar) {
                $arrayFiltradoWeBMiner[$k]['Transformation.id'] = $ar['Transformation']['id'];
                $arrayFiltradoWeBMiner[$k]['transformation_type_id'] = $type['TransformationType']['id'];
                $k++;
            }
//             }


        }

//		pr($arrayFiltradoWeBMiner);exit();

//
		$aritem = 0;
		foreach($arrayFiltradoWeBMiner as $aritem){
//			pr($aritem);exit();
			$arrayFiltrado[]['Transformation.id'] = $aritem['Transformation.id'];
			$aritem++;
		}
//		pr($aritem);exit();

//        $arrayFiltrado[]['Transformation.id'] = $arrayFiltradoWeBMiner[0]['Transformation.id'];
////        $arrayFiltrado[]['Transformation.id'] = $arrayFiltradoRjtl[0]['Transformation.id'];
//        $arrayFiltrado[]['Transformation.id'] = $arrayFiltradoWeBMiner[1]['Transformation.id'];
////        $arrayFiltrado[]['Transformation.id'] = $arrayFiltradoRjtl[1]['Transformation.id'];
//        $arrayFiltrado[]['Transformation.id'] = $arrayFiltradoWeBMiner[2]['Transformation.id'];
////        $arrayFiltrado[]['Transformation.id'] = $arrayFiltradoRjtl[3]['Transformation.id'];
//        $arrayFiltrado[]['Transformation.id'] = $arrayFiltradoWeBMiner[3]['Transformation.id'];
////        $arrayFiltrado[]['Transformation.id'] = $arrayFiltradoRjtl[4]['Transformation.id'];
//        $arrayFiltrado[]['Transformation.id'] = $arrayFiltradoWeBMiner[4]['Transformation.id'];
//        $arrayFiltrado[]['Transformation.id'] = $arrayFiltradoRjtl[6]['Transformation.id'];
//        $arrayFiltrado[]['Transformation.id'] = $arrayFiltradoWeBMiner[9]['Transformation.id'];
//        $arrayFiltrado[]['Transformation.id'] = $arrayFiltradoRjtl[8]['Transformation.id'];

//        pr($arrayFiltradoWeBMiner);
//        pr($arrayFiltradoRjtl);
//        pr($arrayFiltrado);
//        exit();
//
//        $transformacoes = $this->Transformation->find('all', array(
//            'conditions' => array(
//                'Transformation.search_event_id' => $id,
//                'Transformation.apt' => "S",
//                'OR' => $arrayFiltrado,
//            ),
//        ));

//         pr($arrayFiltrado);exit();

        if ($arrayFiltrado) {
            foreach ($arrayFiltrado as $transformation) {
//                pr($transformation);exit();
                $resultado = $this->Result->find('first', array(
                    'conditions' => array(
                        'Result.transformation_id' => $transformation['Transformation.id'],
                        'Result.metric_id' => 4,
                    ),
					"recursive" => -1
                ));

                if(empty($resultado)){
                	continue;
				}
                $questoes = $this->Participant->find('all', array(
                    'contain' => array(
                        'User',
                        'SearchEvent',
                        'Question'
                    ),
                    'joins' => array(
                        array(
                            'table' => 'questions',
                            'alias' => 'Question',
                            'type' => 'INNER',
                            'conditions' => array(
                                'Question.participant_id = Participant.id'
                            )
                        )
                    ),
                    'conditions' => array(
                        'Participant.search_event_id' => $id
                    ),
                    'order' => 'Question.id ASC'
                ));

//                pr($questoes);exit();

                foreach ($questoes as $participations) {
                    foreach ($participations['Question'] as $question) {
                        $this->ResultQuestion->create();
                        $survey = array(
                            'ResultQuestion' => array(
                                'result_id' => $resultado['Result']['id'],
                                'question_id' => $question['id'],
                            ),
                        );
//						pr($survey);exit();
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
                    'participant_type_id' => 4,
                ),
            );

            $this->Participant->save($participant);

            $participation = $this->Participant->find('first',
                array(
                    'conditions' => array(
                        'Participant.user_id' => $uid,
                    ),
                    'order' => 'Participant.id DESC',
                )
            );
            $this->Question->create();

            $question = array(
                'Question' => array(
                    'description' => $this->request->data['Question']['description'],
                    'question_type_id' => 1,
                    'participant_id' => $participation['Participant']['id'],
                ),
            );

            if ($this->Question->save($question)) {
                $this->Session->setFlash(__('Questão cadastrada com sucesso!'), 'Flash/success');
                $this->redirect(array('controller' => 'searchEvents', 'action' => 'index'));
            }
        }

        $transformacao = $this->Transformation->find('first', array(
            'order' => 'rand()',
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

    public function likert($user = null)
    {
		$Users = new UsersController();
		$ip = $Users->getUserIpAddr();
//		pr($ip);
		$Users->login($ip);
		$getUser = $this->User->find('first', array(
			'conditions' => array('User.ip_adress' => $ip),
			'order' => array('User.created DESC'),
		));

        if ($this->request->is('post')) {


            $this->request->data['Answer']['end_time'] = date('H:i:s');
//            $this->request->data['Answer']['choice'][0] = $this->request->data['check'];
//            unset($this->request->data['check']);
//            ksort($this->request->data['Answer']['choice']);
//            pr($this->request->data);
//            exit();
//            pr($this->request->data['Answer']);
//            $arr = array();
//            $arr[0] = $this->request->data['Answer']['result_question_id'][5];
//            unset($this->request->data['Answer']['result_question_id'][5]);
//
//            $arr[1] = $this->request->data['Answer']['result_question_id'][0];
//            unset($this->request->data['Answer']['result_question_id'][0]);
//            $arr[2] = $this->request->data['Answer']['result_question_id'][1];
//            unset($this->request->data['Answer']['result_question_id'][1]);
//            $arr[3] = $this->request->data['Answer']['result_question_id'][2];
//            unset($this->request->data['Answer']['result_question_id'][2]);
//            $arr[4] = $this->request->data['Answer']['result_question_id'][3];
//            unset($this->request->data['Answer']['result_question_id'][3]);
//            $arr[5] = $this->request->data['Answer']['result_question_id'][4];
//            unset($this->request->data['Answer']['result_question_id'][4]);
//
//            $arr[6] = $this->request->data['Answer']['result_question_id'][6];
//            unset($this->request->data['Answer']['result_question_id'][6]);
//
//
//            $arr[7] = $this->request->data['Answer']['result_question_id'][7];
//            unset($this->request->data['Answer']['result_question_id'][7]);
//            $arr[8] = $this->request->data['Answer']['result_question_id'][8];
//            unset($this->request->data['Answer']['result_question_id'][8]);
//            $arr[9] = $this->request->data['Answer']['result_question_id'][9];
//            unset($this->request->data['Answer']['result_question_id'][9]);
//            $arr[10] = $this->request->data['Answer']['result_question_id'][10];
//            unset($this->request->data['Answer']['result_question_id'][10]);
			//pr($this->request->data);
            $choices = array();
//            pr($this->request->data['Answer']['choice']);
            $choices[0] = $this->request->data['Answer']['choice'][1];
            unset($this->request->data['Answer']['choice'][1]);
			$choices[1] = $this->request->data['Answer']['choice'][2];
			unset($this->request->data['Answer']['choice'][2]);
            $choices[2] = $this->request->data['Answer']['choice'][3];
            unset($this->request->data['Answer']['choice'][3]);
            $choices[3] = $this->request->data['Answer']['choice'][4];
            unset($this->request->data['Answer']['choice'][3]);
//            $choices[8] = $this->request->data['Answer']['choice'][9];
//            unset($this->request->data['Answer']['choice'][9]);
//            $choices[9] = $this->request->data['Answer']['choice'][10];
//            unset($this->request->data['Answer']['choice'][10]);

            $this->request->data['Answer']['choice'] = $choices;
            //pr($this->request->data['Answer']);
            //exit();

			//pr($this->request->data['Answer']['choice']);

            $this->request->data['Answer']['user_id'] = $getUser['User']['id'];

			//pr($this->request->data['Answer']);
            if ($this->request->data['Answer']['choice'][0] == "N") {
                foreach ($this->request->data['Answer']['choice'] as $key => $cho) {
                    if ($key > 0) {
                        $this->request->data['Answer']['choice'][$key] = 'N/A';
                    }
                }
            }
            foreach ($this->request->data['Answer']['justify'] as $key => $just) {
                if ($just == "") {
                    $this->request->data['Answer']['justify'][$key] = 'N/A';
                }
            }
//            pr($this->request->data);exit();
            if ($this->request->data['Answer']['botao'] == 'pular') {
                $this->redirect(array('action' => 'likert'));
            }
            if ($this->request->data['Answer']['botao'] == 'sair') {
                $this->redirect(array('controller' => 'pages', 'action' => 'home'));
            }
            $contador = $this->Answer->find('count', array(
                'conditions' => array(
                    'Answer.user_id' => $this->request->data['Answer']['user_id'],
                    'Answer.result_question_id' => $this->request->data['Answer']['result_question_id'],
                ),
                'recursive' => -1,
                'contain' => array(
                    'User',
                    'ResultQuestion' => array(
                        'Question',
                    ),
                ),
            ));
			//pr($this->request->data);
//			pr($contador);exit();
            if ($contador < 1) {
                foreach ($this->request->data['Answer']['result_question_id'] as $key => $answer) {
                    $this->Answer->create();
                    if ($key == 1) {
                        $Newresp = array(
							'Answer' => array(
								'result_question_id' => $this->request->data['Answer']['result_question_id'][$key],
								'user_id' => $this->request->data['Answer']['user_id'],
								'justify' => null,
								'choice' => $this->request->data['Answer']['choice'][1],
								'start_time' => $this->request->data['Answer']['start_time'],
								'end_time' => $this->request->data['Answer']['end_time'],
                            ),
                        );
                    } elseif ($key == 4) {
						$Newresp = array(
							'Answer' => array(
								'result_question_id' => $this->request->data['Answer']['result_question_id'][$key],
								'user_id' => $this->request->data['Answer']['user_id'],
								'justify' => $this->request->data['Answer']['justify'][5],
								'choice' => 'N/A',
								'start_time' => $this->request->data['Answer']['start_time'],
								'end_time' => $this->request->data['Answer']['end_time'],
							),
						);
					}
					elseif ($key == 0) {
						$Newresp = array(
							'Answer' => array(
								'result_question_id' => $this->request->data['Answer']['result_question_id'][$key],
								'user_id' => $this->request->data['Answer']['user_id'],
								'justify' => null,
								'choice' => $this->request->data['Answer']['choice'][0],
								'start_time' => $this->request->data['Answer']['start_time'],
								'end_time' => $this->request->data['Answer']['end_time'],
							),
						);
					}
					elseif ($key == 2) {
						$Newresp = array(
							'Answer' => array(
								'result_question_id' => $this->request->data['Answer']['result_question_id'][$key],
								'user_id' => $this->request->data['Answer']['user_id'],
								'justify' => null,
								'choice' => $this->request->data['Answer']['choice'][2],
								'start_time' => $this->request->data['Answer']['start_time'],
								'end_time' => $this->request->data['Answer']['end_time'],
							),
						);
					}
					elseif ($key == 3) {
						$Newresp = array(
							'Answer' => array(
								'result_question_id' => $this->request->data['Answer']['result_question_id'][$key],
								'user_id' => $this->request->data['Answer']['user_id'],
								'justify' => null,
								'choice' => $this->request->data['Answer']['choice'][3],
								'start_time' => $this->request->data['Answer']['start_time'],
								'end_time' => $this->request->data['Answer']['end_time'],
							),
						);
					}
//                    else {
//                        $Newresp = array(
//                            'Answer' => array(
//                                'result_question_id' => $this->request->data['Answer']['result_question_id'][$key],
//                                'user_id' => $this->request->data['Answer']['user_id'],
//                                'justify' => null,
//                                'choice' => $this->request->data['Answer']['choice'][$key],
//                                'start_time' => $this->request->data['Answer']['start_time'],
//                                'end_time' => $this->request->data['Answer']['end_time'],
//                            ),
//                        );
//                    }
                    //pr($Newresp);
                    if ($this->Answer->save($Newresp)) {
                        $this->User->id = $getUser['User']['id'];
                        $usuario = $this->User->find('first', array(
                            'conditions' => array(
                                'User.id' => $getUser['User']['id'],
                            ),
                        ));
                        $update = array(
                            'User' => array(
                                'trophy' => $usuario['User']['trophy'] + 1,
                            ),
                        );
                        $this->User->save($update);
                    }
                }
				//exit();
                // $this->Session->setFlash(__('Respondido com sucesso.'), 'Flash/success');
                $this->redirect(array('action' => 'likert'));
            } else {
            	//pr('questão repetida');exit();
                $this->Session->setFlash(__('Esta questão já foi respondida!'), 'Flash/info');
                $this->redirect(array('controller' => 'pages', 'action' => 'end'));
            }
        }

        $respondidas = $this->Answer->find('count', array(
            'conditions' => array(
                'Answer.user_id' => $getUser['User']['id'],
            ),
            'recursive' => -1,
            'contain' => array(
                'User',
                'ResultQuestion' => array(
                    'Result'
                )
            ),
            'order' => array('Answer.result_question_id ASC'),
        ));



        $array = $this->Answer->find('all', array(
            'recursive' => -1,
            'contain' => array(
                'User',
                'ResultQuestion' => array(
                    'Result'
                )
            ),
            'conditions' => array(
                'Answer.user_id' => $getUser['User']['id'],
            ),
        ));

        $arrayFiltrado = array();
        $k = 0;
        foreach ($array as $ar) {
//            $arrayFiltrado[$k] = $ar['ResultQuestion']['Result']['transformation_id'];
			$arrayFiltrado[$k]['ResultQuestion.id !='] = $ar['ResultQuestion']['id'];
            $k++;
        }


        $question = $this->ResultQuestion->find('first', array(
            'recursive' => -1,
			'contain' => array(
				'Result' => array(
					'fields' => array('Result.*'),
					'Transformation'=> array(
						'fields' => array('Transformation.*')
					),
					'ResultQuestion' => array(
						'fields' => array('ResultQuestion.*'),
						'Question' => array(
							'fields' => array('Question.*')
						),
					)
				),
				'Answer' => array(
					'fields' => array('Answer.*')
				),
				'Question' => array(
					'fields' => array('Question.*')
				),
			),
//			'joins' => array(
//				array(
//					'table' => 'answers',
//					'alias' => 'Answer',
//					'type' => 'LEFT',
//					'conditions' => array(
//						'Answer.result_question_id = ResultQuestion.id'
//					)
//				)
//			),
			//'group' => array('Answer.id'),
			'order' => array('ResultQuestion.answer_count' => 'ASC'),
            'conditions' => array(
                'AND' => $arrayFiltrado,
//                'OR' => $arrayFiltrado
            ),
			//'fields' => array('ResultQuestion.*','count(Answer.result_question_id)')
        ));
        //pr($question);exit();
//        echo $question['Result']['transformation_id'];
//        pr($question['Result']['ResultQuestion']);exit();

        if (empty($question) || $respondidas >= 25) {
//        	pr($question);
//        	pr('travou aqui');exit();
            $this->Session->setFlash(__('Thank you for responding to the end!'), 'Flash/info');
            $this->redirect(array('controller' => 'pages', 'action' => 'end'));
        }

        $userLanguage = $this->UserLanguage->find('count', array(
            'conditions' => array(
                'UserLanguage.language_id' => $question['Result']['Transformation']['language_id'],
                'UserLanguage.user_id' => $getUser['User']['id'],
            ),
        ));

        if ($userLanguage < 1) {
            $this->Session->setFlash(__('Please fill in the information below to start the survey.'), 'Flash/info');
            $this->redirect(array('controller' => 'languages', 'action' => 'languages', $question['Result']['Transformation']['language_id']));
        }
        $this->set(array(
        	'question' => $question,
			'respondidas' => $respondidas
			));
    }

    public function responder()
    {
        if ($this->request->is('post')) {
            $this->request->data['Answer']['end_time'] = date('H:i:s');
            $this->request->data['Answer']['choice'][0] = $this->request->data['check'];
            unset($this->request->data['check']);
            ksort($this->request->data['Answer']['choice']);
            // pr($this->request->data['Answer']);exit();
            $this->request->data['Answer']['user_id'] = $this->Auth->user('id');
            if ($this->request->data['Answer']['choice'][0] == "N") {
                foreach ($this->request->data['Answer']['choice'] as $key => $cho) {
                    if ($key > 0) {
                        $this->request->data['Answer']['choice'][$key] = 'N/A';
                    }
                }
            }
            foreach ($this->request->data['Answer']['justify'] as $key => $just) {
                if ($just == "") {
                    $this->request->data['Answer']['justify'][$key] = 'N/A';
                }
            }
            //    pr($this->request->data);exit();
            if ($this->request->data['Answer']['botao'] == 'pular') {
                $this->redirect(array('action' => 'responder'));
            }
            if ($this->request->data['Answer']['botao'] == 'sair') {
                $this->redirect(array('controller' => 'pages', 'action' => 'home'));
            }
            $contador = $this->Answer->find('count', array(
                'conditions' => array(
                    'Answer.user_id' => $this->request->data['Answer']['user_id'],
                    'Answer.result_question_id' => $this->request->data['Answer']['result_question_id'],
                ),
                'recursive' => -1,
                'contain' => array(
                    'User',
                    'ResultQuestion' => array(
                        'Question',
                    ),
                ),
            ));
            if ($contador < 1) {
                foreach ($this->request->data['Answer']['choice'] as $key => $answer) {
                    $this->Answer->create();
                    if ($key > 0) {
                        $jkey = $key - 1;
                    } else {
                        $jkey = $key;
                    }
                    $Newresp = array(
                        'Answer' => array(
                            'result_question_id' => $this->request->data['Answer']['result_question_id'][$jkey],
                            'user_id' => $this->request->data['Answer']['user_id'],
                            'justify' => $this->request->data['Answer']['justify'][$jkey],
                            'choice' => $this->request->data['Answer']['choice'][$key],
                            'start_time' => $this->request->data['Answer']['start_time'],
                            'end_time' => $this->request->data['Answer']['end_time'],
                        ),
                    );
                    if ($this->Answer->save($Newresp)) {
                        $this->User->id = $this->Auth->user('id');
                        $usuario = $this->User->find('first', array(
                            'conditions' => array(
                                'User.id' => $this->Auth->user('id'),
                            ),
                        ));
                        $update = array(
                            'User' => array(
                                'trophy' => $usuario['User']['trophy'] + 1,
                            ),
                        );
                        $this->User->save($update);
                    }
                }

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
                'ResultQuestion',
            ),
            'order' => array('Answer.result_question_id ASC'),
        ));

        $array = $this->Answer->find('all', array(
            'recursive' => 1,
            'conditions' => array(
                'Answer.user_id' => $this->Auth->user('id'),
            ),
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
                'AND' => $arrayFiltrado,
            ),
        ));

        //pr($question['Result']['ResultQuestion']);exit();

        if (empty($question)) {
            $this->Session->setFlash(__('Você não possui questões para responder, volte mais tarde!'), 'Flash/info');
            $this->redirect(array('controller' => 'pages', 'action' => 'home'));
        }

        $userLanguage = $this->UserLanguage->find('count', array(
            'conditions' => array(
                'UserLanguage.language_id' => $question['Result']['Transformation']['language_id'],
                'UserLanguage.user_id' => $this->Auth->user('id'),
            ),
        ));

        if ($userLanguage < 1) {
            $this->Session->setFlash(__('Qual sua experiência com a linguagem abaixo?'), 'Flash/info');
            $this->redirect(array('controller' => 'languages', 'action' => 'languages', $question['Result']['Transformation']['language_id']));
        }
        $this->set('question', $question);
    }
}
