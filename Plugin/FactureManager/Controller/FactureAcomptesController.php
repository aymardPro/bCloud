<?php
App::uses('FactureManagerAppController', 'FactureManager.Controller');
/**
 * FactureAcomptes Controller
 *
 * @property FactureAcompte $FactureAcompte
 * @property PaginatorComponent $Paginator
 */
class FactureAcomptesController extends FactureManagerAppController {

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
		$this->FactureAcompte->recursive = 0;
		$this->set('factureAcomptes', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->FactureAcompte->exists($id)) {
			throw new NotFoundException(__('Invalid facture acompte'));
		}
		$options = array('conditions' => array('FactureAcompte.' . $this->FactureAcompte->primaryKey => $id));
		$this->set('factureAcompte', $this->FactureAcompte->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->FactureAcompte->create();
			if ($this->FactureAcompte->save($this->request->data)) {
				$this->Session->setFlash(__('The facture acompte has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The facture acompte could not be saved. Please, try again.'));
			}
		}
		$factures = $this->FactureAcompte->Facture->find('list');
		$this->set(compact('factures'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->FactureAcompte->exists($id)) {
			throw new NotFoundException(__('Invalid facture acompte'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->FactureAcompte->save($this->request->data)) {
				$this->Session->setFlash(__('The facture acompte has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The facture acompte could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('FactureAcompte.' . $this->FactureAcompte->primaryKey => $id));
			$this->request->data = $this->FactureAcompte->find('first', $options);
		}
		$factures = $this->FactureAcompte->Facture->find('list');
		$this->set(compact('factures'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->FactureAcompte->id = $id;
		if (!$this->FactureAcompte->exists()) {
			throw new NotFoundException(__('Invalid facture acompte'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->FactureAcompte->delete()) {
			$this->Session->setFlash(__('The facture acompte has been deleted.'));
		} else {
			$this->Session->setFlash(__('The facture acompte could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
