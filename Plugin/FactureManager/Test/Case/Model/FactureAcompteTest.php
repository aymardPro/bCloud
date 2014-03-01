<?php
App::uses('FactureAcompte', 'FactureManager.Model');

/**
 * FactureAcompte Test Case
 *
 */
class FactureAcompteTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.facture_manager.facture_acompte',
		'plugin.facture_manager.facture'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->FactureAcompte = ClassRegistry::init('FactureManager.FactureAcompte');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->FactureAcompte);

		parent::tearDown();
	}

}
