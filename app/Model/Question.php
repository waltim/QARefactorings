<?php

App::uses('AppModel', 'Model');

class Question extends AppModel
{

    public $actsAs = array('Containable');

    public $displayField = 'description';

    public $validate = array(
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

    public $hasMany = array(
        'ResultQuestion' => array(
            'className' => 'ResultQuestion',
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
