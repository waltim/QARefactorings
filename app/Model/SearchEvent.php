<?php
/**
 * Created by PhpStorm.
 * User: walter
 * Date: 02/04/18
 * Time: 12:00
 */

class SearchEvent extends AppModel
{
    public $displayField = 'title';

    public $validate = array(
        'title' => array(
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
            'foreignKey' => 'search_event_id',
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
        ),
        'Participant' => array(
            'className' => 'Participant',
            'joinTable' => '',
            'foreignKey' => 'search_event_id',
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
            'joinTable' => 'language_search_events',
            'foreignKey' => 'search_event_id',
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