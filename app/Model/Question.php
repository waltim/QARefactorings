<?php

App::uses('AppModel', 'Model');

class Question extends AppModel{

	public $displayField = 'description';

	public $validate = array(
        'idResult' => array(
            'result_id' => array(
				'rule' => 'notBlank',
				'required' => 'create'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.'
			)
		),
		'idQuestionType' => array(
            'question_type_id' => array(
				'rule' => 'notBlank',
				'required' => 'create'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.'
			)
		),
		'description' => array(
            'description' => array(
				'rule' => 'notBlank',
				'required' => true
			)
		)
    );

    public $belongsTo = array(
        'Result' => array(
            'className' => 'Result',
            'foreignKey' => 'result_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'with' => '',
        ),
        'QuestionType' => array(
            'className' => 'QuestionType',
            'foreignKey' => 'question_type_id',
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
            'foreignKey' => 'question_id',
            'associationForeignKey' => '',
            'dependent' => true,
            'unique' => '',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'offset' => '',
            'with' => '',
        )
    );
}
