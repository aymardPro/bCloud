<?php
App::uses('Unite', 'FactureManager.Model');

/**
 * Unite Test Case
 *
 */
class UniteTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.facture_manager.unite'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Unite = ClassRegistry::init('FactureManager.Unite');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Unite);

		parent::tearDown();
	}

}
