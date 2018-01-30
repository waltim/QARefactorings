<?php
App::uses('AppModel', 'Model');

class Answer extends AppModel {

	public $validate = array(
        'user_id' => array(
            'user_id' => array(
				'rule' => 'notBlank',
			)
		),
		'question_id' => array(
            'question_id' => array(
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
}
