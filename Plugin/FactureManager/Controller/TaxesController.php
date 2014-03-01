<?php
App::uses('FactureManagerAppController', 'FactureManager.Controller');
/**
 * Taxes Controller
 *
 * @property Tva $Tva
 * @property PaginatorComponent $Paginator
 */
class TaxesController extends FactureManagerAppController
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
 * get method
 *
 * @return void
 */
	public function get()
	{
		$this->{$this->modelClass}->recursive = 0;
		$options['conditions'] = array();
		$this->request->data = $this->{$this->modelClass}->find('all', $options);
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
			
			if ($this->{$this->modelClass}->register($this->request->data)) {
				$check = 0;
				$response = __('%s a été créé avec succès.', $this->request->data[$this->modelClass]['name']);
			} else {
				$message = "";
				foreach ($this->{$this->modelClass}->validationErrors as $v) {
                    //$message .= implode(' ', $v);
                    $message = $v;
                    break;
				}
				$response = __('%s', $message);
			}
			$return = array('check' => $check, 'response' => $response);
	        echo json_encode($return);
			
			$this->render('/Elements/empty');
		}
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
			throw new NotFoundException(__('Cette taxe est invalide.'));
		}
		$data = $this->{$this->modelClass}->read(null, $id);
		$this->request->onlyAllow('post', 'delete');
		
		if ($this->{$this->modelClass}->delete()) {
			$this->Session->setFlash(__('%s a été supprimé avec succès.', $data[$this->modelClass]['name']), 'default', array('class' => 'alertMessage inline success'));
		} else {
			$this->Session->setFlash(__('%s ne peut pas être supprimé.', $data[$this->modelClass]['name']), 'default', array('class' => 'alertMessage inline error'));
		}
		return $this->redirect(array('controller' => 'pages', 'action' => 'display', 'dico', 'admin' => false, 'plugin' => false));
	}
}
