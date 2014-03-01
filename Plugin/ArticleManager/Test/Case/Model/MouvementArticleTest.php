<?php
App::uses('MouvementArticle', 'ArticleManager.Model');

/**
 * MouvementArticle Test Case
 *
 */
class MouvementArticleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.article_manager.mouvement_article',
		'plugin.article_manager.mouvement',
		'plugin.article_manager.article'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MouvementArticle = ClassRegistry::init('ArticleManager.MouvementArticle');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MouvementArticle);

		parent::tearDown();
	}

}
