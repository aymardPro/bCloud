<?php
App::uses('ClientType', 'RelationManager.Model');

/**
 * ClientType Test Case
 *
 */
class ClientTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.relation_manager.client_type',
		'plugin.relation_manager.client'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ClientType = ClassRegistry::init('RelationManager.ClientType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ClientType);

		parent::tearDown();
	}

}
