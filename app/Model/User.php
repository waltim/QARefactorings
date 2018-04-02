<?php
App::uses('AppModel', 'Model', 'AuthComponent', 'Controller/Component');

class User extends AppModel
{

	public $displayField = 'username';

	public $validate = array(
		'username' => array(
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'allowEmpty' => false,
				'message' => 'Use apenas letras e números.'
			),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'Este nome de usuário já está sendo usado.'
			)
		),
		'password' => array(
			'password' => array(
				'rule' => array('minLength', '6'),
				'allowEmpty' => false,
				'message' => 'Mínimo de 6 caracteres permitido.'
			),
			'required' => array(
				'rule' => 'notBlank',
			)
		),
		'email' => array(
			'email' => array(
				'rule' => 'email',
				'allowEmpty' => false,
				'on' => 'create',
				'message' => 'Deve ser informado um e-mail válido.'
			),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'Este e-mail já está sendo usado.'
			),
			'required' => array(
				'rule' => 'notBlank',
				'message' => 'Este campo deve ser preenchido.'
			),
		),
		'user_type_id' => array(
			'user_type_id' => array(
				'rule' => 'notBlank',
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.'
			)
		),
		'trophy' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.',
				'allowEmpty' => true
			)
		)
	);

	public function beforeSave($options = array())
	{
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}

	public $belongsTo = array(
		'UserType' => array(
			'className' => 'UserType',
			'foreignKey' => 'user_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'with' => '',
		)
	);

	public $hasMany = array(
		'Answer' => array(
			'className' => 'Answer',
			'joinTable' => '',
			'foreignKey' => 'user_id',
			'associationForeignKey' => '',
			'dependent' => true,
			'unique' => '',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'with' => '',
		),
		'Transformation' => array(
			'className' => 'Transformation',
			'joinTable' => '',
			'foreignKey' => 'user_id',
			'associationForeignKey' => '',
			'dependent' => true,
			'unique' => '',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'with' => '',
		),
        'Participant' => array(
            'className' => 'Participant',
            'joinTable' => '',
            'foreignKey' => 'user_id',
            'associationForeignKey' => '',
            'dependent' => true,
            'unique' => '',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'with' => '',
        )
	);

	public $hasAndBelongsToMany = array(
		'Language' => array(
			'className' => 'Language',
			'joinTable' => 'user_languages',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'language_id',
			'unique' => false,
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => ''
		)
	);

	public function isOwnedBy($user)
	{
		$pending = $this->find('first', array(
			'conditions' => array(
				'User.id' => $user,
			),
		));
		if ($pending['User']['email'] === AuthComponent::user('email')) {
			return true;
		} else {
			return false;
		}
	}

}
