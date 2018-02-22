<?php
App::uses('AppModel', 'Model');

class UsersLanguage extends AppModel
{
	public $validate = array(
		'user_id' => array(
			'user_id' => array(
				'rule' => 'notBlank',
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.'
			)
		),
		'language_id' => array(
			'language_id' => array(
				'rule' => 'notBlank'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.'
			)
		)
	);

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'users_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'with' => '',
		),
		'Language' => array(
			'className' => 'Language',
			'foreignKey' => 'languages_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'with' => '',
		)
	);
}
