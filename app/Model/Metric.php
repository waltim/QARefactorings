<?php
App::uses('AppModel', 'Model');

class Metric extends AppModel {

	public $displayField = 'acronym';

	public $validate = array(
        'metric_type_id' => array(
            'metric_type_id' => array(
				'rule' => 'notBlank',
				'required' => 'create'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.'
			)
		),
		'acronym' => array(
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'allowEmpty' => false,
                'required' => true,
                'message' => 'Letras e números somente.'
            ),
            'between' => array(
                'rule' => array('lengthBetween', 2, 10),
                'message' => 'Obrigatório entre 2 a 10 caracteres.'
            )
		),
		'description' => array(
            'description' => array(
				'rule' => 'notBlank',
				'allowEmpty' => false,
				'required' => true,
			)
		)
    );

    public $belongsTo = array(
        'MetricType' => array(
            'className' => 'MetricType',
            'foreignKey' => 'metric_type_id',
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
        'Transformation' => array(
                'className' => 'Transformation',
                'joinTable' => 'Result',
                'foreignKey' => 'metric_id',
                'associationForeignKey' => 'transformation_id',
                'unique' => false,
                'dependent' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'with' => ''
            )
    );

}
