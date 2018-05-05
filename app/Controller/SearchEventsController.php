<?php
/**
 * Created by PhpStorm.
 * User: walter
 * Date: 17/04/18
 * Time: 14:22
 */

class SearchEventsController extends AppController
{

    function beforeFilter()
    {
        parent::beforeFilter();
        $this->layout = 'admin';
        $this->loadModel('SearchEvent');
        $this->loadModel('Transformation');
        $this->loadModel('Participant');
        $this->loadModel('User');
        $this->loadModel('LanguageSearchEvent');
        $this->loadModel('Language');
    }


    public function index()
    {
        if ($this->Auth->user('UserType.description') == 'administrador') {
            $participations = $this->Participant->find('all', array(
                'conditions' => array(
                    'Participant.participant_type_id' => 1
                ),
                'order' => array('Participant.search_event_id DESC')
            ));
            $pesquisas = array();
            foreach ($participations as $key => $participation) {
                $pesquisas[$key]['SearchEvent'] = $participation['SearchEvent'];
                $pesquisas[$key]['Participant'] = $participation['Participant'];
                $pesquisas[$key]['User'] = $participation['User'];
            }
        } else {
            $participations = $this->Participant->find('all', array(
                'conditions' => array(
                    'Participant.user_id' => $this->Auth->user('id')
                ),
                'order' => array('Participant.search_event_id DESC')
            ));
            $pesquisas = array();
            foreach ($participations as $key => $participation) {
                $pesquisas[$key]['SearchEvent'] = $participation['SearchEvent'];
                $pesquisas[$key]['Participant'] = $participation['Participant'];
                $pesquisas[$key]['User'] = $participation['User'];
            }
        }

        $this->set('pesquisas', $pesquisas);
    }

    public function add()
    {
        if ($this->request->is('post')) {

            $uid = $this->Auth->user('id');

            //pr($uid);exit();
            $search['SearchEvent'] = $this->request->data['SearchEvent'];
            unset($search['SearchEvent']['linguages']);
            $langs = $this->request->data['SearchEvent']['linguages'];

            $conditions = array(
                'SearchEvent.title' => $search['SearchEvent']['title']
            );

            if ($this->SearchEvent->hasAny($conditions)) {
                $this->Session->setFlash(__('Uma pesquisa com este nome já existe!'), 'Flash/error');
            } else {
                $this->SearchEvent->create();
                $this->SearchEvent->save($search);

                $lastCreated = $this->SearchEvent->find('first', array(
                    'conditions' => array('SearchEvent.title' => $search['SearchEvent']['title'])
                ));

                //pr($lastCreated);exit();

                if ($lastCreated != null) {
                    foreach ($langs as $lang) {
                        $this->LanguageSearchEvent->create();
                        $search_lang = array(
                            'LanguageSearchEvent' => array(
                                'language_id' => $lang,
                                'search_event_id' => $lastCreated['SearchEvent']['id']
                            )
                        );
                        $this->LanguageSearchEvent->save($search_lang);
                    }

                    $this->Participant->create();

                    $participant = array(
                        'Participant' => array(
                            'user_id' => $uid,
                            'search_event_id' => $lastCreated['SearchEvent']['id'],
                            'participant_type_id' => 1
                        )
                    );

                    $this->Participant->save($participant);

                    $this->Session->setFlash(__('Evento de pesquisa cadastrado com sucesso.'), 'Flash/success');
                    $this->redirect(array('controller' => 'searchEvents', 'action' => 'index'));
                }
            }
        }

        $this->set('languages', $this->Language->find('list', array('fields' => 'Language.description')));

    }

    public function edit($id = null)
    {

        if ($this->request->is('post')) {

            $data = $this->request->data;
            $data['SearchEvent']['id'] = $id;
            unset($data['SearchEvent']['linguages']);
            foreach ($this->request->data['SearchEvent']['linguages'] as $lang) {
                $conditions = array(
                    'LanguageSearchEvent.language_id' => $lang,
                    'LanguageSearchEvent.search_event_id' => $id
                );
                if ($this->LanguageSearchEvent->hasAny($conditions)) {

                } else {
                    $this->LanguageSearchEvent->create();
                    $search_lang = array(
                        'LanguageSearchEvent' => array(
                            'language_id' => $lang,
                            'search_event_id' => $id
                        )
                    );
                    $this->LanguageSearchEvent->save($search_lang);
                }
            }
            $this->SearchEvent->save($data);

            $this->Session->setFlash(__('Evento de pesquisa atualizado com sucesso!'), 'Flash/success');

            $this->redirect(array('controller' => 'searchEvents', 'action' => 'index'));
        }

        $this->set('search', $this->SearchEvent->find('first', array('conditions' => array('SearchEvent.id' => $id))));

        $this->set('languages', $this->Language->find('list', array('fields' => 'Language.description')));
        $this->set('pesquisa', $id);
    }

    public function delete($id = null)
    {

    }
}