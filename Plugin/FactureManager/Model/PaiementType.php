<?php
App::uses('FactureManagerAppModel', 'FactureManager.Model');
/**
 * PaiementType Model
 *
 */
class PaiementType extends FactureManagerAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
            'isNameExist' => array (
                'rule' => array ('isNameExist'),
                'message' => 'Ce moyen de paiement est déjà utilisé.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
		),
	);
    
    public function isNameExist()
    {
        if ($this->findByName($this->data[$this->alias]['name'])) {
            return false;
        }
        return true;
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
