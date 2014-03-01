<?php
App::uses('Depot', 'ArticleManager.Model');

/**
 * Depot Test Case
 *
 */
class DepotTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.article_manager.depot',
		'plugin.article_manager.account',
		'plugin.article_manager.mouvement'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Depot = ClassRegistry::init('ArticleManager.Depot');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Depot);

		parent::tearDown();
	}

}
