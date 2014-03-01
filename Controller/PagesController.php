<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
        if ($page === "dico") {
        	$title_for_layout = 'Dictionnaire des données';
			
            $shoutcutBoxArray = array(
                array('label' => "Dépôts", 'id' => 'depots'),
                array('label' => "Familles d'article", 'id' => 'famille_articles'),
                array('label' => "Unités de vente", 'id' => 'unites'),
                array('label' => "Modalités de paiement", 'id' => 'paiement_modalites'),
                array('label' => "Moyens de paiement", 'id' => 'paiement_types'),
                array('label' => "Taxes", 'id' => 'taxes'),
            );
			
			if ((int) Configure::read('bCloud.Group.Admin') === (int) $this->Auth->user('group_id')) {
				$shoutcutBoxArray[] = array('label' => "Groupes d'utilisateur", 'id' => 'groups');
			}
        }
		$this->set(compact('page', 'subpage', 'title_for_layout', 'shoutcutBoxArray'));
		
		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}
}
