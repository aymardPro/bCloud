<?php
App::uses('FactureManagerAppModel', 'FactureManager.Model');
/**
 * Proforma Model
 *
 * @property User $User
 * @property Client $Client
 * @property PaiementType $PaiementType
 * @property PaiementModalite $PaiementModalite
 * @property ProformaStatut $ProformaStatut
 * @property Tax $Tax
 * @property ProformaArticle $ProformaArticle
 */
class Proforma extends FactureManagerAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'client_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'paiement_modalite_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'paiement_type_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'proforma_statut_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'tax_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'reference' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'date' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
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
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Client' => array(
			'className' => 'RelationManager.Client',
			'foreignKey' => 'client_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PaiementModalite' => array(
			'className' => 'FactureManager.PaiementModalite',
			'foreignKey' => 'paiement_modalite_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PaiementType' => array(
			'className' => 'FactureManager.PaiementType',
			'foreignKey' => 'paiement_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ProformaStatut' => array(
			'className' => 'FactureManager.ProformaStatut',
			'foreignKey' => 'proforma_statut_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Tax' => array(
			'className' => 'FactureManager.Tax',
			'foreignKey' => 'tax_id',
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
		'ProformaArticle' => array(
			'className' => 'FactureManager.ProformaArticle',
			'foreignKey' => 'proforma_id',
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
    
    public function register($data)
    {
        $this->data = $data;
        
        $this->data[$this->alias]['user_id'] = AuthComponent::user('id');
        $this->data[$this->alias]['date'] = CakeTime::format($this->data[$this->alias]['date'], '%Y-%m-%d');
        $this->data[$this->alias]['echeance'] = CakeTime::format($this->data[$this->alias]['echeance'], '%Y-%m-%d');
        //$this->data[$this->alias]['reference'] = $this->uppercase($this->generateReference(6));
        
        if (!empty($this->data['ProformaArticle'])) {
            foreach ($this->data['ProformaArticle'] as $key => $value) {
                $this->data['ProformaArticle'][$key]['taxable'] = $value['taxable'];
                $this->data['ProformaArticle'][$key]['qte'] = implode('', explode(',', trim($value['qte'])));
                $this->data['ProformaArticle'][$key]['remise'] = implode('', explode(',', trim($value['remise'])));
                $this->data['ProformaArticle'][$key]['prix_vente'] = implode('', explode(',', trim($value['prix_vente'])));
            }
        }
        
        if ($this->saveAssociated($this->data)) {
        	$this->id = $this->getLastInsertID();
			$this->saveField('reference', $this->uppercase($this->generateReference(6, $this->id)));
            return true;
        }
        return false;
    }
    
    public function generateReference($lenght, $id)
    {
        $options['conditions'] = array('User.account_id' => AuthComponent::user('account_id'));
        $count = $this->find('count', $options);
        
        $pre = 'PF-';
        $zero = "";
        
        for ($i = 0; $i < (int) $lenght - strlen((int) $id); $i++) {
            $zero .= "0";
        }
        return $pre.$zero.$id;
    }
    
    public function registerEdit($data)
    {
        $this->data = $data;
        
        $this->data[$this->alias]['user_id'] = AuthComponent::user('id');
        $this->data[$this->alias]['date'] = CakeTime::format($this->data[$this->alias]['date'], '%Y-%m-%d');
        $this->data[$this->alias]['echeance'] = CakeTime::format($this->data[$this->alias]['echeance'], '%Y-%m-%d');
        
        $getFA = $this->ProformaArticle->find(
            'all',
            array('conditions' => array('ProformaArticle.proforma_id' => $this->data[$this->alias]['id']))
        );
        
        foreach ($getFA as $key => $value) {
            $this->ProformaArticle->delete($value['ProformaArticle']['id']);
        }
        
        if (!empty($this->data['ProformaArticle'])) {
            foreach ($this->data['ProformaArticle'] as $key => $value) {
                $this->data['ProformaArticle'][$key]['taxable'] = $value['taxable'];
                $this->data['ProformaArticle'][$key]['qte'] = implode('', explode(',', trim($value['qte'])));
                $this->data['ProformaArticle'][$key]['remise'] = implode('', explode(',', trim($value['remise'])));
                $this->data['ProformaArticle'][$key]['prix_vente'] = implode('', explode(',', trim($value['prix_vente'])));
            }
        }
        
        if ($this->saveAssociated($this->data)) {
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

}
