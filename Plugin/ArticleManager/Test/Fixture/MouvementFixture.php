<?php
/**
 * MouvementFixture
 *
 */
class MouvementFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'mouvement_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'depot_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 155, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_mouvement_type_idx' => array('column' => 'mouvement_type_id', 'unique' => 0),
			'fk_mouvement_depot_idx' => array('column' => 'depot_id', 'unique' => 0)
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
			'mouvement_type_id' => 1,
			'depot_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'date' => '2013-10-02 15:45:26',
			'created' => '2013-10-02 15:45:26',
			'modified' => '2013-10-02 15:45:26'
		),
	);

}
