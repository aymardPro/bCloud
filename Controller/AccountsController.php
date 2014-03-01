<?php
App::uses('AppController', 'Controller');
/**
 * Accounts Controller
 *
 * @property Account $Account
 * @property PaginatorComponent $Paginator
 */
class AccountsController extends AppController
{

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->ajaxFunc = array('get', 'add');
        
        if (in_array($this->request->params['action'], $this->ajaxFunc)) {
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
        $options['order'] = array($this->modelClass.'.created DESC');
        
        $this->request->data = $this->{$this->modelClass}->find('all', $options);
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
        $options = array('conditions' => array('Account.' . $this->{$this->modelClass}->primaryKey => $id));
        $this->set('account', $this->{$this->modelClass}->find('first', $options));
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
        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException();
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->{$this->modelClass}->save($this->request->data)) {
                $this->Session->setFlash(__('The account has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The account could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Account.' . $this->Account->primaryKey => $id));
            $this->request->data = $this->{$this->modelClass}->find('first', $options);
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
        if (!$this->request->is(array('post', 'delete'))) {
            throw new NotFoundException();
        }
        
        if (!$this->{$this->modelClass}->exists($id)) {
           throw new NotFoundException();
        }
        
        $data = $this->{$this->modelClass}->read(null, $id);
        $this->request->onlyAllow('post', 'delete');
            
        if ($this->{$this->modelClass}->delete()) {
            $this->Session->setFlash(
              __('%s a été supprimé avec succès.', $data[$this->modelClass]['name']),
              'default', array('class' => 'alertMessage inline success')
            );
        } else {
            $this->Session->setFlash(
                __('%s ne peut pas être supprimé.', $data[$this->modelClass]['name']),
                'default', array('class' => 'alertMessage inline error')
            );
        }
        return $this->redirect(array('action' => 'index'));
    }
}
