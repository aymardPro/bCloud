<?php
App::uses('Statut', 'FactureManager.Model');

/**
 * Statut Test Case
 *
 */
class StatutTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.facture_manager.statut',
		'plugin.facture_manager.facture'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Statut = ClassRegistry::init('FactureManager.Statut');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Statut);

		parent::tearDown();
	}

}
