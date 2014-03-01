<?php
App::uses('FactureManagerAppController', 'FactureManager.Controller');
App::import('Vendor', 'PDF', array('file' => 'PDF/PDF.php'));

/**
 * Factures Controller
 *
 * @property Facture $Facture
 * @property PaginatorComponent $Paginator
 */
class FacturesController extends FactureManagerAppController
{
    public $statut_id;

/**
 * Components
 *
 * @var array
 */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $ajaxFunc = array('get', 'add', 'edit', 'getarticle', 'setarticle', 'factureClientIndex', 'factureClient', 'geteditarticle');
        
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
    
    public function factureClientIndex($client_id, $statut)
    {
        if (!$this->{$this->modelClass}->Client->exists($client_id)) {
            throw new NotFoundException();
        }
    }
    
    public function factureClient($client_id, $statut)
    {
        $this->Session->delete('FactureArticle');
        
        $options['recursive'] = 1;
        $options['conditions'] = array(
            $this->modelClass.'.client_id' => $client_id,
            $this->modelClass.'.statut_id' => $statut
        );
        $this->request->data = $this->{$this->modelClass}->find('all', $options);
    }
    
    public function get($statut)
    {
        $this->Session->delete('FactureArticle');
        
        $options['recursive'] = 1;
        $options['conditions'] = array(
            $this->modelClass.'.user_id' => AuthComponent::user('id'),
            $this->modelClass.'.statut_id' => $statut
        );
        $this->request->data = $this->{$this->modelClass}->find('all', $options);
    }
	
	public function __calc_real_montant_remise($ligne_article)
	{
	    $percent = $ligne_article['remise']/100;
		return ((int) $ligne_article['prix_vente'] * (int) $ligne_article['qte'] * $percent);
	}
	
	public function __calc_real_montant_total($lignes)
	{
		if (!empty($lignes)) {
			$s = 0;
			
			foreach ($lignes as $key => $value) {
				$s = $s + (((int) $value['prix_vente'] * $value['qte']) - $this->__calc_real_montant_remise($value));
			}
			return $s;
		}
		return null;
	}
	
	public function updatearticle()
	{
		if ($this->Session->check('FactureArticle.'.$this->request->data['article_id'])) {
            $stock = $this->{$this->modelClass}->FactureArticle->Article->MouvementArticle->getStock($this->request->data['article_id']);
            
            $data = $this->Session->read('FactureArticle.'.$this->request->data['article_id']);
            $data['FactureArticle']['qte'] = implode('', explode(',', trim($this->request->data['qte'])));
            
            $article_data = $this->{$this->modelClass}->FactureArticle->Article->read(null, $this->request->data['article_id']);
            
            if ($article_data['Article']['in_stock'] === true) {
                if ((int) Configure::read('bCloud.Facture.Statut.FACTURE') === (int) $this->statut_id) {
                    $stock = $this->{$this->modelClass}->FactureArticle->Article->MouvementArticle->getStock($this->request->data['article_id']);
                } else {
                    $stock = $this->request->data['qte']+1;
                }
            } else {
                $stock = $this->request->data['qte']+1;
            }
            
                
            if ($stock < $data['FactureArticle']['qte']) {
                $response = 'Stock insuffisant.';
                $check = 2;
            } else {
                $data['FactureArticle']['remise'] = implode('', explode(',', trim($this->request->data['remise'])));
                $data['FactureArticle']['prix_vente'] = implode('', explode(',', trim($this->request->data['prix_vente'])));
                $data['FactureArticle']['designation'] = $this->{$this->modelClass}->uppercase($this->request->data['designation']);
                
    			$this->Session->write('FactureArticle.'.$this->request->data['article_id'], $data);
    			$check = 0;
    			$response = '';
			}
		} else {
			$check = 1;
			$response = 'Mise à jour impossible.';
		}
		$return = array('check' => $check, 'response' => $response);
        echo json_encode($return);
		
		$this->render('/Elements/empty');
	}
	
	public function deletearticle()
	{
		if ($this->Session->check('FactureArticle.'.$this->request->data['article_id'])) {
			$this->Session->delete('FactureArticle.'.$this->request->data['article_id']);
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
    
    public function getarticle()
    {
        $this->request->data = ($this->Session->read('FactureArticle')) ? $this->Session->read('FactureArticle') : array();
    }
    
    public function geteditarticle($id = false)
    {
        if ($id) {
            $options['recursive'] = 1;
            $options['conditions'] = array($this->modelClass.'.id' => $id);
            
            $data = $this->{$this->modelClass}->find('first',$options);
            
            foreach ($data['FactureArticle'] as $key => $value) {
                $article_id = $value['article_id'];
                
                $opt['recursive'] = -1;
                $opt['conditions'] = array('Article.id' => $article_id);
                $art = $this->{$this->modelClass}->FactureArticle->Article->find('first', $opt);
                
                foreach ($value as $k => $v) {
                    if (!in_array($k, array('created', 'modified'))) {
                        $art['FactureArticle'][$k] = $v;
                    }
                };
                $request = $this->Session->write('FactureArticle.' . $article_id, $art);
            }
        }
        $this->request->data = ($this->Session->read('FactureArticle')) ? $this->Session->read('FactureArticle') : array();
    }
    
    public function acomptes($facture_id)
    {
        $options['recursive'] = 1;
        $options['conditions'] = array(
            'FactureAcompte.facture_id' => $facture_id
        );
        $this->request->data = $this->{$this->modelClass}->FactureAcompte->find('all', $options);
    }
	
	public function setarticle()
	{
		$response = '';
		$check = 0;
		
		if (!$this->{$this->modelClass}->FactureArticle->Article->exists($this->request->data['article_id'])) {
			$response = 'Article invalide. Sélectionnez un article à ajouter.';
			$check = 1;
		} else {
		    $article_data = $this->{$this->modelClass}->FactureArticle->Article->read(null, $this->request->data['article_id']);
            
            if ($article_data['Article']['stockable'] === true) {
                $stock = $this->{$this->modelClass}->FactureArticle->Article->MouvementArticle->getStock($this->request->data['article_id']);
            } else {
                $stock = $this->request->data['qte']+1;
            }
		    
		    if ($stock < $this->request->data['qte']) {
		        $response = 'Stock insuffisant.';
                $check = 2;
		    } else {
                $options['recursive'] = -1;
                $options['conditions'] = array('Article.id' => $this->request->data['article_id']);
                
                $article = $this->{$this->modelClass}->FactureArticle->Article->find('first', $options);
                
                $article['FactureArticle'] = array(
                    'article_id' => $this->request->data['article_id'],
                    'designation' => $article['Article']['designation'],
                    'prix_vente' => $this->requestAction(
                        array(
                            'plugin' => 'article_manager',
                            'controller' => 'articles',
                            'action' => 'getPrixVente',
                            $this->request->data['article_id']
                        )
                    ),
                    'qte' => $this->request->data['qte'],
                    'remise' => 0
                );
                $this->Session->write('FactureArticle.' . $this->request->data['article_id'], $article);
            }
		}
		$return = array('check' => $check, 'response' => $response);
        echo json_encode($return);
		
		$this->render('/Elements/empty');
	}

	public function __ArticleIsPresent($article_id)
	{
		if ($this->Session->read('FactureArticle')) {
			foreach ($this->Session->read('FactureArticle') as $key => $value) {
				if ($key === $article_id) {
					return true;
				}
			}
		}
		return false;
	}
    
    public function b_remise_ligne($article_id)
    {
        $data = $this->{$this->modelClass}->FactureArticle->findByArticleIdAndFactureId($article_id, $facture_id);
        
        if ($data) {
            return ($data['FactureArticle']['prix_vente'] * $data['FactureArticle']['qte'] * $data['FactureArticle']['remise'])/100;
        }
        return null;
    }
    
    public function b_total_ligne($article_id, $facture_id)
    {
        $data = $this->{$this->modelClass}->FactureArticle->findByArticleIdAndFactureId($article_id, $facture_id);
        
        if ($data) {
            return $data['FactureArticle']['prix_vente'] * $data['FactureArticle']['qte'];
        }
        return null;
    }
        
    public function get_article_remise($article_data)
    {
        if ($article_data['FactureArticle']['remise'] > 0) {
            $percent = $article_data['FactureArticle']['remise']/100;
            return $article_data['FactureArticle']['prix_vente'] * $article_data['FactureArticle']['qte'] * $percent;
        }
        return null;
    }
    
    public function __calc_montant_remise($article_data)
    {
        if ((int) $article_data['FactureArticle']['remise'] === 0) {
            return null;
        }
        return ($article_data['FactureArticle']['prix_vente'] * $article_data['FactureArticle']['qte'] * ($article_data['FactureArticle']['remise'] / 100));
    }
    
    public function __calc_montant_total()
    {
        if ($this->Session->read('FactureArticle')) {
            $s = 0;
            
            foreach ($this->Session->read('FactureArticle') as $key => $value) {
                $s = $s + (((int) $value['FactureArticle']['prix_vente'] * $value['FactureArticle']['qte']) - $this->__calc_montant_remise($value));
            }
            return $s;
        }
        return null;
    }
    
    public function idream_mt_ht($facture_id)
    {
        $this->{$this->modelClass}->recursive = 1;
        $options['conditions'] = array($this->modelClass.'.id' => $facture_id);
        $lignes = $this->{$this->modelClass}->find('first', $options);
        
        return $this->__calc_real_montant_total($lignes['FactureArticle']);
        
        $this->render('/Elements/empty');
    }
    
    public function idream_mt_remise($facture_id)
    {
        $data = $this->{$this->modelClass}->read(null, $facture_id);
        
        return $this->idream_mt_ht($facture_id) * ($data[$this->modelClass]['remise'] / 100);
        
        $this->render('/Elements/empty');
    }
    
    public function idream_mt_tax($facture_id)
    {
        $data = $this->{$this->modelClass}->read(null, $facture_id);
        
        $options2['recursive'] = 0;
        $options2['conditions'] = array('Tax.id' => $data['Facture']['tax_id']);
        $tax = $this->{$this->modelClass}->Tax->find('first', $options2);
        
        return ($tax['Tax']['tau'] / 100) * ($this->idream_mt_ht($facture_id) - $this->idream_mt_remise($facture_id));
        $this->render('/Elements/empty');
    }
    
    public function idream_mt_acomptes($facture_id)
    {
        $data = $this->{$this->modelClass}->FactureAcompte->find('all', array('conditions' => array('FactureAcompte.facture_id' => $facture_id)));
        $som = 0;
        
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $som = $som + $value['FactureAcompte']['value'];
            }
        }
        return $som;
        $this->render('/Elements/empty');
    }
    
    public function idream_mt_ttc($facture_id)
    {
        return ($this->idream_mt_ht($facture_id) - $this->idream_mt_remise($facture_id)) + $this->idream_mt_tax($facture_id);
        
        $this->render('/Elements/empty');
    }
    
    public function idream_net_a_payer($facture_id)
    {
        return $this->idream_mt_ttc($facture_id) - $this->idream_mt_acomptes($facture_id);
        
        $this->render('/Elements/empty');
    }
    
    public function get_facture_montant($facture_id)
    {
        $this->{$this->modelClass}->recursive = 1;
        $options['conditions'] = array($this->modelClass.'.id' => $facture_id);
        $lignes = $this->{$this->modelClass}->find('first', $options);
        
        $total = $this->__calc_real_montant_total($lignes['FactureArticle']);
        
        $options2['recursive'] = 0;
        $options2['conditions'] = array('Tax.id' => $lignes['Facture']['tax_id']);
        $tax = $this->{$this->modelClass}->Tax->find('first', $options2);
        
        $tp = $tax['Tax']['tau']/100;
        $tau = $total*$tp;
        
        if ($lignes['Facture']['remise'] > 0) {
            $p = $lignes['Facture']['remise']/100;
            $t = $total - ($total*$p);
        } else {
            $t = $total;
        }
        return $t+$tau;
        
        $this->render('/Elements/empty');
    }
    
    public function get_montant_total($facture_id = false)
    {
        if (!$facture_id) {
            if ($this->Session->check('FactureArticle')) {
                $facture = $this->Session->read('FactureArticle');
            } else {
                $facture = false;
            }
        } else {
            $options['conditions'] = array($this->modelClass.'.id' => $facture_id);
            $facture = $this->{$this->modelClass}->find('all', $options);
        }
        
        if ($facture) {
            $s = 0;
            foreach ($facture as $key => $value) {
                $s = $s + (($value['FactureArticle']['prix_vente'] * $value['FactureArticle']['qte']) - $this->get_article_remise($value));
            }
            return $s;
        }
        return null;
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
        if (!$this->Facture->exists($id)) {
            throw new NotFoundException();
        }
        $this->Session->delete('FactureArticle');
        
        $options = array('conditions' => array('Facture.' . $this->Facture->primaryKey => $id));
        $this->request->data = $this->{$this->modelClass}->find('first', $options);
	}
    
    public function printer($id)
    {
        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException();
        }
        $this->layout = 'pdf';
        
        $this->request->data = $this->{$this->modelClass}->read(null, $id);
        
        $pdf = new PDF( 'P', 'mm', 'A4' );
        $pdf->AddPage();
        /*
        $pdf->addSociete(
            "INTELAFRIQUE",
            "22 BP 1302 Abidjan 22\n" .
                "Treichville, Angle Rue des Charpentiers Rue des Selliers\n",
            "http://127.0.0.1/bCloud/img/logo.png");
         */ 
            
        $pdf->addDevis( utf8_decode("Devis N° "), $this->request->data['Facture']['reference'] );
        $pdf->temporaire( "SPECIMEN BCLOUD" );
        $pdf->addDate( CakeTime::format('d/m/Y', $this->request->data['Facture']['date']) );
        
        $CltName = $this->request->data['Client']['name'];
        $CltTel = $this->request->data['Client']['tel'];
        $CltCel = $this->request->data['Client']['cel'];
        $CltFax = $this->request->data['Client']['fax'];
        $CltEmail = $this->request->data['Client']['email'];
        $CltCC = $this->request->data['Client']['cc'];
        
        $pdf->addClientInfos($CltName, $CltTel, $CltCel, $CltFax, $CltEmail, $CltCC);
        
        $pdf->addReglement("Chèque à réception de facture");
        
        $header = array(
            "REFERENCE" => array(30, "R"),
            "DESIGNATION" => array(87, "L"),
            "QTE" => array(13, "C"),
            "P.U. HT" => array(20, "R"),
            "REMISE" => array(20, "C"),
            "MONTANT" => array(20, "R")
        );
        foreach ($this->request->data['FactureArticle'] as $key => $value) {
            $art = $this->{$this->modelClass}->FactureArticle->Article->read(null, $value['article_id']);
            
            $data[] = array(
                $art['Article']['reference'],
                $value['designation'],
                $value['qte'],
                $value['prix_vente'],
                $value['remise'],
                ($value['prix_vente'] * $value['qte']) - (($value['prix_vente'] * $value['qte']) * $value['remise'] / 100),
            );
        }
        $pdf->ImprovedTable($header,$data);
        
        $cols=array( "REFERENCE"    => 23,
                     "DESIGNATION"  => 83,
                     "Qte"     => 13,
                     "P.U. HT"      => 26,
                     "REMISE"          => 15,
                     "MONTANT H.T." => 30 );
        //$pdf->addCols( $cols );
        $cols=array( "REFERENCE"    => "L",
                     "DESIGNATION"  => "L",
                     "Qte"     => "C",
                     "P.U. HT"      => "R",
                     "REMISE"          => "C",
                     "MONTANT H.T." => "R" );
        //$pdf->addLineFormat( $cols );
        //$pdf->addLineFormat( $cols );
        
        $i = 0;
        $y = 109;
        
        /*
        foreach ($this->request->data['FactureArticle'] as $key => $value) {
            $art = $this->{$this->modelClass}->FactureArticle->Article->read(null, $value['article_id']);
            
            if ($i > 0) {
                $y += $size + 2;
            }
            $line = array(
                "REFERENCE" => $art['Article']['reference'],
                "DESIGNATION"  => $value['designation'],
                "Qte"     => $value['qte'],
                "P.U. HT"      => CakeNumber::format($value['prix_vente']),
                "REMISE"          => $value['remise'],
                "MONTANT H.T." => CakeNumber::format( $value['prix_vente'] * $value['qte'])
            );
            //$size = $pdf->addLine( $y, $line );
            $i++;
        }
         */ 
        
        $pdf->addCadreTVAs();
                
        // invoice = array( "px_unit" => value,
        //                  "qte"     => qte,
        //                  "tva"     => code_tva );
        // tab_tva = array( "1"       => 19.6,
        //                  "2"       => 5.5, ... );
        // params  = array( "RemiseGlobale" => [0|1],
        //                      "remise_tva"     => [1|2...],  // {la remise s'applique sur ce code TVA}
        //                      "remise"         => value,     // {montant de la remise}
        //                      "remise_percent" => percent,   // {pourcentage de remise sur ce montant de TVA}
        //                  "FraisPort"     => [0|1],
        //                      "portTTC"        => value,     // montant des frais de ports TTC
        //                                                     // par defaut la TVA = 19.6 %
        //                      "portHT"         => value,     // montant des frais de ports HT
        //                      "portTVA"        => tva_value, // valeur de la TVA a appliquer sur le montant HT
        //                  "AccompteExige" => [0|1],
        //                      "accompte"         => value    // montant de l'acompte (TTC)
        //                      "accompte_percent" => percent  // pourcentage d'acompte (TTC)
        //                  "Remarque" => "texte"              // texte
        
        foreach ($this->request->data['FactureArticle'] as $k => $v) {
            $tot_prods[] = array(
                'px_unit' => $v['prix_vente'],
                'qte' => $v['qte'],
                'tva' => 1,
            );
        }
        $tab_tva = array( "1" => 18 );
        $params  = array( "RemiseGlobale" => 1,
                              "remise_tva"     => 1,       // {la remise s'applique sur ce code TVA}
                              "remise"         => $this->idream_mt_remise($this->request->data['Facture']['id']),       // {montant de la remise}
                              "remise_percent" => $this->request->data['Facture']['remise'],      // {pourcentage de remise sur ce montant de TVA}
                          "FraisPort"     => 0,
                              //"portTTC"        => 10,      // montant des frais de ports TTC
                                                           // par defaut la TVA = 19.6 %
                              //"portHT"         => 0,       // montant des frais de ports HT
                              "portTVA"        => 18,    // valeur de la TVA a appliquer sur le montant HT
                          "AccompteExige" => 1,
                              "accompte"         => $this->idream_mt_acomptes($this->request->data['Facture']['id']),     // montant de l'acompte (TTC)
                              "accompte_percent" => 0,    // pourcentage d'acompte (TTC)
                          "Remarque" => "" );
        
        $pdf->addTVAs(
            $params,
            $tab_tva,
            $tot_prods,
            $this->idream_mt_ht($this->request->data['Facture']['id']),
            $this->idream_mt_remise($this->request->data['Facture']['id']),
            $this->request->data['Facture']['remise'],
            $this->request->data['Tax']['tau'],
            $this->idream_mt_tax($this->request->data['Facture']['id']),
            $this->idream_mt_acomptes($this->request->data['Facture']['id']),
            $this->idream_mt_ttc($this->request->data['Facture']['id']),
            $this->idream_net_a_payer($this->request->data['Facture']['id'])
        );
        //$pdf->addTVAs( $this->request->data['Facture']['id'] );
        $pdf->addCadreEurosFrancs();
        $pdf->Output();
        
        $this->render('/Elements/empty');
    }

/**
 * add method
 *
 * @return void
 */
    public function add() 
    {
        if ($this->request->is('post'))
        {
            $check = 1;
            $this->{$this->modelClass}->create();
            $this->request->data[$this->modelClass]['statut_id'] = $this->request->params['pass'][0];
            
            if ($this->{$this->modelClass}->register($this->request->data)) {
                $check = 0;
                $response = __('%s a été créé avec succès.', $this->request->data[$this->modelClass]['name']);
            } else {
                $message = "";
                foreach ($this->{$this->modelClass}->validationErrors as $v) {
                    $message = $v;
                    break;
                }
                $response = __('%s', $message);
            }
            $return = array('check' => $check, 'response' => $response, 'statut' => $this->request->data[$this->modelClass]['statut_id']);
            echo json_encode($return);
            
            $this->render('/Elements/empty');
        }
        
        $statuts = $this->{$this->modelClass}->Statut->find('list');
        
        $options['recursive'] = 0;
        $options['conditions'] = array(
            'Client.account_id' => AuthComponent::user('account_id'),
        );
        $clients = $this->{$this->modelClass}->Client->find('list', $options);
        
        $paiementModalites = $this->{$this->modelClass}->PaiementModalite->find('list');
        
        $options3['conditions'] = array(
            'Tax.account_id' => AuthComponent::user('account_id'),
            
        );
        $taxes = $this->{$this->modelClass}->Tax->find('list', $options3);
        $articlesAll = $this->{$this->modelClass}->FactureArticle->Article->find('all');
        
        foreach ($articlesAll as $key => $value) {
            $articles[$value['Article']['id']] = __('[ %s ] %s', $value['Article']['reference'], $value['Article']['designation']);
        }
        
        $this->set(compact('clients', 'statuts', 'paiementModalites', 'taxes', 'articles'));
    }

    public function acompte_add($facture_id) 
    {
        if (!$this->{$this->modelClass}->exists($facture_id)) {
            throw new NotFoundException();
        }

        if ($this->request->is('post'))
        {
            $check = 1;
            $this->{$this->modelClass}->FactureAcompte->create();
            $this->request->data['FactureAcompte']['facture_id'] = $facture_id;
            
            if ($this->{$this->modelClass}->FactureAcompte->register($this->request->data)) {
                $check = 0;
                $response = __('Nouvel acompte créé avec succès.');
            } else {
                $message = "";
                foreach ($this->{$this->modelClass}->FactureAcompte->validationErrors as $v) {
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
    
    public function getfacture($id = null)
    {     
        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException(__('Cette facture n\'existe pas.'));
        }
        $this->{$this->modelClass}->recursive = 2;
        $options = array('conditions' => array('Facture.' . $this->Facture->primaryKey => $id));
        $this->request->data = $this->{$this->modelClass}->find('first', $options);
       
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
		if (!$this->Facture->exists($id)) {
			throw new NotFoundException();
		}
        
		if ($this->request->is(array('post', 'put'))) {
            $check = 1;
            $this->request->data[$this->modelClass]['id'] = $this->request->params['pass'][0];
            $this->request->data[$this->modelClass]['statut_id'] = $this->request->data[$this->modelClass]['status'];
            
            if ($this->{$this->modelClass}->registerEdit($this->request->data)) {
                $check = 0;
                $response = __('%s a été mis à jour avec succès.', $this->request->data[$this->modelClass]['name']);
            } else {
                $message = "";
                foreach ($this->{$this->modelClass}->validationErrors as $v) {
                    $message = $v;
                    break;
                }
                $response = __('%s', $message);
            }
            $return = array('check' => $check, 'response' => $response, 'statut' => $this->request->data[$this->modelClass]['statut_id']);
            echo json_encode($return);
            
            $this->render('/Elements/empty');
		} else {
			$options = array('conditions' => array('Facture.' . $this->Facture->primaryKey => $id));
			$this->request->data = $this->Facture->find('first', $options);
            $this->statut_id = $this->request->data[$this->modelClass]['statut_id'];
		}
        
        $options['recursive'] = 0;
        $options['conditions'] = array(
            'Client.account_id' => AuthComponent::user('account_id'),
        );
        $clients = $this->{$this->modelClass}->Client->find('list', $options);
        
        $options2['conditions'] = array(
            'Paiement.account_id' => AuthComponent::user('account_id'),
            
        );                
        $paiements = $this->{$this->modelClass}->Paiement->find('list', $options2);
        
        $options3['conditions'] = array(
            'Tax.account_id' => AuthComponent::user('account_id'),
            
        );
        $taxes = $this->{$this->modelClass}->Tax->find('list', $options3);
        $articlesAll = $this->{$this->modelClass}->FactureArticle->Article->find('all');
        
        foreach ($articlesAll as $key => $value) {
            $articles[$value['Article']['id']] = __('[ %s ] %s', $value['Article']['reference'], $value['Article']['designation']);
        }
        
        $this->set(compact('clients', 'paiements', 'taxes', 'articles'));
	}

/**
 * state method
 *
 * @throws NotFoundException
 * @param string $id string $statut
 * @return void
 */
    public function state($id, $statut) {
        if (!$this->Facture->exists($id)) {
            throw new NotFoundException();
        }
        
        $this->request->onlyAllow('post');
        $this->{$this->modelClass}->id = $id;
        $data = $this->{$this->modelClass}->read(null, $id);
        
        if ($this->Facture->saveField('statut_id', $statut)) {
            $this->Session->setFlash(
                __('%s a été mis à jour avec succès.',$data[$this->modelClass]['reference']),
                'default',
                array('class' => 'alertMessage inline success')
            );
        } else {
            $this->Session->setFlash(
                __('%s ne peut pas être mis à jour.',$data[$this->modelClass]['reference']),
                'default',
                array('class' => 'alertMessage inline error')
            );
        }
        return $this->redirect(array('action' => 'index'));
    }

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function delete($id = null) {
        $this->Facture->id = $id;
        if (!$this->Facture->exists()) {
            throw new NotFoundException(__('Invalid facture'));
        }
        $data = $this->{$this->modelClass}->read(null, $id);
        $this->request->onlyAllow('post', 'delete');
        
        if ($this->{$this->modelClass}->delete()) {
            $this->Session->setFlash(__('%s a été supprimé avec succès.', $data[$this->modelClass]['reference']), 'default', array('class' => 'alertMessage inline success'));
        } else {
            $this->Session->setFlash(__('%s ne peut pas être supprimé.', $data[$this->modelClass]['reference']), 'default', array('class' => 'alertMessage inline error'));
        }
        return $this->redirect(array('action' => 'index'));
    }
    
    public function delete_acompte($id = null) {
        if (!$this->{$this->modelClass}->FactureAcompte->exists($id)) {
            throw new NotFoundException();
        }
        $this->request->onlyAllow('post', 'delete');
        $this->{$this->modelClass}->FactureAcompte->id = $id;
        $data = $this->{$this->modelClass}->FactureAcompte->read(null, $id);
        
        if ($this->{$this->modelClass}->FactureAcompte->delete()) {
            $this->Session->setFlash(__('Acompte supprimé avec succès.'), 'default', array('class' => 'alertMessage inline success'));
        } else {
            $this->Session->setFlash(__('%s ne peut pas être supprimé.'), 'default', array('class' => 'alertMessage inline error'));
        }
        return $this->redirect(array('action' => 'view', $data['FactureAcompte']['facture_id']));
    }
}
