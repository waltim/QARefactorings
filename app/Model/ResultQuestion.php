<?php
/**
 * Created by PhpStorm.
 * User: walter
 * Date: 02/04/18
 * Time: 11:51
 */

App::uses('AppModel', 'Model');

class ResultQuestion extends AppModel{



	public $actsAs = array('Containable');

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
        'question_id' => array(
            'question_id' => array(
                'rule' => 'notBlank',
            ),
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Números apenas.'
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
        'Question' => array(
            'className' => 'Question',
            'foreignKey' => 'question_id',
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
            'foreignKey' => 'result_question_id',
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
