<?php

App::uses('AppModel', 'Model');

class Question extends AppModel
{

    public $actsAs = array('Containable');

    public $displayField = 'description';

    public $validate = array(
        'result_id' => array(
            'result_id' => array(
                'rule' => 'notBlank',
            ),
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Números apenas.'
            )
        ),
        'question_type_id' => array(
            'question_type_id' => array(
                'rule' => 'notBlank',
            ),
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Números apenas.'
            )
        )
    );

    public $belongsTo = array(
        'Participant' => array(
            'className' => 'Participant',
            'foreignKey' => 'participant_id',
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

    public $hasAndBelongsToMany = array(
        'ResultQuestion' => array(
            'className' => 'ResultQuestion',
            'joinTable' => 'results',
            'foreignKey' => 'question_id',
            'associationForeignKey' => 'result_id',
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
}
