<?php
App::uses('AppModel', 'Model');

class Language extends AppModel {

    public $displayField = 'description';

    public $validate = array(
        'description' => array(
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'message' => 'Use apenas letras e números.'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Esta linguagem já foi cadastrada.'
            ),
            'required' => array(
                'rule' => 'notBlank',
                'allowEmpty' => false,
                'message' => 'Este campo deve ser preenchido.'
            )
        )
    );

    public $hasMany = array(
        'Language' => array(
            'className' => 'Language',
            'joinTable' => '',
            'foreignKey' => 'language_id',
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