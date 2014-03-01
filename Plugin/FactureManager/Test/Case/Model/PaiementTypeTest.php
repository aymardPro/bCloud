<?php
App::uses('PaiementType', 'FactureManager.Model');

/**
 * PaiementType Test Case
 *
 */
class PaiementTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.facture_manager.paiement_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PaiementType = ClassRegistry::init('FactureManager.PaiementType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PaiementType);

		parent::tearDown();
	}

}
