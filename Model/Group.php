<?php
App::uses('AppModel', 'Model');

/**
 * Group Model
 *
 * @property User $User
 */
class Group extends AppModel
{
    public $actsAs = array('Acl' => array('type' => 'requester'));

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Nom du groupe est requis.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
            'isGroupeExist' => array (
                'rule' => array ('isGroupeExist'),
                'message' => 'Ce groupe est déjà utilisé.',
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'group_id',
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
    
    public function parentNode() {
        return null;
    }
    
    public function register($data)
    {
        $this->data = $data;
        
        if ($this->save($this->data)) {
            return true;
        }
        return false;
    }
    
    public function beforeSave($options = array())
    {
        if (array_key_exists('name', $this->data[$this->alias])) {
            $this->data[$this->alias]['name'] = $this->uppercase($this->data[$this->alias]['name']);
        }
    }
    
    public function isGroupeExist()
    {
        if ($this->findByName($this->data[$this->alias]['name'])) {
            return false;
        }
        return true;
    }

}
