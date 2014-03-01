<?php
App::uses('ProformaStatut', 'FactureManager.Model');

/**
 * ProformaStatut Test Case
 *
 */
class ProformaStatutTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.facture_manager.proforma_statut'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ProformaStatut = ClassRegistry::init('FactureManager.ProformaStatut');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ProformaStatut);

		parent::tearDown();
	}

}
