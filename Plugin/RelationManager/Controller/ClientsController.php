<?php
App::uses('RelationManagerAppController', 'RelationManager.Controller');
/**
 * Clients Controller
 *
 * @property Client $Client
 * @property PaginatorComponent $Paginator
 */
class ClientsController extends RelationManagerAppController
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
		$options['recursive'] = 0;
		$options['conditions'] = array($this->modelClass.'.account_id' => AuthComponent::user('account_id'));
		$this->request->data = $this->{$this->modelClass}->find('all', $options);
	}
    
   public function getclient($id = null)
    {
        $this->{$this->modelClass}->recursive = 1;
        
        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException();
        }
        $options['conditions'] = array(
            $this->modelClass.'.'. $this->{$this->modelClass}->primaryKey => $id
        );
        $this->request->data = $this->{$this->modelClass}->find('first', $options);
        
        foreach ($this->request->data['ClientActivityAssociate'] as $key => $value) {
            $secteur[] = $value['economic_activity'];
        }
        
        $eco_s = array();
        foreach ($secteur as $key => $value) {
            foreach (Configure::read('RelationManager.ActiviteEconomique') as $k => $v) {
                if (array_key_exists($value, $v)) {
                    $eco_s[$k][$value] = $v[$value];
                }
            }
        }
        $this->set(compact ('eco_s'));
    }
	
    public function getter($client_id)
    {
        if (!$this->{$this->modelClass}->exists($client_id)) {
                throw new NotFoundException();
            }
            $this->{$this->modelClass}->id = $client_id;
            $options['conditions'][$this->modelClass.'.id'] = $client_id;
            $this->request->data = $this->{$this->modelClass}->find('first', $options);
            
            foreach ($this->request->data['ClientActivityAssociate'] as $key => $value) {
                $associate[] = $value['economic_activity'];
            }
            $this->set(compact ('associate'));
    }
    
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Client->exists($id)) {
			throw new NotFoundException(__('Invalid client'));
		}
		$options = array('conditions' => array('Client.' . $this->Client->primaryKey => $id));
		$this->request->data = $this->Client->find('first', $options);
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
            
            $options['conditions'] = array(
                $this->modelClass.'.account_id' => AuthComponent::user('account_id'),
                $this->modelClass.'.name' => $this->request->data[$this->modelClass]['name']
            );
            
            if ($this->{$this->modelClass}->find('count', $options) > 0) {
                $check = 2;
                $response = __('%s existe déjà.', $this->request->data[$this->modelClass]['name']);
            } else {
    			$this->{$this->modelClass}->create();
                
                if (array_key_exists('secteur', $this->request->data)) {
                    foreach ($this->request->data['secteur'] as $key => $value) {
                        $this->request->data['ClientActivityAssociate'][$key]['economic_activity'] = $value;
                    }
                } else {
                    unset($this->request->data['ClientActivityAssociate']);
                    unset($this->request->data['secteur']);
                }
    			
    			if ($this->{$this->modelClass}->register($this->request->data)) {
    				$check = 0;
    				$response = __('%s a été créé avec succès.', $this->request->data[$this->modelClass]['sigle']);
    			} else {
    				$message = "";
    				foreach ($this->{$this->modelClass}->validationErrors as $v) {
                        $message = $v;
                        break;
    				}
    				$response = __('%s', $message);
    			}
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
	public function edit($id = null)
    {
        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException();
        }
        
        if ($this->request->is('post') || $this->request->is('put')) {
            if (array_key_exists('secteur', $this->request->data)) {
                foreach ($this->request->data['secteur'] as $key => $value) {
                    $this->request->data['ClientActivityAssociate'][$key]['economic_activity'] = $value;
                }
            } else {
                unset($this->request->data['ClientActivityAssociate']);
                unset($this->request->data['secteur']);
            }
            $check = 1;
            $this->request->data[$this->modelClass]['id'] = $id;
            
            if ($this->{$this->modelClass}->register($this->request->data)) {
                $check = 0;
                $response = __('< %s > a été mis à jour avec succès.', $this->request->data[$this->modelClass]['sigle']);
            } else {
                $message = "";
                foreach ($this->{$this->modelClass}->validationErrors as $v) {
                        $message = $v;
                        break;
                }
                $response = __('%s', $message);
            }
            $return = array('check' => $check, 'response' => $response);
            echo json_encode($return);
            
            $this->render('/Elements/empty');
        } else {
            $options = array('conditions' => array($this->modelClass .'.'. $this->{$this->modelClass}->primaryKey => $id));
            $this->request->data = $this->{$this->modelClass}->find('first', $options);
            
            foreach ($this->request->data['ClientActivityAssociate'] as $key => $value) {
                $secteur[] = $value['economic_activity'];
            }
            $this->set(compact ('secteur'));
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
		return $this->redirect(array('action' => 'index'));
	}
}
