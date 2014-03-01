<?php
App::uses('FactureManagerAppModel', 'FactureManager.Model');
/**
 * PaiementModalite Model
 *
 * @property Proforma $Proforma
 */
class PaiementModalite extends FactureManagerAppModel {

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
                'message' => 'Cette modalité de paiement est déjà utilisé.',
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
		'Proforma' => array(
			'className' => 'FactureManager.Proforma',
			'foreignKey' => 'paiement_modalite_id',
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
