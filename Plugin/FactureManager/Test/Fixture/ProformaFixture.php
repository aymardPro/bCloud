<?php
/**
 * ProformaFixture
 *
 */
class ProformaFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'client_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'paiement_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'paiement_modalite_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'proforma_statut_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'tax_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'reference' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'garantie' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'remise' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'echeance' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'assign_to' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_proforma_client_idx' => array('column' => 'client_id', 'unique' => 0),
			'fk_proforma_paiement_modalite_idx' => array('column' => 'paiement_modalite_id', 'unique' => 0),
			'fk_proforma_statut_idx' => array('column' => 'proforma_statut_id', 'unique' => 0),
			'fk_proforma_tax_idx' => array('column' => 'tax_id', 'unique' => 0),
			'fk_proforma_user_idx' => array('column' => 'user_id', 'unique' => 0),
			'fk_proforma_paiement_type_idx' => array('column' => 'paiement_type_id', 'unique' => 0)
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
			'paiement_type_id' => 1,
			'paiement_modalite_id' => 1,
			'proforma_statut_id' => 1,
			'tax_id' => 1,
			'reference' => 'Lorem ip',
			'date' => '2013-12-08 23:37:43',
			'name' => 'Lorem ipsum dolor sit amet',
			'garantie' => 'Lorem ipsum dolor sit amet',
			'remise' => 1,
			'echeance' => '2013-12-08 23:37:43',
			'assign_to' => 1,
			'created' => '2013-12-08 23:37:43',
			'modified' => '2013-12-08 23:37:43'
		),
	);

}
