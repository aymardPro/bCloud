<?php
App::uses('ProformaArticle', 'FactureManager.Model');

/**
 * ProformaArticle Test Case
 *
 */
class ProformaArticleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.facture_manager.proforma_article',
		'plugin.facture_manager.proforma',
		'plugin.facture_manager.article'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ProformaArticle = ClassRegistry::init('FactureManager.ProformaArticle');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ProformaArticle);

		parent::tearDown();
	}

}
