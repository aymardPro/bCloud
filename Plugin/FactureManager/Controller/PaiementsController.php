<?php
App::uses('FactureManagerAppController', 'FactureManager.Controller');
/**
 * Paiements Controller
 *
 * @property Paiement $Paiement
 * @property PaginatorComponent $Paginator
 */
class PaiementsController extends FactureManagerAppController
{
	public function beforeFilter()
	{
		parent::beforeFilter();
		$ajaxFunc = array('get', 'add', 'edit');
		
		if (in_array($this->request->params['action'], $ajaxFunc)) {
			$this->layout = 'ajax';
		}
	}

/**
 * index method
 *
 * @return void
 */
	public function index()
	{}
	
/**
 * get method
 *
 * @return void
 */
	public function get()
	{
		$this->{$this->modelClass}->recursive = 0;
		$options['conditions'][] = array($this->modelClass.'.account_id' => AuthComponent::user('account_id'));
		$this->request->data = $this->{$this->modelClass}->find('all', $options);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Paiement->exists($id)) {
			throw new NotFoundException(__('Invalid paiement'));
		}
		$options = array('conditions' => array('Paiement.' . $this->Paiement->primaryKey => $id));
		$this->set('paiement', $this->Paiement->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add()
	{
		if ($this->request->is('post')) {
			$check = 1;
			$this->{$this->modelClass}->create();
			
			if ($this->{$this->modelClass}->save($this->request->data)) {
				$check = 0;
				$response = __('%s a été créé avec succès.', $this->request->data[$this->modelClass]['name']);
			} else {
				$message = "";
				foreach ($this->{$this->modelClass}->validationErrors as $v) {
					$message .= implode(' ', $v);
				}
				$response = __('%s', $message);
			}
			$return = array('check' => $check, 'response' => $response);
	        echo json_encode($return);
			
			$this->render('/Elements/empty');
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Paiement->exists($id)) {
			throw new NotFoundException(__('Invalid paiement'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Paiement->save($this->request->data)) {
				$this->Session->setFlash(__('The paiement has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The paiement could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Paiement.' . $this->Paiement->primaryKey => $id));
			$this->request->data = $this->Paiement->find('first', $options);
		}
		$accounts = $this->Paiement->Account->find('list');
		$this->set(compact('accounts'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null)
	{
		$this->{$this->modelClass}->id = $id;
		
		if (!$this->{$this->modelClass}->exists()) {
			throw new NotFoundException(__('Ce mode de paiment est invalide.'));
		}
		$data = $this->{$this->modelClass}->read(null, $id);
		$this->request->onlyAllow('post', 'delete');
		
		if ($this->{$this->modelClass}->delete()) {
			$this->Session->setFlash(__('%s a été supprimé avec succès.', $data[$this->modelClass]['name']), 'default', array('class' => 'alertMessage inline success'));
		} else {
			$this->Session->setFlash(__('%s ne peut pas être supprimé.', $data[$this->modelClass]['name']), 'default', array('class' => 'alertMessage inline error'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
