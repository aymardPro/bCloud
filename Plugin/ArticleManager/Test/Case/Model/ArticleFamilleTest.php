<?php
App::uses('ArticleFamille', 'ArticleManager.Model');

/**
 * ArticleFamille Test Case
 *
 */
class ArticleFamilleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.article_manager.article_famille',
		'plugin.article_manager.account',
		'plugin.article_manager.article'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ArticleFamille = ClassRegistry::init('ArticleManager.ArticleFamille');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ArticleFamille);

		parent::tearDown();
	}

}
