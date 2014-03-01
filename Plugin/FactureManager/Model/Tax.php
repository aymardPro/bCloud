<?php
App::uses('FactureManagerAppModel', 'FactureManager.Model');
/**
 * Tax Model
 *
 * @property Account $Account
 * @property Facture $Facture
 */
class Tax extends FactureManagerAppModel
{
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Le nom est requis. ',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isExist' => array (
				'rule' => array ('isExist'),
				'message' => 'Cette taxe existe déjà. ',
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
 /*
	public $belongsTo = array(
		'Account' => array(
			'className' => 'Account',
			'foreignKey' => 'account_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

  */ 
/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Facture' => array(
			'className' => 'FactureManager.Facture',
			'foreignKey' => 'tax_id',
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
		);
		if ($this->find('count', $options) > 0) {
			return false;
		}
		return true;
	}
	
	public function beforeSave($options = array())
	{
		//$this->data[$this->alias]['name'] = $this->uppercase($this->data[$this->alias]['name']);
	}
    
    public function register($data)
    {
        $this->data = $data;
		
        if ($this->save($this->data)) {
            return true;
        }
        return false;
    }

}
