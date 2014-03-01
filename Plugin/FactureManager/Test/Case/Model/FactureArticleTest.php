<?php
App::uses('FactureArticle', 'FactureManager.Model');

/**
 * FactureArticle Test Case
 *
 */
class FactureArticleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.facture_manager.facture_article',
		'plugin.facture_manager.facture',
		'plugin.facture_manager.article'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->FactureArticle = ClassRegistry::init('FactureManager.FactureArticle');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->FactureArticle);

		parent::tearDown();
	}

}
