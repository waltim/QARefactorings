<?php
App::uses('AppModel', 'Model');

class TransformationTypeLanguage extends AppModel {

    public $belongsTo = array(
        'TransformationType' => array(
            'className' => 'TransformationType',
            'foreignKey' => 'transformation_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'with' => '',
        ),
        'Language' => array(
            'className' => 'Language',
            'foreignKey' => 'language_id',
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
