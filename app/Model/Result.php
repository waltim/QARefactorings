<?php

App::uses('AppModel', 'Model');

class Result extends AppModel{

	public $validate = array(
        'idMetric' => array(
            'metric_id' => array(
				'rule' => 'notBlank',
				'required' => 'create'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.'
			)
		),
		'idTransformation' => array(
            'transformation_id' => array(
				'rule' => 'notBlank',
				'required' => 'create'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.'
			)
		),
		'before' => array(
            'before' => array(
				'rule' => array('decimal', 2),
				'allowEmpty' => false,
				'required' => true,
			)
		),
		'after' => array(
            'after' => array(
				'rule' => array('decimal', 2),
				'allowEmpty' => false,
				'required' => true,
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
        'Question' => array(
            'className' => 'Question',
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
