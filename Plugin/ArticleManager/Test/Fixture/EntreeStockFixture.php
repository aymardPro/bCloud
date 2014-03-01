<?php
/**
 * EntreeStockFixture
 *
 */
class EntreeStockFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'stock_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'article_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'qte' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'prix_achat' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'length' => 19),
		'observation' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_entree_stock_idx' => array('column' => 'stock_id', 'unique' => 0),
			'fk_entree_article_idx' => array('column' => 'article_id', 'unique' => 0)
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
			'stock_id' => 1,
			'date' => '2013-09-29 18:29:26',
			'article_id' => 1,
			'qte' => 1,
			'prix_achat' => '',
			'observation' => 'Lorem ipsum dolor sit amet',
			'created' => '2013-09-29 18:29:26',
			'modified' => '2013-09-29 18:29:26'
		),
	);

}
