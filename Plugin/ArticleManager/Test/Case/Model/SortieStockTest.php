<?php
App::uses('SortieStock', 'ArticleManager.Model');

/**
 * SortieStock Test Case
 *
 */
class SortieStockTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.article_manager.sortie_stock',
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
		$this->SortieStock = ClassRegistry::init('ArticleManager.SortieStock');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SortieStock);

		parent::tearDown();
	}

}
