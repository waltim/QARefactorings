<?php
/**
 * Created by PhpStorm.
 * User: walter
 * Date: 02/04/18
 * Time: 12:47
 */

class LanguageSearchEvent extends AppModel
{
    public $validate = array(
        'language_id' => array(
            'language_id' => array(
                'rule' => 'notBlank',
            ),
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Números apenas.'
            )
        ),
        'search_event_id' => array(
            'search_event_id' => array(
                'rule' => 'notBlank',
            ),
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Números apenas.'
            )
        )
    );

    public $belongsTo = array(
        'SearchEvent' => array(
            'className' => 'SearchEvent',
            'foreignKey' => 'search_event_id',
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