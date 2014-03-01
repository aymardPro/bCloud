<?php
App::uses('FactureManagerAppModel', 'FactureManager.Model');
App::import('Vendor', 'PDF', array('file' => 'PDF/PDF.php'));
/**
 * Facture Model
 *
 * @property User $User
 * @property Client $Client
 * @property Paiement $Paiement
 * @property Statut $Statut
 * @property Tva $Tva
 * @property FactureArticle $FactureArticle
 */
class Facture extends FactureManagerAppModel {

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
				'message' => 'Le client est requis. ',
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
		'statut_id' => array(
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
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'La référence est requise. ',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'date' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				'message' => 'La date est requise. ',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "L'objet est requis. ",
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
		'Statut' => array(
			'className' => 'FactureManager.Statut',
			'foreignKey' => 'statut_id',
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
        'FactureArticle' => array(
            'className' => 'FactureManager.FactureArticle',
        ),
        'FactureAcompte' => array(
            'className' => 'FactureManager.FactureAcompte',
        ),
	);
    
    public function register($data)
    {
        $this->data = $data;
        
        $this->data[$this->alias]['user_id'] = AuthComponent::user('id');
        $this->data[$this->alias]['date'] = CakeTime::format('Y-m-d H:i:s', $this->data[$this->alias]['date']);
        $this->data[$this->alias]['reference'] = $this->uppercase($this->generateReference(6));
        
        if (!empty($this->data['FactureArticle'])) {
            foreach ($this->data['FactureArticle'] as $key => $value) {
                $this->data['FactureArticle'][$key]['qte'] = implode('', explode(',', trim($value['qte'])));
                $this->data['FactureArticle'][$key]['remise'] = implode('', explode(',', trim($value['remise'])));
                $this->data['FactureArticle'][$key]['prix_vente'] = implode('', explode(',', trim($value['prix_vente'])));
            }
        }
        
        if ($this->saveAssociated($this->data)) {
            return true;
        }
        return false;
    }
    
    public function generateReference($lenght)
    {
        $options['conditions'] = array('User.account_id' => AuthComponent::user('account_id'));
        $count = $this->find('count', $options);
        
        $pre = 'F-';
        $id = (int) $count + 1;
        $zero = "";
        
        for ($i = 0; $i < (int) $lenght - strlen($id); $i++) {
            $zero .= "0";
        }
        return $pre.$zero.$id;
    }
    
    public function registerEdit($data)
    {
        $this->data = $data;
        
        $this->data[$this->alias]['user_id'] = AuthComponent::user('id');
        $this->data[$this->alias]['date'] = CakeTime::format('Y-m-d H:i:s', $this->data[$this->alias]['date']);
        
        $getFA = $this->FactureArticle->find('all', array('conditions' => array('FactureArticle.facture_id' => $this->data[$this->alias]['id'])));
        
        foreach ($getFA as $key => $value) {
            $this->FactureArticle->delete($value['FactureArticle']['id']);
        }
        
        if (!empty($this->data['FactureArticle'])) {
            foreach ($this->data['FactureArticle'] as $key => $value) {
                $this->data['FactureArticle'][$key]['qte'] = implode('', explode(',', trim($value['qte'])));
                $this->data['FactureArticle'][$key]['remise'] = implode('', explode(',', trim($value['remise'])));
                $this->data['FactureArticle'][$key]['prix_vente'] = implode('', explode(',', trim($value['prix_vente'])));
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
