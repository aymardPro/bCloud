<?php
App::uses('ArticleManagerAppController', 'ArticleManager.Controller');
/**
 * ArticleFamilles Controller
 *
 * @property ArticleFamille $ArticleFamille
 * @property PaginatorComponent $Paginator
 */
class ArticleFamillesController extends ArticleManagerAppController
{
	public function beforeFilter()
	{
        $this->ajaxFunc = array('get', 'add');
        parent::beforeFilter();
	}
	
/**
 * get method
 *
 * @return void
 */
	public function get()
	{
		$this->options['recursive'] = 0;
        $this->options['conditions'] = array(
            $this->modelClass.'.account_id' => AuthComponent::user('account_id'),
            $this->modelClass.'.parent' => 0,
            $this->modelClass.'.type' => 0,
        );
		$centralisateurs = $this->{$this->modelClass}->find('all', $this->options);
		
		foreach ($centralisateurs as $key => $value) {
			$this->request->data[] = $value;
			
			$this->options['conditions'] = array(
				$this->modelClass.'.account_id' => AuthComponent::user('account_id'),
	            $this->modelClass.'.parent' => $value[$this->modelClass]['id'],
	            $this->modelClass.'.type >' => 0,
	        );
			$details = $this->{$this->modelClass}->find('all', $this->options);
			
			foreach ($details as $key => $value) {
				$this->request->data[] = $value;
			}
		}
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ArticleFamille->exists($id)) {
			throw new NotFoundException(__('Invalid article famille'));
		}
		$options = array('conditions' => array('ArticleFamille.' . $this->ArticleFamille->primaryKey => $id));
		$this->set('articleFamille', $this->ArticleFamille->find('first', $options));
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
		$centralisateurs = $this->{$this->modelClass}->find('list', array(
			'conditions' => array(
				$this->modelClass.'.type' => 0
			)
		));
		$this->set(compact('centralisateurs'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->ArticleFamille->exists($id)) {
			throw new NotFoundException(__('Invalid article famille'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ArticleFamille->save($this->request->data)) {
				$this->Session->setFlash(__('The article famille has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The article famille could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ArticleFamille.' . $this->ArticleFamille->primaryKey => $id));
			$this->request->data = $this->ArticleFamille->find('first', $options);
		}
		$accounts = $this->ArticleFamille->Account->find('list');
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
			throw new NotFoundException();
		}
		$data = $this->{$this->modelClass}->read(null, $id);
		$this->request->onlyAllow('post', 'delete');
		
		if ($this->{$this->modelClass}->delete()) {
			$this->Session->setFlash(__('%s a été supprimé avec succès.', $data[$this->modelClass]['name']), 'default', array('class' => 'alertMessage inline success'));
		} else {
			$this->Session->setFlash(__('%s ne peut pas être supprimé.', $data[$this->modelClass]['name']), 'default', array('class' => 'alertMessage inline error'));
		}
		return $this->redirect(array('controller' => 'pages', 'action' => 'display', 'dico', 'plugin' => false));
	}
}
