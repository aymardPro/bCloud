<?php
App::uses('Article', 'ArticleManager.Model');

/**
 * Article Test Case
 *
 */
class ArticleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.article_manager.article',
		'plugin.article_manager.article_famille',
		'plugin.article_manager.unite',
		'plugin.article_manager.article_serial',
		'plugin.article_manager.historique_prix_achat'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Article = ClassRegistry::init('ArticleManager.Article');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Article);

		parent::tearDown();
	}

}
