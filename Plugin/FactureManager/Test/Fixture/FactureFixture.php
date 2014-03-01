<?php
/**
 * FactureFixture
 *
 */
class FactureFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'client_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'paiement_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'statut_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'tva_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'reference' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'garantie' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'remise' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_facture_client_idx' => array('column' => 'client_id', 'unique' => 0),
			'fk_facture_paiement_idx' => array('column' => 'paiement_id', 'unique' => 0),
			'fk_facture_tva_idx' => array('column' => 'tva_id', 'unique' => 0),
			'fk_facture_statut_idx' => array('column' => 'statut_id', 'unique' => 0),
			'fk_facture_user_idx' => array('column' => 'user_id', 'unique' => 0)
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
			'user_id' => 1,
			'client_id' => 1,
			'paiement_id' => 1,
			'statut_id' => 1,
			'tva_id' => 1,
			'reference' => 'Lorem ipsum dolor sit amet',
			'date' => '2013-10-15 10:54:25',
			'name' => 'Lorem ipsum dolor sit amet',
			'garantie' => 'Lorem ipsum dolor sit amet',
			'remise' => 1,
			'created' => '2013-10-15 10:54:25',
			'modified' => '2013-10-15 10:54:25'
		),
	);

}
