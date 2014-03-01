<?php
App::uses('ClientActivity', 'RelationManager.Model');

/**
 * ClientActivity Test Case
 *
 */
class ClientActivityTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.relation_manager.client_activity',
		'plugin.relation_manager.client'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ClientActivity = ClassRegistry::init('RelationManager.ClientActivity');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ClientActivity);

		parent::tearDown();
	}

}
