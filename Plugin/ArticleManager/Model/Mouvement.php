<?php
App::uses('ArticleManagerAppModel', 'ArticleManager.Model');
/**
 * Mouvement Model
 *
 * @property MouvementType $MouvementType
 * @property Depot $Depot
 * @property MouvementArticle $MouvementArticle
 */
class Mouvement extends ArticleManagerAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'type' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Type est requis.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Intitulé requis.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
		'date' => array(
			'date' => array(
				'rule' => array('date'),
				'message' => 'Date est requis.',
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
        'Depot' => array(
            'className' => 'ArticleManager.Depot',
            'foreignKey' => 'depot_depart'
        ),
        'Depot' => array(
            'className' => 'ArticleManager.Depot',
            'foreignKey' => 'depot_arrivee'
        ),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'MouvementArticle' => array(
			'className' => 'ArticleManager.MouvementArticle',
		)
	);
	
	public function register($data)
	{
		$tooMany = false;
        $this->data = $data;
        
		$this->data[$this->alias]['date'] = CakeTime::format(trim($this->data[$this->alias]['date']), '%Y-%m-%d');
        
        if ((int) $this->data[$this->alias]['type'] < 2) {
            $this->data[$this->alias]['depot_arrivee'] = $this->data[$this->alias]['depot_depart'];
        }
		
        if (array_key_exists('MouvementArticle', $this->data)) {
    		foreach ($this->data['MouvementArticle'] as $key => $value) {
    			if (empty($value['article_id'])) {
    				unset($this->data['MouvementArticle'][$key]);
    			} else {
    				$this->data['MouvementArticle'][$key]['prix_unitaire'] = implode('', explode(',', trim($value['prix_unitaire'])));
    				$this->data['MouvementArticle'][$key]['qte'] = implode('', explode(',', trim($value['qte'])));
    				
    				if ((int) $this->data['Mouvement']['type'] === 1) {
    					$qte = implode('', explode(',', trim($value['qte'])));
    					$stock = $this->MouvementArticle->getStock($value['article_id'], $this->data[$this->alias]['depot_arrivee']);
    					
    					if ((int) $qte > (int) $stock) {
    						$tooMany = true;
    					}
    				}
    			}
    		}
		}
		
		if (!$tooMany) {
			unset($this->MouvementArticle->validate['mouvement_id']);
			
			if ($this->saveAssociated($this->data)) {
				return true;
			}
		}
		return false;
	}
	
	public function beforeSave($options = array())
	{
		$this->data[$this->alias]['name'] = $this->uppercase($this->data[$this->alias]['name']);
	}

}
