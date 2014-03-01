<?php
/**
 * ArticleFixture
 *
 */
class ArticleFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'article_famille_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'unite_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'reference' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'designation' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'prix_unitaire' => array('type' => 'integer', 'null' => true, 'default' => null),
		'marge' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'code_barre' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'stockable' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'stock_min' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'stock_securite' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'stock_max' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_article_famille_idx' => array('column' => 'article_famille_id', 'unique' => 0),
			'fk_article_unite_idx' => array('column' => 'unite_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'article_famille_id' => 1,
			'unite_id' => 1,
			'reference' => 'Lorem ipsum dolor sit amet',
			'designation' => 'Lorem ipsum dolor sit amet',
			'prix_unitaire' => 1,
			'marge' => 1,
			'code_barre' => 'Lorem ipsum dolor sit amet',
			'stockable' => 1,
			'stock_min' => 1,
			'stock_securite' => 1,
			'stock_max' => 1,
			'created' => '2013-12-14 10:06:32',
			'modified' => '2013-12-14 10:06:32'
		),
	);

}
