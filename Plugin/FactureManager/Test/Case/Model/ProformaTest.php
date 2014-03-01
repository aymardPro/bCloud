<?php
App::uses('Proforma', 'FactureManager.Model');

/**
 * Proforma Test Case
 *
 */
class ProformaTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.facture_manager.proforma',
		'plugin.facture_manager.user',
		'plugin.facture_manager.account',
		'plugin.facture_manager.article_famille',
		'plugin.facture_manager.client',
		'plugin.facture_manager.depot',
		'plugin.facture_manager.paiement',
		'plugin.facture_manager.statut',
		'plugin.facture_manager.tax',
		'plugin.facture_manager.group',
		'plugin.facture_manager.facture',
		'plugin.facture_manager.paiement_type',
		'plugin.facture_manager.paiement_modalite',
		'plugin.facture_manager.proforma_statut',
		'plugin.facture_manager.proforma_article'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Proforma = ClassRegistry::init('FactureManager.Proforma');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Proforma);

		parent::tearDown();
	}

}
