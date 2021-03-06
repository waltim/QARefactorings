<?php
App::uses('AppModel', 'Model');

class Transformation extends AppModel
{

	public $validate = array(
		'search_event_id' => array(
			'search_event_id' => array(
				'rule' => 'notBlank',
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.'
			)
		),
		'transformation_type_id' => array(
			'transformation_type_id' => array(
				'rule' => 'notBlank'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.'
			)
		),
		'language_id' => array(
			'language_id' => array(
				'rule' => 'notBlank'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Números apenas.'
			)
		),
//		'code_before' => array(
//			'code_before' => array(
//				'rule' => 'notBlank'
//			)
//		),
//		'code_after' => array(
//			'code_after' => array(
//				'rule' => 'notBlank'
//			)
//		)
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
		),
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
		)
	);

	public $hasAndBelongsToMany = array(
		'Metric' => array(
			'className' => 'Metric',
			'joinTable' => 'results',
			'foreignKey' => 'transformation_id',
			'associationForeignKey' => 'metric_id',
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

	public function isOwnedBy($post, $user)
	{
		$pending = $this->find('first', array(
			'conditions' => array(
				'Transformation.id' => $post,
				'Transformation.user_id' => $user,
			),
		));
		if (!empty($pending)) {
			return true;
		} else {
			return false;
		}
	}

}
