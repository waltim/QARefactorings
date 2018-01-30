<?php
App::uses('AppModel', 'Model');

class Transformation extends AppModel {

	public $validate = array(
        'idUser' => array(
            'user_id' => array(
				'rule' => 'notBlank',
				'required' => 'create'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.'
			)
		),
		'idLanguage' => array(
            'transformation_type_id' => array(
				'rule' => 'notBlank',
				'required' => 'create'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.'
			)
		),
		'idTransformationType' => array(
            'language_id' => array(
				'rule' => 'notBlank',
				'required' => 'create'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.'
			)
		),
		'codeBefore' => array(
            'code_before' => array(
				'rule' => 'notBlank',
				'required' => true
			)
		),
		'codeAfter' => array(
            'code_after' => array(
				'rule' => 'notBlank',
				'required' => true
			)
		)
    );

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
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
            'foreignKey' => 'language_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'with' => '',
        ),
        'TransformationType' => array(
            'className' => 'TransformationType',
            'foreignKey' => 'transformation_type_id',
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
        'Metric' => array(
                'className' => 'Metric',
                'joinTable' => 'Result',
                'foreignKey' => 'transformation_id',
                'associationForeignKey' => 'metric_id',
                'unique' => false,
                'dependent' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'with' => ''
            )
    );

}
