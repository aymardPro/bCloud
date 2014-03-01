<?php
App::uses('ArticleManagerAppModel', 'ArticleManager.Model');
/**
 * Article Model
 *
 * @property ArticleFamille $ArticleFamille
 * @property Unite $Unite
 * @property ArticleSerial $ArticleSerial
 * @property HistoriquePrixAchat $HistoriquePrixAchat
 */
class Article extends ArticleManagerAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'article_famille_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => "La famille de l'article est requise.",
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'reference' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => "La référence de l'article est requise.",
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
            'isExist' => array (
                'rule' => array ('isExist'),
                'message' => 'La référence entrée est déjà utilisée.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
		),
		'designation' => array(
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
		'ArticleFamille' => array(
			'className' => 'ArticleManager.ArticleFamille',
			'foreignKey' => 'article_famille_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Unite' => array(
			'className' => 'ArticleManager.Unite',
			'foreignKey' => 'unite_id',
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
		'HistoriquePrixAchat' => array(
			'className' => 'HistoriquePrixAchat',
			'foreignKey' => 'article_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'MouvementArticle' => array(
			'className' => 'ArticleManager.MouvementArticle',
			'foreignKey' => 'article_id',
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
    
    public function isExist()
    {
        $options['conditions'] = array(
            $this->alias.'.reference' => $this->data[$this->alias]['reference'],
            $this->alias.'.article_famille_id' => $this->data[$this->alias]['article_famille_id']
        );
        if ($this->find('count', $options) > 0) {
            return false;
        }
        return true;
    }
    
    public function beforeSave($options = array())
    {
        $number = array('prix_unitaire', 'stock_min', 'stock_max');
        $uppercase = array('reference');
        
        foreach ($this->data[$this->alias] as $key => $value) {
            if (in_array($key, $number)) {
                $this->data[$this->alias][$key] = implode('', explode(',', trim($value)));
            }
            
            if (in_array($key, $uppercase)) {
                $this->data[$this->alias][$key] = $this->uppercase($value);
            }
        }
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
