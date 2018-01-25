<?php
App::uses('AppModel', 'Model');

class MetricType extends AppModel {

    public $displayField = 'description';

    public $validate = array(
        'description' => array(
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'required' => true,
                'message' => 'Use apenas letras e números.'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'required' => 'create',
                'message' => 'Este tipo já foi cadastrado.'
            ),
            'required' => array(
                'rule' => 'notBlank',
                'required' => 'create',
                'allowEmpty' => false,
                'message' => 'Este campo deve ser preenchido.'
            )
        )
    );

    public $hasMany = array(
        'Metric' => array(
            'className' => 'Metric',
            'joinTable' => '',
            'foreignKey' => 'metric_id',
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