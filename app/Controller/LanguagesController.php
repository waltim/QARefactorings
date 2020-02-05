<?php
App::uses('AppController', 'Controller');
App::import('Controller', 'Users');

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
		$Users = new UsersController();
		$ip = $Users->getUserIpAddr();
		//pr($ip);
		$Users->login($ip);
		$getUser = $this->User->find('first', array(
			'conditions' => array('User.ip_adress' => $ip),
			'order' => array('User.created DESC'),
		));
		//pr($getUser);
        if ($this->request->is('post')) {
            $this->request->data['UserLanguage']['user_id'] = $getUser['User']['id'];
            $this->request->data['UserLanguage']['language_id'] = $this->request->data['UsersLanguage']['languages_id'];
            unset($this->request->data['UsersLanguage']);
//            pr($this->request->data);exit();
            $this->UserLanguage->create();
            if ($this->UserLanguage->save($this->request->data)) {

                $update = array(
                    'User' => array(
                        'id' => $getUser['User']['id'],
                        'formation' => $this->request->data['User']['formation']
                    )
                );

//                pr($update);exit();

                $this->User->save($update);
                // $this->Session->setFlash(__('Experiência vinculada com sucesso.'), 'Flash/success');
                $this->redirect(array('controller' => 'questions', 'action' => 'likert',$getUser['User']['id']));
            }
        }elseif(!empty($getUser) && !empty($getUser['Language'])){
				$this->redirect(array('controller' => 'questions', 'action' => 'likert',$getUser['User']['id']));
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
