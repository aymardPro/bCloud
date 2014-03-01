<?php
/**
 * UserFixture
 *
 */
class UserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'account_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'group_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'firstname' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'lastname' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 155, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'lastvisite' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'remember_token' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 55, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'register_token' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 55, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'chief' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'admin' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_user_account_idx' => array('column' => 'account_id', 'unique' => 0),
			'fk_user_group_idx' => array('column' => 'group_id', 'unique' => 0)
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
			'account_id' => 1,
			'group_id' => 1,
			'firstname' => 'Lorem ipsum dolor sit amet',
			'lastname' => 'Lorem ipsum dolor sit amet',
			'email' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'lastvisite' => '2013-12-07 16:05:46',
			'remember_token' => 'Lorem ipsum dolor sit amet',
			'register_token' => 'Lorem ipsum dolor sit amet',
			'status' => 1,
			'chief' => 1,
			'admin' => 1,
			'created' => '2013-12-07 16:05:46',
			'modified' => '2013-12-07 16:05:46'
		),
	);

}
