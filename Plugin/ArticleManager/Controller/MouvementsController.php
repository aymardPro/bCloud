<?php
App::uses('ArticleManagerAppController', 'ArticleManager.Controller');
/**
 * Mouvements Controller
 *
 * @property Mouvement $Mouvement
 * @property PaginatorComponent $Paginator
 */
class MouvementsController extends ArticleManagerAppController
{
	public function beforeFilter()
	{
		parent::beforeFilter();
		$ajaxFunc = array('get', 'add', 'edit', 'getstockarticle', 'updatearticle', 'deletearticle', 'setarticle');
		
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
	{
	    $this->Session->delete('MouvementArticle');
	}
    
    public function updatearticle()
    {
        if ($this->Session->check('MouvementArticle.'.$this->request->data['article_id'])) {
            $data = $this->Session->read('MouvementArticle.'.$this->request->data['article_id']);
            
            $data['MouvementArticle']['qte'] = implode('', explode(',', trim($this->request->data['qte'])));
            $data['MouvementArticle']['prix_unitaire'] = implode('', explode(',', trim($this->request->data['prix_unitaire'])));
            
            $this->Session->write('MouvementArticle.'.$this->request->data['article_id'], $data);
            $check = 1;
            $response = '';
        } else {
            $check = 0;
            $response = 'Mise à jour impossible.';
        }
        $return = array('check' => $check, 'response' => $response);
        echo json_encode($return);
        
        $this->render('/Elements/empty');
    }
    
    public function deletearticle()
    {
        if ($this->Session->check('MouvementArticle.'.$this->request->data['article_id'])) {
            $this->Session->delete('MouvementArticle.'.$this->request->data['article_id']);
            $check = 1;
            $response = '';
        } else {
            $check = 0;
            $response = 'Article requis.';
        }
        $return = array('check' => $check, 'response' => $response);
        echo json_encode($return);
        
        $this->render('/Elements/empty');
    }
    
    public function getstockarticle()
    {
        if ($this->Session->check('MouvementArticle')) {
            $getstockarticle = $this->Session->read('MouvementArticle');
        } else {
            $getstockarticle = array();
        }
        $this->set(compact('getstockarticle'));
    }
    
    public function setarticle()
    {
        $response = '';
        $check = 0;
        
        if (!$this->{$this->modelClass}->MouvementArticle->Article->exists($this->request->data['article_id'])) {
            $response = 'Article requis. Sélectionnez un article à ajouter.';
            $check = 1;
        } else {
            $boolean = true;
            
            if ((int) $this->request->data['type_id'] > 0) {
                if ($this->{$this->modelClass}->MouvementArticle->getStock($this->request->data['article_id']) < (int) $this->request->data['qte']) {
                    $boolean = false;
                }
            }
            
            if ($boolean) {
                $options['recursive'] = -1;
                $options['conditions'] = array('Article.id' => $this->request->data['article_id']);
                $article = $this->{$this->modelClass}->MouvementArticle->Article->find('first', $options);
                $article['MouvementArticle'] = array(
                    'article_id' => $this->request->data['article_id'],
                    'designation' => $article['Article']['designation'],
                    'prix_unitaire' => $article['Article']['prix_unitaire'],
                    'qte' => $this->request->data['qte'],
                );
                $this->Session->write('MouvementArticle.' . $this->request->data['article_id'], $article);
            } else {
                $response = 'Stock article insuffisant. Faites une entrée de stock avant de poursuivre.';
                $check = 2;
            }
        }
        $return = array('check' => $check, 'response' => $response);
        echo json_encode($return);
        
        $this->render('/Elements/empty');
    }

    public function __ArticleIsPresent($article_id)
    {
        if ($this->Session->read('MouvementArticle')) {
            foreach ($this->Session->read('MouvementArticle') as $key => $value) {
                if ($key === $article_id) {
                    return true;
                }
            }
        }
        return false;
    }
	
/**
 * get method
 *
 * @return void
 */
	public function get($type)
	{
        $this->Session->delete('MouvementArticle');
        
        $options['recursive'] = 0;
        $options['conditions'] = array(
            $this->modelClass.'.type' => $type,
            'Depot.account_id' => AuthComponent::user('account_id')
        );
        
        $this->request->data = $this->{$this->modelClass}->find('all', $options);
        
        switch ($type) {
            case 0:
                $code_prep = 'ME';
                $layout = 'get_entree';
                break;
            
            case 1:
                $code_prep = 'MS';
                $layout = 'get_sortie';
                break;
            
            case 2:
                $code_prep = 'MT';
                $layout = 'get_transfert';
                break;
        }
        $this->set(compact('code_prep'));
        $this->render($layout);
	}
    
    public function getprep($type)
    {
        switch ($type) {
            case 0:
                $code_prep = 'ME';
                break;
            
            case 1:
                $code_prep = 'MS';
                break;
            
            case 2:
                $code_prep = 'MT';
                break;
        }
        return $code_prep;
        $this->render('/Elements/empty');
    }
    
    public function getcode($int)
    {
        $zero = "";
        $nb = Configure::read('bCloud.Mouvement.CodeLenght');
        
        for ($i=0; $i < Configure::read('bCloud.Mouvement.CodeLenght') - strlen($int); $i++) { 
            $zero .= "0";
        }
        return $zero.$int;
        
        $this->render('/Elements/empty');
    }
	
    public function getter($client_id)
    {
            if (!$this->{$this->modelClass}->exists($client_id)) {
                throw new NotFoundException();
            }
            $this->{$this->modelClass}->id = $client_id;
            $options['conditions'][$this->modelClass.'.id'] = $client_id;
            $this->request->data = $this->{$this->modelClass}->find('first', $options);
            
            $opt = array();
            
            if ($this->Auth->user()) {
                $opt['conditions']['Account.id'] = $this->Auth->user('account_id');
            }
            $accounts = $this->{$this->modelClass}->Account->find('list', $opt);
            $clientActivities = $this->{$this->modelClass}->ClientActivity->find('list');
            $clientTypes = $this->{$this->modelClass}->MouvementType->find('list');
            $this->set(compact ('accounts', 'clientActivities', 'clientTypes'));
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
        $options['conditions'] = array($this->modelClass . '.' . $this->{$this->modelClass}->primaryKey => $id);
        $this->request->data = $this->{$this->modelClass}->find('first', $options);
	}
    
    
    public function getmvt($id = null)
    {
        $this->{$this->modelClass}->recursive = 2;
        
        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException(__('Cet mouvement n\'existe pas.'));
        }
        $options['conditions'] = array(
            $this->modelClass.'.'. $this->{$this->modelClass}->primaryKey => $id
        );
        $this->request->data = $this->{$this->modelClass}->find('first', $options);
        
        $opts['conditions'] = array('Depot.account_id' => AuthComponent::user('account_id'));
        $this->set('depots', $this->{$this->modelClass}->Depot->find('list', $opts));
      }

/**
 * add method
 *
 * @return void
 */
	public function add($type_id)
	{
		if ($this->request->is('post'))
		{
			$check = 1;
            
            if ((int) $type_id === 2) {
                $response = "La gestion des transferts n'est pas encore activée.";
            } else {
    			$this->{$this->modelClass}->create();
    			$this->request->data[$this->modelClass]['type'] = (int) $type_id;
    			
    			if ($this->{$this->modelClass}->register($this->request->data)) {
    				$check = 0;
    				$response = __('Mouvement %s a été créé avec succès.', $this->request->data[$this->modelClass]['name']);
    			} else {
    				$message = "";
    				if ($this->{$this->modelClass}->validationErrors) {
    					foreach ($this->{$this->modelClass}->validationErrors as $v) {
                            $message = $v;
                            break;
    					}
    				} else {
    					$message = "Quantité stock non disponible dans ce dépôt.";
    				}
    				$response = __('%s', $message);
    			}
            }
			$return = array('check' => $check, 'response' => $response, 'type' => $type_id);
	        echo json_encode($return);
			
			$this->render('/Elements/empty');
		} else {
		    $this->uses[] = 'Depot';
			$option2['conditions'] = array('Depot.account_id' => AuthComponent::user('account_id'));
			$depots = $this->Depot->find('list', $option2);
			
			$opt1['conditions'] = array(
				'ArticleFamille.type >' => 0
			);
			$opt2['conditions'] = array(
				'ArticleFamille.type' => 0
			);
			$articleFamilles = $this->{$this->modelClass}->MouvementArticle->Article->ArticleFamille->find('all', $opt1);
			$centralisateurs = $this->{$this->modelClass}->MouvementArticle->Article->ArticleFamille->find('list', $opt2);
			foreach ($articleFamilles as $key => $value) {
				$items[$value['ArticleFamille']['id']] = __('%s - %s', $centralisateurs[$value['ArticleFamille']['parent']], $value['ArticleFamille']['name']);	
			}
			foreach ($items as $k => $v) {
				$opt3['recursive'] = -1;
				$opt3['conditions'] = array(
                    'Article.article_famille_id' => $k,
                    'Article.stockable' => true,
                );
				$d = $this->{$this->modelClass}->MouvementArticle->Article->find('all', $opt3);
                
				foreach ($d as $k1 => $v2) {
					$articles[$v][$v2['Article']['id']]= __('%s - %s', $v2['Article']['reference'], $v2['Article']['designation']);
				}
			}
			$this->set(compact('depots', 'articles'));
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
		if (!$this->Mouvement->exists($id)) {
			throw new NotFoundException(__('Invalid mouvement'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Mouvement->save($this->request->data)) {
				$this->Session->setFlash(__('The mouvement has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The mouvement could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Mouvement.' . $this->Mouvement->primaryKey => $id));
			$this->request->data = $this->Mouvement->find('first', $options);
		}
		$mouvementTypes = $this->Mouvement->MouvementType->find('list');
		$depots = $this->Mouvement->Depot->find('list');
		$this->set(compact('mouvementTypes', 'depots'));
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
			throw new NotFoundException(__('Ce client est invalide.'));
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
