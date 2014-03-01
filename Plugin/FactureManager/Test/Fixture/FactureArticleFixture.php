<?php
/**
 * FactureArticleFixture
 *
 */
class FactureArticleFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'facture_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'article_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'designation' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'quantite' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'remise' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'prix_vente' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_fa_facture_idx' => array('column' => 'facture_id', 'unique' => 0),
			'fk_fa_article_idx' => array('column' => 'article_id', 'unique' => 0)
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
			'facture_id' => 1,
			'article_id' => 1,
			'designation' => 'Lorem ipsum dolor sit amet',
			'quantite' => 1,
			'remise' => 1,
			'prix_vente' => 1,
			'created' => '2013-10-04 10:15:02',
			'modified' => '2013-10-04 10:15:02'
		),
	);

}
