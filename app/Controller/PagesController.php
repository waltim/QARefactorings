<?php

/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link https://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{

	/**
	 * This controller does not use a model
	 *
	 * @var array
	 */
	public $uses = array('Transformation', 'Metric', 'Language', 'Result', 'Question', 'Answer', 'User','ResultQuestion');

	public function beforeFilter()
	{
		parent::beforeFilter();
        $this->layout = 'admin';
        if($this->Auth->user() != null) {
            $id = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->Auth->user('id')
                )
            ));
            if ($id['User']['trophy'] < 66 && $id['UserType']['description'] == 'candidato') {
                $this->redirect(array('controller' => 'questions', 'action' => 'likert'));
            }
        }
	}

	/**
	 * Displays a view
	 *
	 * @return CakeResponse|null
	 * @throws ForbiddenException When a directory traversal attempt.
	 * @throws NotFoundException When the view file could not be found
	 *   or MissingViewException in debug mode.
	 */
	public function display()
	{
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		if (in_array('..', $path, true) || in_array('.', $path, true)) {
			throw new ForbiddenException();
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}


	}

	public function home()
	{
		if ($this->Auth->user('UserType.description') == 'administrador') {
			$transformations = $this->Transformation->find('count');
			$users = $this->User->find('count');
			$answers = $this->Answer->find('count');
			$questions = $this->Question->find('count');
			$this->set(compact('transformations', 'answers', 'questions', 'users'));
		} elseif ($this->Auth->user('UserType.description') == 'pesquisador') {
			$transformations = $this->Transformation->find('count', array(
				'conditions' => array('Transformation.user_id' => $this->Auth->user('id'))
			));
			$answers = $this->Answer->find('count', array(
				'conditions' => array('Answer.user_id' => $this->Auth->user('id'))
			));
			$transformtionsAll = $this->Transformation->find('all', array(
				'conditions' => array(
					'Transformation.user_id' => $this->Auth->user('id')
				)
			));
			$questions = 0;
			if (!empty($transformtionsAll)) {
				foreach ($transformtionsAll as $metrica) {
					foreach ($metrica['Metric'] as $met) {
						if ($met['id'] == 4) {
							$questions++;
						}
					}
				}
			}
			$this->set(compact('transformations', 'answers', 'questions'));
		} else {
			$answers = $this->Answer->find('count', array(
				'conditions' => array('Answer.user_id' => $this->Auth->user('id'))
			));
			$questions = $this->Question->find('count');

			$totalQuestions = $this->ResultQuestion->find('count');

			$transformations = ($totalQuestions/$questions);

			$this->set(compact('transformations', 'answers', 'questions'));
		}

		$totalQuestions = $this->ResultQuestion->find('count');

		$ranking = $this->User->find('all', array(
			'order' => array('User.trophy DESC'),
			'limit' => 100,
			'conditions' => array(
				'UserType.description !=' => 'administrador',
				'User.trophy <' => $totalQuestions
			)
		));

		$ranking2 = $this->User->find('first', array(
			'conditions' => array(
				'User.id' => $this->Session->read('Auth.User.id')
			)
		));
		// pr($ranking2);
		// exit();

		$this->set(compact('ranking', 'totalQuestions','ranking2'));
	}
}
