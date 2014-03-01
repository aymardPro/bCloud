<?php
App::uses('MouvementType', 'ArticleManager.Model');

/**
 * MouvementType Test Case
 *
 */
class MouvementTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.article_manager.mouvement_type',
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
		$this->MouvementType = ClassRegistry::init('ArticleManager.MouvementType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MouvementType);

		parent::tearDown();
	}

}
