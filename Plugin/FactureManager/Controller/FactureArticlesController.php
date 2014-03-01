<?php
App::uses('FactureManagerAppController', 'FactureManager.Controller');
/**
 * FactureArticles Controller
 *
 * @property FactureArticle $FactureArticle
 * @property PaginatorComponent $Paginator
 */
class FactureArticlesController extends FactureManagerAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->FactureArticle->recursive = 0;
		$this->set('factureArticles', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->FactureArticle->exists($id)) {
			throw new NotFoundException(__('Invalid facture article'));
		}
		$options = array('conditions' => array('FactureArticle.' . $this->FactureArticle->primaryKey => $id));
		$this->set('factureArticle', $this->FactureArticle->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->FactureArticle->create();
			if ($this->FactureArticle->save($this->request->data)) {
				$this->Session->setFlash(__('The facture article has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The facture article could not be saved. Please, try again.'));
			}
		}
		$factures = $this->FactureArticle->Facture->find('list');
		$articles = $this->FactureArticle->Article->find('list');
		$this->set(compact('factures', 'articles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->FactureArticle->exists($id)) {
			throw new NotFoundException(__('Invalid facture article'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->FactureArticle->save($this->request->data)) {
				$this->Session->setFlash(__('The facture article has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The facture article could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('FactureArticle.' . $this->FactureArticle->primaryKey => $id));
			$this->request->data = $this->FactureArticle->find('first', $options);
		}
		$factures = $this->FactureArticle->Facture->find('list');
		$articles = $this->FactureArticle->Article->find('list');
		$this->set(compact('factures', 'articles'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->FactureArticle->id = $id;
		if (!$this->FactureArticle->exists()) {
			throw new NotFoundException(__('Invalid facture article'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->FactureArticle->delete()) {
			$this->Session->setFlash(__('The facture article has been deleted.'));
		} else {
			$this->Session->setFlash(__('The facture article could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
