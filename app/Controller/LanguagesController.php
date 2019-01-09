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
            $this->request->data['UserLanguage']['user_id'] = $this->Auth->user('id');
            $this->request->data['UserLanguage']['language_id'] = $this->request->data['UsersLanguage']['languages_id'];
            unset($this->request->data['UsersLanguage']);
//            pr($this->request->data);exit();
            $this->UserLanguage->create();
            if ($this->UserLanguage->save($this->request->data)) {

                $update = array(
                    'User' => array(
                        'id' => $this->Session->read('Auth.User.id'),
                        'formation' => $this->request->data['User']['formation'],
                        'profession' => $this->request->data['User']['profession'],
                        'lambda_exp' => $this->request->data['User']['lambda_exp'],
                        'functional_program' => $this->request->data['User']['functional_program']
                    )
                );

                $this->User->save($update);
                // $this->Session->setFlash(__('Experiência vinculada com sucesso.'), 'Flash/success');
                $this->redirect(array('controller' => 'questions', 'action' => 'likert'));
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
