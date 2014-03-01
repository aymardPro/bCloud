<?php
App::uses('Client', 'RelationManager.Model');

/**
 * Client Test Case
 *
 */
class ClientTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.relation_manager.client',
		'plugin.relation_manager.account',
		'plugin.relation_manager.client_type',
		'plugin.relation_manager.client_activity'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Client = ClassRegistry::init('RelationManager.Client');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Client);

		parent::tearDown();
	}

}
