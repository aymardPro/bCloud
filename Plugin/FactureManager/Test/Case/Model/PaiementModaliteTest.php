<?php
App::uses('PaiementModalite', 'FactureManager.Model');

/**
 * PaiementModalite Test Case
 *
 */
class PaiementModaliteTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.facture_manager.paiement_modalite',
		'plugin.facture_manager.proforma'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PaiementModalite = ClassRegistry::init('FactureManager.PaiementModalite');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PaiementModalite);

		parent::tearDown();
	}

}
