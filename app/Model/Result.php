<?php

App::uses('AppModel', 'Model');

class Result extends AppModel{

	public $validate = array(
        'metric_id' => array(
            'metric_id' => array(
				'rule' => 'notBlank'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.'
			)
		),
		'transformation_id' => array(
            'transformation_id' => array(
				'rule' => 'notBlank'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.'
			)
		)
    );

    public $belongsTo = array(
        'Transformation' => array(
            'className' => 'Transformation',
            'foreignKey' => 'transformation_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'with' => '',
        ),
        'Metric' => array(
            'className' => 'Metric',
            'foreignKey' => 'metric_id',
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
            'foreignKey' => 'result_id',
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
