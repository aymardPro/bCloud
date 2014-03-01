<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController
{
/**
 * beforeFilter method
 *
 * @return void
 */
    public function beforeFilter()
    {
        parent::beforeFilter();
		
		$this->Auth->allow();
		//$this->Auth->allow('login', 'logout', 'confirm);
		
        $this->ajaxFunc = array('get', 'getprofil', 'add', 'edit', 'loginRequest');
		
        if ($this->request->params['action'] === 'login') {
            $this->layout = 'bCloud/login';
        }
        
        if (in_array($this->request->params['action'], $this->ajaxFunc)) {
			if (!$this->request->is('ajax')) {
				return $this->redirect(array('action' => 'index'));
			}
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
        $options['recursive'] = 1;
		$options['order'] = array($this->modelClass.'.created DESC');
		$masters = array((int) Configure::read('bCloud.Group.Admin'), (int) Configure::read('bCloud.Group.Manager'));
		
		if ((int) $this->Auth->user('group_id') !== (int) Configure::read('bCloud.Group.Admin')) {
        	$options['conditions'] = array(
        		$this->modelClass.'.group_id <>' => (int) Configure::read('bCloud.Group.Admin')
			);
		}
		
		if (!in_array((int) $this->Auth->user('group_id'), $masters)) {
        	$options['conditions'] = array(
        		$this->modelClass.'.account_id' => $this->Auth->user('account_id')
			);
		}
        
        $this->request->data = $this->{$this->modelClass}->find('all', $options);
    }
    
/**
 * getprofil method
 *
 * @return void
 */
    public function getprofil($id = null)
    {
        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException();
        }
        $options = array('conditions' => array($this->modelClass.'.'. $this->{$this->modelClass}->primaryKey => $id));
        $this->request->data = $this->{$this->modelClass}->find('first', $options);
    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function view($id)
    {
        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException();
        }
        $this->request->data = $this->{$this->modelClass}->read(null, $id);
        
        $this->options['conditions'] = array(
            'Proforma.date LIKE' => '%'.gmdate('Y-m').'%',
            'Proforma.user_id' => $id,
            'Proforma.proforma_statut_id' => Configure::read('bCloud.Proforma.Statut.WAITING'),
        );
        $waiting = $this->{$this->modelClass}->Proforma->find('all', $this->options);
        
        $this->options['conditions'] = array(
            'Proforma.date LIKE' => '%'.gmdate('Y-m').'%',
            'Proforma.user_id' => $id,
            'Proforma.proforma_statut_id' => Configure::read('bCloud.Proforma.Statut.VALIDE'),
        );
        $valide = $this->{$this->modelClass}->Proforma->find('all', $this->options);
        
        $this->options['conditions'] = array(
            'Proforma.date LIKE' => '%'.gmdate('Y-m').'%',
            'Proforma.user_id' => $id,
            'Proforma.proforma_statut_id' => Configure::read('bCloud.Proforma.Statut.REJETE'),
        );
        $rejete = $this->{$this->modelClass}->Proforma->find('all', $this->options);
        
        $this->set(compact('waiting', 'valide', 'rejete'));
    }
	
	public function addRequest()
	{
		if ($this->request->is('post')) {
            $check = 1;
            $this->{$this->modelClass}->create();
			
            if ($this->{$this->modelClass}->register($this->request->data)) {
                $check = 0;
                $response = __(
                    '%s %s a été créé avec succès.',
                    $this->request->data[$this->modelClass]['nom'],
                    $this->request->data[$this->modelClass]['prenoms']
                );
            } else {
                $message = null;
                foreach ($this->{$this->modelClass}->validationErrors as $v) {
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
 * add method
 *
 * @return void
 */
    public function add()
    {
    	$options = array();
		
		if ((int) $this->Auth->user('group_id') !== (int) Configure::read('bCloud.Group.Admin')) {
        	$options['conditions'] = array(
        		'Group.id <>' => (int) Configure::read('bCloud.Group.Admin')
			);
		}
        $accounts = $this->{$this->modelClass}->Account->find('list');
        $groups = $this->{$this->modelClass}->Group->find('list', $options);
        
        $this->set(compact('accounts', 'groups'));
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
        
        if ($this->request->is(array('post', 'put'))) {
            $check = 1;
            $this->{$this->modelClass}->id = $id;
            
            if ($this->{$this->modelClass}->save($this->request->data)) {
                $check = 0;
                $response = __('%s a été mis à jour avec succès.', $this->request->data[$this->modelClass]['email']);
            } else {
                $response = __('Erreur lors de la mise à jour de %s.', $this->request->data[$this->modelClass]['email']);
            }
            $return = array('check' => $check, 'response' => $response);
            echo json_encode($return);
            
            $this->render('/Elements/empty');
        } else {
            $options = array('conditions' => array($this->modelClass.'.'.$this->{$this->modelClass}->primaryKey => $id));
            $this->request->data = $this->{$this->modelClass}->find('first', $options);
        }
        $accounts = $this->{$this->modelClass}->Account->find('list');
        $groups = $this->{$this->modelClass}->Group->find('list');
        $this->set(compact('accounts', 'groups'));
    }

/**
 * confirm method
 *
 * @throws NotFoundException
 * @param string $token
 * @return void
 */
    public function confirm($email, $token)
    {
        if (!$this->{$this->modelClass}->confirm($email, $token)) {
            throw new NotFoundException(__('Ce lien n\'existe plus.'));
        }
        $this->Session->setFlash(__('Confirmation réussie. Un mail a été envoyé à %s.', $email), 'default', array('class' => 'alertMessage inline success'));
        return $this->redirect(array('action' => 'index'));
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
                __('%s %s a été supprimé avec succès.', $data[$this->modelClass]['nom'], $data[$this->modelClass]['prenoms']),
                'default',
                array('class' => 'alertMessage inline success')
            );
        } else {
            $this->Session->setFlash(
                __('%s ne peut pas être supprimé.', $data[$this->modelClass]['fullname']),
                'default',
                array('class' => 'alertMessage inline error')
            );
        }
        return $this->redirect(array('action' => 'index'));
    }
	
	public function loginRequest()
	{
		if ($this->request->is('post')) {
			
			if ($this->Auth->login()) {
	            if (!$this->Cookie->check($this->loginCookieName)) {
	            	$this->Cookie->write($this->loginCookieName, $this->Dream->encrypt($this->Auth->user('email')), true, 2592000);
            	}
            	
            	// Saving the datetime
                $this->{$this->modelClass}->id = $this->Auth->user('id');
                $this->{$this->modelClass}->saveField('lastvisite', gmdate('Y-m-d H:i:s'));
				
                $check = 1;
                $response = __('Welcome');
                $url = Configure::read('bCloud.fullBaseUrl') . $this->Auth->redirect();
            } else {
                $url = null;
                $check = 0;
                $response = __('E-Mail / Mot de passe incorrect');
            }
            $return = array('check' => $check, 'response' => $response, 'url' => $url);
            echo json_encode($return);
            
            $this->render('/Elements/empty');
		} else {
            if ($this->Cookie->check($this->loginCookieName) && !$this->Auth->user()) {
            	$this->set('login', $this->Dream->decrypt($this->Cookie->read($this->loginCookieName)));
            }
        }
	}
    
    public function login($bool = false)
    {
        $this->set('title_for_layout', __('Page de connexion'));
		
        if ($this->Auth->user()) {
            return $this->redirect('/', null, false);
        }
		
		if ($bool) {
			if ($this->Cookie->check($this->loginCookieName)) {
				$this->Cookie->write($this->loginCookieName, null, false, time()-3600);
				return $this->redirect(array('action' => 'login'));
			}
		}
    }
    
    public function logout()
    {
        if (!AuthComponent::user()) {
            return $this->redirect(array('action' => 'login'));
        }
        $user = $this->Auth->user();
        $this->Session->destroy();
		
        return $this->redirect($this->Auth->logout());
    }
}
