<?php
App::uses('FactureManagerAppModel', 'FactureManager.Model');
/**
 * FactureArticle Model
 *
 * @property Facture $Facture
 * @property Article $Article
 */
class FactureArticle extends FactureManagerAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'facture_id' => array(
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
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Facture' => array(
			'className' => 'FactureManager.Facture',
			'foreignKey' => 'facture_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Article' => array(
            'className' => 'ArticleManager.Article',
            'foreignKey' => 'article_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
	);

}
