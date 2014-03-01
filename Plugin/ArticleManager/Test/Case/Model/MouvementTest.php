<?php
App::uses('Mouvement', 'ArticleManager.Model');

/**
 * Mouvement Test Case
 *
 */
class MouvementTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.article_manager.mouvement',
		'plugin.article_manager.mouvement_type',
		'plugin.article_manager.depot',
		'plugin.article_manager.mouvement_article'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Mouvement = ClassRegistry::init('ArticleManager.Mouvement');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Mouvement);

		parent::tearDown();
	}

}
