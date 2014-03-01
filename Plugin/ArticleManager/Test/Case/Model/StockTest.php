<?php
App::uses('Stock', 'ArticleManager.Model');

/**
 * Stock Test Case
 *
 */
class StockTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.article_manager.stock',
		'plugin.article_manager.account'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Stock = ClassRegistry::init('ArticleManager.Stock');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Stock);

		parent::tearDown();
	}

}
