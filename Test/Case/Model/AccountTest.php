<?php
App::uses('Account', 'Model');

/**
 * Account Test Case
 *
 */
class AccountTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.account',
		'app.article_famille',
		'app.client',
		'app.depot',
		'app.paiement',
		'app.statut',
		'app.tax',
		'app.user',
		'app.group',
		'app.facture'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Account = ClassRegistry::init('Account');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Account);

		parent::tearDown();
	}

}
