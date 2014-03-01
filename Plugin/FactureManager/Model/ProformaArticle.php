<?php
App::uses('FactureManagerAppModel', 'FactureManager.Model');
/**
 * ProformaArticle Model
 *
 * @property Proforma $Proforma
 * @property Article $Article
 */
class ProformaArticle extends FactureManagerAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'proforma_id' => array(
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
		'Proforma' => array(
			'className' => 'FactureManager.Proforma',
			'foreignKey' => 'proforma_id',
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
