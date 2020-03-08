<?php
App::uses('AppModel', 'Model');

class TransformationType extends AppModel {

    public $displayField = 'description';

    public $validate = array(
        'description' => array(
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Este tipo já foi cadastrado.'
            ),
            'required' => array(
                'rule' => 'notBlank',
				'allowEmpty' => false,
                'message' => 'Este campo deve ser preenchido.'
            )
        )
    );

    public $hasMany = array(
        'Transformation' => array(
            'className' => 'Transformation',
            'joinTable' => '',
            'foreignKey' => 'transformation_type_id',
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

    public $hasAndBelongsToMany = array(
        'Language' => array(
            'className' => 'Language',
            'joinTable' => 'transformation_type_languages',
            'foreignKey' => 'transformation_type_id',
            'associationForeignKey' => 'language_id',
            'unique' => false,
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => ''
        )
    );
}
