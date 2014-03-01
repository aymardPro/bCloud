<?php
App::uses('AppModel', 'Model');
/**
 * Account Model
 *
 * @property ArticleFamille $ArticleFamille
 * @property Client $Client
 * @property Depot $Depot
 * @property Paiement $Paiement
 * @property Statut $Statut
 * @property Tax $Tax
 * @property User $User
 */
class Account extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Le nom est requis.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
            'isCompteExist' => array (
                'rule' => array ('isCompteExist'),
                'message' => 'Ce nom de compte est déjà utilisé.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ArticleFamille' => array(
			'className' => 'ArticleFamille',
			'foreignKey' => 'account_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Client' => array(
			'className' => 'Client',
			'foreignKey' => 'account_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Depot' => array(
			'className' => 'Depot',
			'foreignKey' => 'account_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Statut' => array(
			'className' => 'Statut',
			'foreignKey' => 'account_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Tax' => array(
			'className' => 'Tax',
			'foreignKey' => 'account_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'account_id',
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
    
    public function isCompteExist()
    {
        if ($this->findByName($this->data[$this->alias]['name'])) {
            return false;
        }
        return true;
    }
    
    public function beforeSave($options = array())
    {
        if (array_key_exists('name', $this->data[$this->alias])) {
            $this->data[$this->alias]['name'] = $this->uppercase($this->data[$this->alias]['name']);
        }
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
