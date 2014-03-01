<?php
/**
 * FactureAcompteFixture
 *
 */
class FactureAcompteFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'facture_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'value' => array('type' => 'integer', 'null' => false, 'default' => null),
		'date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_facompte_facture_idx' => array('column' => 'facture_id', 'unique' => 0)
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
			'value' => 1,
			'date' => '2013-11-20 12:29:57',
			'created' => '2013-11-20 12:29:57',
			'modified' => '2013-11-20 12:29:57'
		),
	);

}
