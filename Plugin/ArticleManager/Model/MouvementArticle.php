<?php
App::uses('ArticleManagerAppModel', 'ArticleManager.Model');
/**
 * MouvementArticle Model
 *
 * @property Mouvement $Mouvement
 * @property Article $Article
 */
class MouvementArticle extends ArticleManagerAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'mouvement_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'article_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'qte' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
		'Mouvement' => array(
			'className' => 'ArticleManager.Mouvement',
		),
		'Article' => array(
			'className' => 'ArticleManager.Article',
		)
	);
	
	public function getArticleStock($id, $type_id, $depot = false)
	{
	    if ($depot) {
            $options['conditions']['Mouvement.depot_depart'] = (int) $depot;
	    }
        
		$options['recursive'] = 0;
        $options['conditions'][$this->alias.'.article_id'] = (int) $id;
        $options['conditions']['Mouvement.type'] = (int) $type_id;
        
		$datas = $this->find('all', $options);
		$qte_datas = array();
		
		if (!empty($datas)) {
			foreach ($datas as $key => $value) {
				$qte_datas[] = (int) $value[$this->alias]['qte'];
			}
		}
		$somme_datas = 0;
		
		if (!empty($qte_datas)) {
			foreach ($qte_datas as $v) {
				$somme_datas += $v;
			}
		}
		return $somme_datas;
	}
    
    public function getStock($article, $depot = false)
    {
        return $this->getArticleStock($article, 0, $depot) - $this->getArticleStock($article, 1, $depot);
    }
}
