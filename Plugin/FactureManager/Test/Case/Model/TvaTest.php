<?php
App::uses('Tva', 'FactureManager.Model');

/**
 * Tva Test Case
 *
 */
class TvaTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.facture_manager.tva',
		'plugin.facture_manager.account',
		'plugin.facture_manager.facture'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Tva = ClassRegistry::init('FactureManager.Tva');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Tva);

		parent::tearDown();
	}

}
