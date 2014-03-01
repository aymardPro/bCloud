<?php
App::uses('Paiement', 'FactureManager.Model');

/**
 * Paiement Test Case
 *
 */
class PaiementTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.facture_manager.paiement',
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
		$this->Paiement = ClassRegistry::init('FactureManager.Paiement');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Paiement);

		parent::tearDown();
	}

}
