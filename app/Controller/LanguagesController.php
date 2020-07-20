<?php
App::uses('AppController', 'Controller');
App::import('Controller', 'Users');
App::import('Vendor', 'XLSXReader', array('file' => 'XLSXReader/XLSXReader.php'));

class LanguagesController extends AppController
{
    function beforeFilter()
    {
        parent::beforeFilter();
        $this->layout = 'admin';
        $this->loadModel('User');
        $this->loadModel('UserLanguage');
		$this->loadModel('Answer');
		$this->loadModel('ResultQuestion');
		$this->loadModel('Result');
		$this->loadModel('Transformation');
    }

    public function oacoding(){
		ini_set('memory_limit', '4096M');
    	$filepath = WWW_ROOT . 'answers-open-axial-coding-4.xlsx';
		$xlsx = new XLSXReader($filepath);

		$array = $xlsx->getSheetData(1);
		unset($array[0]);
		foreach ($array as $key => $data) {
			$array[$key][9] = "/transformations/view/".$this->searchTransformation($data[0]);
			$array[$key][10] = "P".$this->searchParticipant($data[1]);
		}
		$categories = array();
		$k = 0;
		foreach ($array as $key => $categorie){
			if($categorie[5] == 'bad example'){
				continue;
			}else {
				$categories[$k] = trim($categorie[4]);
			}
			$k++;
		}

		$categories = array_unique($categories);

//		exit();
		$subcategories = array();
		$sk = 0;
		foreach ($array as $key => $subcategorie){
			if($subcategorie[5] == 'bad example'){
				continue;
			}
			$kk = array_search($subcategorie[4], $categories);
//			pr($subcategorie[4]);
//			pr($categories);
//			pr($kk);
//			pr("teste");
			$subcategories[$categories[$kk]][$sk] = trim($subcategorie[5]);
			$sk++;
		}
		foreach ($subcategories as $key => $sub){
			$subcategories[$key] = array_unique($sub);
		}
//		pr($subcategories);
//		exit();

		//pr($array);exit();
		$this->set(compact('array'));
	}

	public function searchTransformation($answerId = null){
    	$transformationId = $this->Answer->find('first', array(
    		'recursive' => 2,
    		'conditions' => array(
    			'Answer.id' => $answerId
			)
			));
    	return $transformationId["ResultQuestion"]['Result']['transformation_id'];
	}

	public function searchParticipant($resp=null)
	{
		$Responser = $this->Answer->find('first', array(
			'recursive' => 1,
			'conditions' => array(
				'Answer.justify LIKE' => "%".trim(substr($resp, -15))."%"
			)
		));
		if (sizeof($Responser) < 1) {
		pr("Não achou o participant");
//		pr(trim(substr($resp, 0, 30)));
//		pr($Responser);
		} else {
		return $Responser["Answer"]['user_id'];
		}
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
                        'formation' => $this->request->data['User']['formation'],
						'profession' => $this->request->data['User']['profession']
                    )
                );

//                pr($update);exit();

                $this->User->save($update);
                // $this->Session->setFlash(__('Experiência vinculada com sucesso.'), 'Flash/success');
                $this->redirect(array('controller' => 'questions', 'action' => 'likert',$getUser['User']['id']));
            }
        }elseif(!empty($getUser) && !empty($getUser['Language'])){
				//$this->redirect(array('controller' => 'questions', 'action' => 'likert',$getUser['User']['id']));
		}
        $linguagem = $this->Language->find('first', array(
            'conditions' => array(
                'Language.id' => $language
            ),
            'recursive' => -1
        ));
        $this->set(compact('linguagem','getUser'));
    }

    public function edit()
    {

    }

    public function delete()
    {

    }
}
