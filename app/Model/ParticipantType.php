<?php
App::uses('AppModel', 'Model');

class ParticipantType extends AppModel {

    public $displayField = 'description';

    public $validate = array(
        'description' => array(
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'message' => 'Use apenas letras e números.'
            ),
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
        'Participant' => array(
            'className' => 'Participant',
            'joinTable' => '',
            'foreignKey' => 'participant_type_id',
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
