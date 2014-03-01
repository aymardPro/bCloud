<?php
App::uses('RelationManagerAppModel', 'RelationManager.Model');
/**
 * User Model
 *
 * @property Groupe $Groupe
 */
class ClientContact extends RelationManagerAppModel
{
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array (
        'genre' => array (
            'notempty' => array (
                'rule' => array ('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'numeric' => array (
                'rule' => array ('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
		'nom' => array (
            'notempty' => array (
                'rule' => array ('notempty'),
                //'message' => 'Your custom message here',
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
	public $belongsTo = array (
		'Client' => array (
			'className' => 'RelationManager.Client'
		),
	);
    
    /*
     * Fonction de callback
     */ 
	public function beforeValidate($options = array())
	{
		foreach ($this->data as $key => $value)
		{
			foreach ($value as $k => $v)
			{
				$this->data[$key][$k] = trim($v);
			}
		}
		return true;
	}
	
	public function beforeSave($options = array())
	{
        $this->data[$this->alias]['nom'] = $this->uppercase($this->data[$this->alias]['nom']);
        $this->data[$this->alias]['prenoms'] = $this->uppercase($this->data[$this->alias]['prenoms']);
        $this->data[$this->alias]['fonction'] = $this->uppercase($this->data[$this->alias]['fonction']);
    }
	
	public function beforeDelete($cascade = true)
	{
		$store = true;
		foreach ($this->hasMany as $key => $value)
		{
			$count = $this->{$key}->find
			(
				"count",
				array("conditions" => array("client_contact_id" => $this->id))
			);
		    if ($count !== 0) {
		        $store = false;
		    }
		}
		return $store;
	}
    
    /*
     * Fonctions de validation
     */
}
