<?php
App::uses('RelationManagerAppModel', 'RelationManager.Model');
/**
 * Client Model
 *
 * @property Account $Account
 * @property ClientType $ClientType
 * @property ClientActivity $ClientActivity
 */
class Client extends RelationManagerAppModel
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
				'message' => 'Dénomination est requis.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'sigle' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Sigle est requis.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
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
		)
	);
	
/**
 * hasMany associations
 *
 * @var array
 */
    public $hasMany = array (
        'ClientData' => array (
            'className' => 'RelationManager.ClientData'
        ),
        'ClientContact' => array (
            'className' => 'RelationManager.ClientContact'
        ),
        'ClientActivityAssociate' => array (
            'className' => 'RelationManager.ClientActivityAssociate'
        ),
    );
    
    public function beforeSave($options = array())
    {
        if (array_key_exists('ClientActivityAssociate', $this->data)) {
            return true;
        }
        return false;
    }
    
	public function register($data)
	{
        $data[$this->alias]['account_id'] = AuthComponent::user('account_id');
        $data[$this->alias]['name'] = $this->uppercase($data[$this->alias]['name']);
		$data[$this->alias]['sigle'] = $this->uppercase($data[$this->alias]['sigle']);
        $data[$this->alias]['alias'] = $this->getAlias($data[$this->alias]['name']);
        
		if ($this->saveAssociated($data)) {
			return true;
		}
		return false;
	}
}
