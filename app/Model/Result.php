<?php

App::uses('AppModel', 'Model');

class Result extends AppModel{

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