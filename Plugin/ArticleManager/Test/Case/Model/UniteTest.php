<?php
App::uses('Unite', 'ArticleManager.Model');

/**
 * Unite Test Case
 *
 */
class UniteTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.article_manager.unite'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Unite = ClassRegistry::init('ArticleManager.Unite');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Unite);

		parent::tearDown();
	}

}
