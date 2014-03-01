<?php
App::uses('ArticleManagerAppController', 'ArticleManager.Controller');
/**
 * Articles Controller
 *
 * @property Article $Article
 */
class ArticlesController extends ArticleManagerAppController
{
    public function beforeFilter()
    {
        parent::beforeFilter();
        $ajaxFunc = array('get', 'add', 'getPrixVente', 'getMarge');
		
		$this->Auth->allow('getStock');
        
        if (in_array($this->request->params['action'], $ajaxFunc)) {
            $this->layout = 'ajax';
        }
    }

    public function getPrixVente($id)
    {
        $this->_exists($id);
        
        $data = $this->{$this->modelClass}->read(null, $id);
        return (int) $data[$this->modelClass]['prix_unitaire'] + $this->getMarge($id);
    }
    
    public function getMarge($id)
    {
        $this->_exists($id);
        
        $data = $this->{$this->modelClass}->read(null, $id);
        return (int) $data[$this->modelClass]['prix_unitaire'] * (int) $data[$this->modelClass]['marge'] / 100;
    }
	
	public function getStock($id)
	{
        $this->_exists($id);
		
		return $this->{$this->modelClass}->MouvementArticle->getStock($id);
		$this->render('/Elements/empty');
	}
    
/**
 * get method
 *
 * @return void
 */
    public function get()
    {
        $this->{$this->modelClass}->recursive = 0;
		$this->options['conditions'] = array(
            'ArticleFamille.account_id' => AuthComponent::user('account_id'),
        );
        $this->request->data = $this->{$this->modelClass}->find('all', $this->options);
        
        $this->options['conditions'] = array(
            'ArticleFamille.type' => 0,
        );
        $centralisateurs = $this->{$this->modelClass}->ArticleFamille->find('list', $this->options);
        $this->set(compact('centralisateurs'));
    }
    
    public function getarticle($id = null)
    {
        $this->_exists($id);
        
        $this->options['conditions'] = array(
            $this->modelClass.'.'. $this->{$this->modelClass}->primaryKey => $id
        );
        $this->request->data = $this->{$this->modelClass}->find('first', $this->options);
        
        $this->options['conditions'] = array(
            'ArticleFamille.type' => 0,
            'ArticleFamille.account_id' => AuthComponent::user('account_id')
        );
        $centralisateurs = $this->{$this->modelClass}->ArticleFamille->find('list', $this->options);
        $this->set(compact('centralisateurs'));
    }
    
/**
 * index method
 *
 * @return void
 */
	public function index()
	{}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null)
	{
	    $this->_exists($id);
	    
	    $this->options['conditions'] = array($this->modelClass.'.'. $this->{$this->modelClass}->primaryKey => $id);
		$this->request->data = $this->{$this->modelClass}->find('first', $this->options);
        
        $this->options['conditions'] = array(
            'ArticleFamille.type' => 0,
            'ArticleFamille.account_id' => AuthComponent::user('account_id')
        );
        $centralisateurs = $this->{$this->modelClass}->ArticleFamille->find('list', $this->options);
        $this->set(compact('centralisateurs'));
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
                $response = __('%s a été créé avec succès.', $this->request->data[$this->modelClass]['reference']);
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
		}
		
		$this->options['conditions'] = array(
            'ArticleFamille.type' => 0
        );
		$articleFamilles = $this->{$this->modelClass}->ArticleFamille->find('list', $this->options);
        
        foreach ($articleFamilles as $key => $value) {
            $this->options['conditions'] = array('ArticleFamille.parent' => $key);
            $articleFamilles[$value] = $this->{$this->modelClass}->ArticleFamille->find('list', $this->options);
        }
		$unites = $this->{$this->modelClass}->Unite->find('list');
		$this->set(compact('articleFamilles', 'unites'));
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
	    $this->_exists($id);
        
		if ($this->request->is(array('post', 'put'))) {
            $check = 1;
            $this->{$this->modelClass}->id = $id;
            
            if ($this->{$this->modelClass}->register($this->request->data)) {
                $check = 0;
                $this->Session->setFlash(__('%s a été mis à jour avec succès.', $this->request->data[$this->modelClass]['reference']),
                'default',
                array('class' => 'alertMessage inline success'));
                $response = '';
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
		}
        
        $this->options['conditions'] = array(
            'ArticleFamille.account_id' => AuthComponent::user('account_id'),
            'ArticleFamille.type' => 0
        );
        $articleFamilles = $this->{$this->modelClass}->ArticleFamille->find('list', $this->options);
        
        foreach ($articleFamilles as $key => $value) {
            $this->options['conditions'] = array('ArticleFamille.parent' => $key);
            $articleFamilles[$value] = $this->{$this->modelClass}->ArticleFamille->find('list', $this->options);
        }
        $unites = $this->{$this->modelClass}->Unite->find('list');
        $this->set(compact('articleFamilles', 'unites'));
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
	    $this->_exists($id);
        
        $data = $this->{$this->modelClass}->read(null, $id);
        $this->request->onlyAllow('post', 'delete');
        
        if ($this->{$this->modelClass}->delete()) {
            $this->Session->setFlash(
                __('%s a été supprimé avec succès.', $data[$this->modelClass]['reference']),
                'default',
                array('class' => 'alertMessage inline success')
            );
        } else {
            $this->Session->setFlash(
                __('%s ne peut pas être supprimé.', $data[$this->modelClass]['reference']),
                'default',
                array('class' => 'alertMessage inline error')
            );
        }
        return $this->redirect(array('action' => 'index'));
	}
}
