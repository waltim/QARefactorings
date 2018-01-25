<?php

App::uses('AppModel', 'Model');

class Question extends AppModel{

    public $displayField = 'description';

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