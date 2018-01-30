<?php
App::uses('AppModel', 'Model');

class User extends AppModel {

    public $displayField = 'username';

    public $validate = array(
        'username' => array(
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Use apenas letras e números.'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'required' => 'create',
                'message' => 'Este nome de usuário já está sendo usado.'
            )
        ),
        'password' => array(
            'password' => array(
                'rule' => array('minLength', '8'),
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Mínimo de 8 caracteres permitido.'
            ),
            'required' => array(
                'rule' => 'notBlank',
                'required' => 'create'
            )
        ),
        'email' => array(
            'email' => array(
                'rule' => 'email',
                'required' => true,
                'allowEmpty' => false,
                'on' => 'create',
                'message' => 'Deve ser informado um e-mail válido.'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'required' => 'create',
                'message' => 'Este e-mail já está sendo usado.'
            ),
            'required' => array(
                'rule' => 'notBlank',
                'required' => 'create',
                'message' => 'Este campo deve ser preenchido.'
            ),
		),
		'idUserType' => array(
            'user_type_id' => array(
				'rule' => 'notBlank',
				'required' => 'create'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.'
			)
		)
    );

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
        )
    );

}
