<?php
App::uses('FactureManagerAppModel', 'FactureManager.Model');
/**
 * FactureAcompte Model
 *
 * @property Facture $Facture
 */
class FactureAcompte extends FactureManagerAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'facture_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Facture requise.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'value' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Montant requis.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'date' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				'message' => 'Date requis.',
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
		'Facture' => array(
			'className' => 'Facture',
		)
	);
    
    public function register($data)
    {
        $this->data = $data;
        
        $this->data[$this->alias]['value'] = implode('', explode(',', trim($this->data[$this->alias]['value'])));
        $this->data[$this->alias]['date'] = CakeTime::format('Y-m-d H:i:s', $this->data[$this->alias]['date']);
        
        if ($this->save($this->data)) {
            return true;
        }
        return false;
    }
}
