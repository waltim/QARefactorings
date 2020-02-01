<?php
App::uses('AppModel', 'Model');

class Answer extends AppModel {

	public $actsAs = array('Containable');

	public $validate = array(
        'user_id' => array(
            'user_id' => array(
				'rule' => 'notBlank',
			)
		),
		'result_question_id' => array(
            'result_question_id' => array(
				'rule' => 'notBlank',
			)
		),
		'choice' => array(
            'choice' => array(
				'rule' => 'notBlank',
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
        'ResultQuestion' => array(
            'className' => 'ResultQuestion',
            'foreignKey' => 'result_question_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'with' => '',
			'counterCache' => true
        )
    );
}
