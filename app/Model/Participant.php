<?php

App::uses('AppModel', 'Model');

class Participant extends AppModel{

	public $actsAs = array('Containable');

	public $displayField = 'description';

	public $validate = array(
        'user_id' => array(
            'user_id' => array(
				'rule' => 'notBlank',
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.'
			)
		),
		'search_event_id' => array(
            'search_event_id' => array(
				'rule' => 'notBlank',
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.'
			)
		),
        'participant_type_id' => array(
            'participant_type_id' => array(
                'rule' => 'notBlank',
            ),
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Números apenas.'
            )
        )
    );

    public $belongsTo = array(
        'ParticipantType' => array(
            'className' => 'ParticipantType',
            'foreignKey' => 'participant_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'with' => '',
        ),
        'SearchEvent' => array(
            'className' => 'SearchEvent',
            'foreignKey' => 'search_event_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'with' => '',
        ),
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
        )
    );

    public $hasMany = array(
        'Question' => array(
            'className' => 'Question',
            'joinTable' => '',
            'foreignKey' => 'participant_id',
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
