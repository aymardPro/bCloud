<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Account $Account
 * @property Group $Group
 * @property Facture $Facture
 */
class User extends AppModel
{
    public $actsAs = array('Acl' => array('type' => 'requester'));
    
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'account_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Compte requis.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'group_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Groupe requis.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'username' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => "Nom d'utilisateur requis.",
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'nom' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Nom requis.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
		'prenoms' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Prénoms requis.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Email valide requis.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'password' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Mot de passe requis.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
        'password2' => array (
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Répétez le mot de passe.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'eqToPwd' => array (
                'rule' => array ('eqToPwd'),
                'message' => 'Les mots de passe ne sont pas identiques.',
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
		),
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
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
            'className' => 'FactureManager.Facture',
            'foreignKey' => 'user_id',
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
        'Proforma' => array(
            'className' => 'FactureManager.Proforma',
            'foreignKey' => 'user_id',
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
	);
    
    public function parentNode()
    {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        
        if (isset($this->data[$this->alias]['group_id'])) {
            $groupId = $this->data[$this->alias]['group_id'];
        } else {
            $groupId = $this->field('group_id');
        }
        
        if (!$groupId) {
            return null;
        } else {
            return array('Group' => array('id' => $groupId));
        }
    }
    
    public function bindNode($user)
    {
        return array('model' => 'Group', 'foreign_key' => $user[$this->alias]['group_id']);
    }
    
    public function eqToPwd()
    {
        if ($this->data[$this->alias]['password'] !== $this->data[$this->alias]['password2']) {
            return false;
        }
        return true;
    }
    
    public function isEmailExist()
    {
        if ($this->findByEmail($this->data[$this->alias]['email'])) {
            return false;
        }
        return true;
    }
    
    public function beforeSave($options = array())
    {
        if (array_key_exists('password', $this->data[$this->alias])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
    }
    
    public function register($data)
    {
        $this->data = $data;
        $this->data[$this->alias]['account_id'] = AuthComponent::user('account_id');
        
        if ((int) $this->data[$this->alias]['status'] === 0) {
            $this->data[$this->alias]['register_token'] = $this->randomString(55);
        } else {
            $this->data[$this->alias]['register_token'] = null;
        }
        
        if ($this->save($this->data)) {
        	return true;
        }
        return false;
    }
}
