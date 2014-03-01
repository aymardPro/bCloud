<?php
App::uses('EntreeStock', 'ArticleManager.Model');

/**
 * EntreeStock Test Case
 *
 */
class EntreeStockTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.article_manager.entree_stock',
		'plugin.article_manager.stock',
		'plugin.article_manager.article'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->EntreeStock = ClassRegistry::init('ArticleManager.EntreeStock');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->EntreeStock);

		parent::tearDown();
	}

}
