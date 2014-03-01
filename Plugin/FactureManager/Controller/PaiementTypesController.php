<?php
App::uses('FactureManagerAppController', 'FactureManager.Controller');
/**
 * PaiementTypes Controller
 *
 * @property PaiementType $PaiementType
 * @property PaginatorComponent $Paginator
 */
class PaiementTypesController extends FactureManagerAppController
{

/**
 * Components
 *
 * @var array
 */
	public $components = array();


    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->ajaxFunc = array('get', 'add');
        
        if (in_array($this->request->params['action'], $this->ajaxFunc)) {
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
        $options['recursive'] = 0;
        $options['order'] = array($this->modelClass.'.created DESC');
        
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
        return $this->redirect(array('controller' => 'pages', 'action' => 'display', 'dico', 'plugin' => false));
    }
}
