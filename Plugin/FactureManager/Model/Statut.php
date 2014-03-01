<?php
App::uses('FactureManagerAppModel', 'FactureManager.Model');
/**
 * Statut Model
 *
 * @property Facture $Facture
 */
class Statut extends FactureManagerAppModel
{
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'account_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Le nom du mode est requis. ',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isExist' => array (
				'rule' => array ('isExist'),
				'message' => 'Cet mode existe déjà. ',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Account' => array(
			'className' => 'Account',
			'foreignKey' => 'account_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Facture' => array(
			'className' => 'ArticleManager.Facture',
			'foreignKey' => 'statut_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	public function isExist()
	{
		$options['conditions'] = array(
			$this->alias.'.name' => $this->data[$this->alias]['name'],
			$this->alias.'.account_id' => AuthComponent::user('account_id')
		);
		if ($this->find('count', $options) > 0) {
			return false;
		}
		return true;
	}
	
	public function beforeSave($options = array())
	{
		$this->data[$this->alias]['name'] = $this->uppercase($this->data[$this->alias]['name']);
	}

}
