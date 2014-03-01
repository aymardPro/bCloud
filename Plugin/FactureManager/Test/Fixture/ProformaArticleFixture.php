<?php
/**
 * ProformaArticleFixture
 *
 */
class ProformaArticleFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'proforma_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'article_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'designation' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'prix_vente' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'qte' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'remise' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'taxable' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_profa_article_idx' => array('column' => 'article_id', 'unique' => 0),
			'fk_profa_proforma_idx' => array('column' => 'proforma_id', 'unique' => 0)
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
			'proforma_id' => 1,
			'article_id' => 1,
			'designation' => 'Lorem ipsum dolor sit amet',
			'prix_vente' => 1,
			'qte' => 1,
			'remise' => 1,
			'taxable' => 1,
			'created' => '2013-12-08 23:39:27',
			'modified' => '2013-12-08 23:39:27'
		),
	);

}
