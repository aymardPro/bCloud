<?php
App::uses('Facture', 'FactureManager.Model');

/**
 * Facture Test Case
 *
 */
class FactureTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.facture_manager.facture',
		'plugin.facture_manager.user',
		'plugin.facture_manager.client',
		'plugin.facture_manager.paiement',
		'plugin.facture_manager.statut',
		'plugin.facture_manager.tva',
		'plugin.facture_manager.facture_article'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Facture = ClassRegistry::init('FactureManager.Facture');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Facture);

		parent::tearDown();
	}

}
