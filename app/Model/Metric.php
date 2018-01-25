<?php
App::uses('AppModel', 'Model');

class Metric extends AppModel {

    public $displayField = 'acronym';
    
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