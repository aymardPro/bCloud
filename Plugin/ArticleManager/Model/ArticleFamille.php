<?php
App::uses('ArticleManagerAppModel', 'ArticleManager.Model');
/**
 * ArticleFamille Model
 *
 * @property Account $Account
 * @property Article $Article
 */
class ArticleFamille extends ArticleManagerAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Le nom de la famille est requis.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'isNameExist' => array (
                'rule' => array ('isNameExist'),
                'message' => "Ce nom de famille est déjà utilisé. ",
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'code' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Le code est requis.',
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
 /*
	public $belongsTo = array(
		'Account' => array(
			'className' => 'Account',
			'foreignKey' => 'account_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
  */ 

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Article' => array(
			'className' => 'ArticleManager.Article',
			'foreignKey' => 'article_famille_id',
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
	
	public function beforeSave($options = array())
	{
		$this->data[$this->alias]['name'] = trim($this->data[$this->alias]['name']);
	}
	
	public function beforeDelete($cascade = true)
	{
		parent::beforeDelete();
		
		if ($this->find('count', array('conditions' => array($this->alias.'.parent' => $this->id))) > 0) {
			return false;
		}
		return true;
	}
    
    public function isNameExist()
    {
        if ($this->findByNameAndParentAndType($this->data[$this->alias]['name'], $this->data[$this->alias]['parent'], $this->data[$this->alias]['type'])) {
            return false;
        }
        return true;
    }
    
    public function register($data)
    {
        $this->data = $data;
		$this->data[$this->alias]['account_id'] = AuthComponent::user('account_id');
        
        if ((int)$this->data[$this->alias]['type'] === 0) {
            $this->data[$this->alias]['parent'] = 0;
        }
        
        if ($this->save($this->data)) {
            return true;
        }
        return false;
    }

}
