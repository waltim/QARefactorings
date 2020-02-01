<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
	public $components = array(
		'Session',
		'Auth' => array(
			'loginRedirect' => array('controller' => 'Languages', 'action' => 'languages',1),
			'logoutRedirect' => array('controller' => 'Users', 'action' => 'login'),
			'Form' => array(
				'fields' => array('username' => 'email')
			),
			'authorize' => array('Controller')
		)
	);

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('login', 'likert', 'languages', 'end');
//		$this->Auth->allow('login');
	}

	public function isAuthorized($user)
	{
		$usuarioLogado = ClassRegistry::init('User')->find('first', array(
			'conditions' => array('User.id' => $user['id'])
		));
		if ($usuarioLogado['User']['status'] == 0) {
			$this->Session->setFlash(__('Você foi banido.'), 'Flash/error');
			$this->redirect($this->Auth->logout());
		}
		if (isset($user['status']) && $user['UserType']['description'] === 'administrador') {
			return true; // Admin pode acessar todas as actions;
		} elseif (isset($user['status']) && $user['UserType']['description'] === 'pesquisador') {
			if (in_array($this->action, array(
				'logout', 'home', 'languages', 'likert',
				'relatorios', 'locAndAmloc', 'accm', 'manipulaMetricas'
			)) || ($this->params['controller'] === 'transformations' && in_array($this->action, array('add', 'view', 'index')))) {
					// Todos os pesquisadores podem criar transformações;
				return true;
			} elseif (in_array($this->action, array('edit', 'delete'))) {
				$postId = (int)$this->request->params['pass'][0];
				if ($this->Transformation->isOwnedBy($postId, $user['id']) === true) {
					return true;
				} else {
					$this->Session->setFlash(__('Você não tem permissão para isso.'), 'Flash/error');
					return false;
				}
			} elseif (in_array($this->action, array('alterar'))) {
				if ($this->User->isOwnedBy($user['id']) === true) {
					return true;
				} else {
					$this->Session->setFlash(__('Você não tem permissão para isso.'), 'Flash/error');
					return false;
				}
			} else {
				$this->Session->setFlash(__('Você não tem permissão para isso.'), 'Flash/error');
				return false;
			}
		} elseif (isset($user['status']) && $user['UserType']['description'] === 'candidato') {
			if ($this->params['action'] === 'likert' || $this->params['action'] === 'home'
				|| $this->params['action'] === 'logout' || $this->params['action'] === 'languages') {
				// Todos os candidatos podem ver a página inicial, responder questões e sair do sistema.
				return true;
			} elseif (in_array($this->action, array('alterar'))) {
				if ($this->User->isOwnedBy($user['id']) === true) {
					return true;
				} else {
					$this->Session->setFlash(__('Você não tem permissão para isso.'), 'Flash/error');
					return false;
				}
			} else {
				$this->Session->setFlash(__('Você não tem permissão para isso.'), 'Flash/error');
				return false;
			}
		} else {
			$this->Session->setFlash(__('Você não tem permissão para isso.'), 'Flash/error');
			return false; // Os outros usuários não podem
		}
	}
}
