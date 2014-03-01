<?php
App::uses('RelationManagerAppController', 'RelationManager.Controller');
/**
 * Clients Controller
 *
 * @property Client $Client
 */
class ClientDatasController extends RelationManagerAppController
{
	protected $ajaxAction = array('get', 'add', 'edit', 'delete');
	
	public function beforeFilter()
	{
		parent::beforeFilter();
        
        
		if (in_array ($this->request->params['action'], $this->ajaxAction)) {
			$this->layout = 'ajax';
            
            if (!$this->request->is('ajax')) {
                $this->redirect(array ('action' => 'index'));
            }
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
    public function get($client_id, $datatype)
    {
        if (!$this->{$this->modelClass}->Client->exists($client_id)) {
            throw new NotFoundException();
        }
        $options['limit'] = 20;
        $options['recursive'] = 1;
        $options['order'] = array ($this->modelClass.'.created' => 'desc');
        $options['conditions'][$this->modelClass.'.client_id'] = $client_id;
        $options['conditions'][$this->modelClass.'.datatype'] = $datatype;
        
        $this->paginate = $options;
        $this->request->data = $this->paginate();
    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null)
	{
	    if (!$this->{$this->modelClass}->exists($id)) {
			throw new NotFoundException();
		}
        
		if ($this->request->is('post')) {
			throw new NotFoundException();
		} else {
			$accounts = $this->{$this->modelClass}->Account->find('list');
            $this->set(compact ('accounts'));
            $options = array('conditions' => array ($this->modelClass . '.' . $this->{$this->modelClass}->primaryKey => $id));
            $this->request->data = $this->{$this->modelClass}->find('first', $options);
		}
	}

/**
 * add method
 *
 * @return void
 */
	public function add($client_id)
	{
        if (!$this->{$this->modelClass}->Client->exists($client_id)) {
            throw new NotFoundException();
        }
        
		if ($this->request->is('post')) {
			$this->{$this->modelClass}->create();
            $this->request->data[$this->modelClass]['client_id'] = $client_id;
			$datatype = $this->request->data[$this->modelClass]['datatype'];
            
			if ($this->{$this->modelClass}->save($this->request->data)) {
				$check = 1;
				$response = __('< %s > a été créé avec succès.', $this->request->data[$this->modelClass]['data']);
			} else {
				$check = 0;
				
				if ($this->{$this->modelClass}->validationErrors) {
					$response = __('Le formulaire est invalide. Vérifiez avant de poursuivre.');
				} else {
					$response = __('ERROR');
				}
			}
			$return = array('check' => $check, 'response' => $response, 'datatype' => $datatype);
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
	public function edit($id = null)
	{
		if (!$this->{$this->modelClass}->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
		    $this->{$this->modelClass}->id = $id;
			if ($this->{$this->modelClass}->save($this->request->data)) {
				$check = 1;
                $response = __('< %s > a été mis à jour avec succès.', $this->request->data[$this->modelClass]['abbreviation']);
			} else {
				$check = 0;
                
                if ($this->{$this->modelClass}->validationErrors) {
                    $response = __('Le formulaire est invalide. Vérifiez avant de poursuivre.');
                } else {
                    $response = __('ERROR');
                }
			}
            $return = array('check' => $check, 'response' => $response);
            echo json_encode($return);
            
            $this->render('/Elements/empty');
		} else {
			$options = array('conditions' => array($this->modelClass .'.'. $this->{$this->modelClass}->primaryKey => $id));
			$this->request->data = $this->{$this->modelClass}->find('first', $options);
            $opt = array();
            
            if ($this->Auth->user()) {
                $opt['conditions']['Account.id'] = $this->Auth->user('account_id');
            }
            $accounts = $this->{$this->modelClass}->Account->find('list', $opt);
            $this->set(compact ('accounts'));
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
		if (!$this->{$this->modelClass}->exists($id)) {
			throw new NotFoundException();
		}
		$data = $this->{$this->modelClass}->read(null, $id);
		$this->request->onlyAllow('post', 'delete');
		
		if ($this->{$this->modelClass}->delete()) {
			$this->Session->setFlash(
                __('%s a été supprimé avec succès.', $data[$this->modelClass]['name']),
                'default',
                array('class' => 'alertMessage inline success')
            );
		} else {
			$this->Session->setFlash(
                __('%s ne peut pas être supprimé.', $data[$this->modelClass]['name']),
                'default',
                array('class' => 'alertMessage inline error')
            );
		}
		return $this->redirect(array('controller' => 'clients', 'action' => 'index'));
	}
}