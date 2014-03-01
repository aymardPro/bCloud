<?php
App::uses('ArticleManagerAppModel', 'ArticleManager.Model');
/**
 * Depot Model
 *
 * @property Account $Account
 * @property Mouvement $Mouvement
 */
class Depot extends ArticleManagerAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Nom du dépôt est requis.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'isNameExist' => array (
                'rule' => array ('isNameExist'),
                'message' => "Ce nom de dépôt est déjà utilisé. ",
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
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
        'Mouvement' => array(
            'className' => 'ArticleManager.Mouvement',
            'foreignKey' => 'depot_arrivee',
        ),
        'Mouvement' => array(
            'className' => 'ArticleManager.Mouvement',
            'foreignKey' => 'depot_depart',
        ),
	);
    
    public function isNameExist()
    {
        if ($this->findByNameAndAccountId($this->data[$this->alias]['name'], AuthComponent::user('account_id'))) {
            return false;
        }
        return true;
    }
    
    public function ManyOrNot($data)
    {
        $tableau = explode(';', $data[$this->alias]['name']);
        $donnees = array();
        
        if (count($tableau)>1) {
            $method =  'saveMany';
            
            foreach ($tableau as $key => $value) {
                $donnees[$key][$this->alias]['account_id'] = AuthComponent::user('account_id');
                $donnees[$key][$this->alias]['name'] = trim($value);
            }
        } else {
            $method =  'save';
            $donnees[$this->alias]['account_id'] = AuthComponent::user('account_id');
            $donnees[$this->alias]['name'] = trim($data[$this->alias]['name']);
        }
        return array('method' => $method, 'data' => $donnees);
    }
    
    public function register($data)
    {
        $result = $this->ManyOrNot($data);
        
        if ($this->{$result['method']}($result['data'])) {
            return true;
        }
        return false;
    }

}
