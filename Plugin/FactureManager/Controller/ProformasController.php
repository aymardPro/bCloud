<?php
App::uses('ProformaManagerAppController', 'FactureManager.Controller');
App::import('Vendor', 'PDF', array('file' => 'PDF/PDF.php'));

/**
 * Proformas Controller
 *
 * @property Proforma $Proforma
 * @property PaginatorComponent $Paginator
 */
class ProformasController extends FactureManagerAppController
{
    public function beforeFilter()
    {
        parent::beforeFilter();
        $ajaxFunc = array(
            'get',
            'deletearticle', 
            'getFromUser', 
            'add', 
            'edit', 'getarticle', 'setarticle', 'factureClientIndex', 'factureClient', 'geteditarticle');
        
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
	    $option['order'] = array('ProformaStatut.id ASC');
	    $status = $this->{$this->modelClass}->ProformaStatut->find('list', $option);
        
		$this->set(compact('status'));
	}
    
    public function getproforma($id = null)
    {
        $this->_exists($id);
        
        $this->{$this->modelClass}->recursive = 2;
        $this->options['conditions'] = array($this->modelClass . '.' . $this->{$this->modelClass}->primaryKey => $id);
        $this->request->data = $this->{$this->modelClass}->find('first', $this->options);
       
    }
    
    public function getFromUser($statut, $user_id = false)
    {
        $this->options['recursive'] = 1;
        $this->options['order'] = array($this->modelClass.'.created DESC');
        $this->options['conditions'][$this->modelClass.'.proforma_statut_id'] = (int) $statut;
        
        if ($user_id) {
            $this->options['conditions'][$this->modelClass.'.user_id'] = $user_id;
        }
        
        $this->request->data = $this->{$this->modelClass}->find('all', $this->options);
        
        foreach ($this->request->data as $key => $value) {
            $date_range[] = $value['Proforma']['date'];
        }
        $this->set(compact('date_range'));
        
    }
    
    public function get($statut, $user_id = false)
    {
        $this->Session->delete('ProformaArticle');
        
        $options['recursive'] = 1;
        $options['order'] = array($this->modelClass.'.id DESC');
        $options['conditions'][$this->modelClass.'.proforma_statut_id'] = (int) $statut;
        
        if ($user_id) {
            $options['conditions'][$this->modelClass.'.user_id'] = $user_id;
        }
        
        $this->request->data = $this->{$this->modelClass}->find('all', $options);
    }
    
    public function getClient($client_id)
    {
        $this->options['recursive'] = 1;
        $this->options['order'] = array($this->modelClass.'.created DESC');
        $this->options['conditions'][$this->modelClass.'.client_id'] = (int) $client_id;
        
        $this->request->data = $this->{$this->modelClass}->find('all', $this->options);
    }
    
     public function printer($id)
    {
       $this->_exists($id);
       
       $this->layout = 'pdf';
       
       $this->request->data = $this->{$this->modelClass}->read(null, $id);
       
      
// Instanciation de la classe d���riv���e
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
//$pdf->Cell(0,10,'Page :'.$pdf->PageNo(),0,1);
// DEVIS
$pdf->SetFont('Arial','B',18);
$pdf->SetTextColor(0);
$pdf->Cell(0,10,utf8_decode("Devis N° ").$this->request->data[$this->modelClass]['reference'],0,0);
$pdf->Ln(7);
// DATE
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$pdf->Cell(0,10,'Abidjan, le '.CakeTime::format('d/m/Y', $this->request->data[$this->modelClass]['date']) ,0,0);
$pdf->Ln(7);
// cher client

$text1 =utf8_decode("Nous avons bien reçu votre demande de devis et nous vous en remercions.") ;
$text2 =utf8_decode("Nous vous prions de trouver ci-dessous nos conditions les meilleures");
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$pdf->Cell(0,10,'Cher Client,',0,0);
$pdf->Ln(4);
$pdf->Cell(0,10,$text1,0,0);
$pdf->Ln(4);
$pdf->Cell(0,10,$text2,0,1);
// CADRE CLIENT
$pdf->SetLineWidth(0);
$pdf->SetFillColor(192);
$pdf->RoundedRect(120, 43, 80, 30, 1, 'DF');
$pdf->SetXY(125,45);
$pdf->SetFont('Arial','',12);
$pdf->SetTextColor(204,0,0);
$pdf->Cell(0,10,utf8_decode($this->request->data['Client']['name']),0,1);

$pdf->SetXY(130,55);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$pdf->Cell(0,10,'Tel: '.$this->request->data['Client']['tel'],0,1);

$pdf->SetXY(160,55);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$pdf->Cell(0,10,'Fax: '.$this->request->data['Client']['fax'],0,1);

$pdf->SetXY(130,60);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$pdf->Cell(0,10,'Adresse: '.$this->request->data['Client']['email'],0,1);

$pdf->SetXY(130,65);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$pdf->Cell(0,10,'CC: '.$this->request->data['Client']['email'],0,1);



// tableau

$pdf->Ln(8);
$pdf->SetFont('Arial','B',8);
//Table de 20 lignes et 4 colonnes
$pdf->SetWidths(array(35,90,10,20,15,20));
$pdf->Row(array(utf8_decode("Référence"),utf8_decode("Désignation"),"Qte","P.U.HT","Remise","Montant HT"));
$pdf->SetFont('Arial','',8);
$c=0;

$y =20;
$base = $this->idream_mt_base($id);

foreach ($this->request->data['ProformaArticle'] as $key => $value) {
    $nombre_mot = str_word_count($value['designation']); //compte le nombre de mots dans la chaine
    
    $art = $this->{$this->modelClass}->ProformaArticle->Article->read(null, $value['article_id']);
    $prixVente = $this->requestAction(array(
                'plugin' => 'article_manager',
                'controller' => 'articles',
                'action' => 'getPrixVente',
                $value['article_id']
            ));
    $tht = ((int) $prixVente * (int) $value['qte']) - ((int) $prixVente * (int) $value['qte'] * ((int) $value['remise'] / 100));
    
    $pdf->Row(
        array(
            $art['Article']['reference'],
            utf8_decode($value['designation']),
            $value['qte'],
            CakeNumber::format($prixVente, array('thousands' => ' ', 'decimals' => '.', 'places' => 0, 'before' => '')),
            (int) $value['remise'],
            CakeNumber::format($tht, array('thousands' => ' ', 'decimals' => '.', 'places' => 0, 'before' => ''))
        ));
	
	/*
	if($nombre_mot <4){
	$y =$y + 5;
	
	}elseif($nombre_mot >3 AND $nombre_mot <6){
	$y =$y + 10;
	
	}elseif($nombre_mot >6 AND $nombre_mot <9){
	$y =$y + 15;
	
	}elseif($nombre_mot >9 AND $nombre_mot <12){
	$y =$y + 20;
	
	}elseif($nombre_mot >12 AND $nombre_mot <15){
	$y =$y + 25;    
	}elseif($nombre_mot >15 AND $nombre_mot <25){
	$y =$y + 30;    
	}
	 * */
	
	
	}

	$pdf->Ln(10);
	$y = $pdf->GetY();
	// BASE ET TVA
	$montant_tva = $this->idream_mt_tax($id);
	$pdf->SetXY(15,0+$y);
	$pdf->SetFont('Times','B',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10,'Base',0,0);
	
	$pdf->SetXY(15,4+$y);
	$pdf->SetFont('Times','',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10,CakeNumber::format($base),0,0);
	
	$pdf->SetXY(15,8+$y);
	$pdf->SetFont('Times','B',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10,'TVA',0,0);
	
	$pdf->SetXY(25,8+$y);
	$pdf->SetFont('Times','B',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10,(int) $this->request->data['Tax']['tau'].'%',0,0);
	
	$pdf->SetXY(15,12+$y);
	$pdf->SetFont('Times','',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10,CakeNumber::format($montant_tva),0,0);
	
	
	// LIGNE
	
	$pdf->Line( 35, 4+$y, 35, 20+$y);
	
	// taux remise 
	
	$montant_remise = $this->idream_mt_remise($id);
	$pdf->SetXY(40,0+$y);
	$pdf->SetFont('Times','B',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10,'Taux remise',0,0);
	
	$pdf->SetXY(40,4+$y);
	$pdf->SetFont('Times','',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10,(int) $this->request->data['Proforma']['remise'].' %',0,0);
	
	// total HT
	
	$pdf->SetXY(80,4+$y);
	$pdf->SetFont('Times','B',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10,'Total HT',0,0);
	
	$pdf->SetXY(80,12+$y);
	$pdf->SetFont('Times','',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10,CakeNumber::format($this->idream_mt_ht($id)),0,0);
	
	// Accompte
	
	$pdf->SetXY(105,4+$y);
	$pdf->SetFont('Times','B',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10,'Acompte',0,0);
	
	$pdf->SetXY(105,12+$y);
	$pdf->SetFont('Times','',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10,'0',0,0);
	
	
	// Remise
	
	$pdf->SetXY(130,4+$y);
	$pdf->SetFont('Times','B',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10,'Remise',0,0);
	
	$pdf->SetXY(130,12+$y);
	$pdf->SetFont('Times','',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10,CakeNumber::format($montant_remise),0,0);
	
	
	// net a payer
	
	$net_a_payer = $this->idream_net_a_payer($id);
	$pdf->SetXY(165,4+$y);
	$pdf->SetFont('Times','B',10);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10,'NET A PAYER',0,0);
	
	$pdf->SetLineWidth(0);
	$pdf->SetFillColor(192);
	$pdf->RoundedRect(160, 13+$y, 40, 8, 1, 'DF');
	
	$pdf->SetXY(170,12+$y);
	$pdf->SetFont('Times','B',10);
	$pdf->SetTextColor(255,0,0);
	$pdf->Cell(0,10,CakeNumber::format($net_a_payer),0,1);
	
	// condition de reglement
	$text3 = utf8_decode("Conditions de réglement");
	$text4 = utf8_decode($this->request->data['PaiementType']['name']);
	$text5 = utf8_decode($this->request->data['PaiementModalite']['name']);
	$pdf->SetLineWidth(0);
	$pdf->SetFillColor(192);
	$pdf->RoundedRect(10, 20+$y, 60, 15, 1, 'DF');
	
	$pdf->SetXY(25,18+$y);
	$pdf->SetFont('Times','B',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10,$text3,0,1);
	
	$pdf->SetXY(24,23+$y);
	$pdf->SetFont('Times','',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10,$text4,0,1);
	
	$pdf->SetXY(13,26+$y);
	$pdf->SetFont('Times','',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10,$text5,0,1);
	
	// ARRETE
	$pdf->Ln(15);
	
	$pdf->SetFont('Times','B',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10, utf8_decode('Arrêté la présente à la somme de:'),0,0,'R');
	$pdf->Ln(4);

     // inclure la classe
     include("Numbers/Words.php");
        
     // creer l'objet
     $nw = new Numbers_Words();
     $net_a_payer_lettre =  utf8_decode($nw->toWords($net_a_payer, 'fr'));

	$pdf->SetFont('Times','B',11);
	$pdf->SetTextColor(255,0,0);
	$pdf->Cell(0, 10, $net_a_payer_lettre. ' F CFA', 0, 1, 'R');
	$pdf->Ln(10);
	
	
	// representant et le directeur
	$representant = $this->request->data['User']['nom'].' '.$this->request->data['User']['prenoms'];
	$pdf->SetXY(10, 100+$y);
	$pdf->SetFont('Times','B', 11);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(0,10, utf8_decode('Représentant'),0,1);
	
	/*
	$pdf->SetXY(100,100+$y);
	$pdf->SetFont('Times','B',11);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(0,10,'Le Directeur General',0,1);
	*/
	
	$pdf->SetXY(10,105+$y);
	$pdf->SetFont('Times','B',12);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10, $representant,0,1);
	
	/*
	$pdf->SetXY(100,105+$y);
	$pdf->SetFont('Times','B',12);
	$pdf->SetTextColor(0);
	$pdf->Cell(0,10, '',0,1);
	*/



       $pdf->Output();
       
       $this->render('/Elements/empty');
    }

    /*
    public function printer($id)
    {
        $this->_exists($id);
        
        $this->layout = 'pdf';
        
        $this->request->data = $this->{$this->modelClass}->read(null, $id);
        
        $pdf = new PDF( 'P', 'mm', 'A4' );
        $pdf->AddPage();
        
        $pdf->addDevis( utf8_decode("Devis N° "), $this->request->data[$this->modelClass]['reference'] );
        //$pdf->temporaire( "SPECIMEN BCLOUD" );
        $pdf->addDate( CakeTime::format('d/m/Y', $this->request->data[$this->modelClass]['date']) );
        
        $CltName = $this->request->data['Client']['name'];
        $CltTel = $this->request->data['Client']['tel'];
        $CltCel = $this->request->data['Client']['cel'];
        $CltFax = $this->request->data['Client']['fax'];
        $CltEmail = $this->request->data['Client']['email'];
        $CltCC = $this->request->data['Client']['cc'];
        
        //$pdf->RoundedRect($pdf->x, $pdf->y, 100, 100, 5);
        
        $pdf->addClientInfos($CltName, $CltTel, $CltCel, $CltFax, $CltEmail, $CltCC);
        
        $pdf->addReglement(__('Par %s, %s', $this->request->data['PaiementModalite']['name'], $this->request->data[$this->modelClass]['modalite']));
        
        $header = array(
            utf8_decode("Référence") => array(30, "R"),
            utf8_decode("Désignation") => array(87, "L"),
            "Qte" => array(13, "C"),
            "P.U. HT" => array(20, "R"),
            "Remise" => array(20, "C"),
            "Montant" => array(20, "R")
        );
        foreach ($this->request->data['ProformaArticle'] as $key => $value) {
            $art = $this->{$this->modelClass}->ProformaArticle->Article->read(null, $value['article_id']);
            
            $data[] = array(
                $art['Article']['reference'],
                $value['designation'],
                $value['qte'],
                $value['prix_vente'],
                (int) $value['remise'],
                ($value['prix_vente'] * $value['qte']) - (($value['prix_vente'] * $value['qte']) * (int) $value['remise'] / 100),
            );
        }
        $pdf->ImprovedTable($header,$data);
        
        $cols=array( "Référence"    => 23,
                     "Désignation"  => 83,
                     "Qte"     => 13,
                     "P.U. HT"      => 26,
                     "Remise"          => 15,
                     "Montant H.T." => 30 );
        //$pdf->addCols( $cols );
        $cols=array( "Référence"    => "R",
                     "Désignation"  => "L",
                     "Qte"     => "C",
                     "P.U. HT"      => "R",
                     "Remise"          => "C",
                     "Montant H.T." => "R" );
        //$pdf->addLineFormat( $cols );
        //$pdf->addLineFormat( $cols );
        
        $i = 0;
        $y = 109;
        
        
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
        
        foreach ($this->request->data['ProformaArticle'] as $k => $v) {
            $tot_prods[] = array(
                'px_unit' => $v['prix_vente'],
                'qte' => $v['qte'],
                'tva' => 1,
            );
        }
        $tab_tva = array( "1" => 18 );
        $params  = array( "RemiseGlobale" => 1,
                              "remise_tva"     => 1,       // {la remise s'applique sur ce code TVA}
                              "remise"         => $this->idream_mt_remise($this->request->data[$this->modelClass]['id']),       // {montant de la remise}
                              "remise_percent" => $this->request->data[$this->modelClass]['remise'],      // {pourcentage de remise sur ce montant de TVA}
                          "FraisPort"     => 0,
                              //"portTTC"        => 10,      // montant des frais de ports TTC
                                                           // par defaut la TVA = 19.6 %
                              //"portHT"         => 0,       // montant des frais de ports HT
                              "portTVA"        => 18,    // valeur de la TVA a appliquer sur le montant HT
                          "AccompteExige" => 1,
                              "accompte"         => 0,     // montant de l'acompte (TTC)
                              "accompte_percent" => 0,    // pourcentage d'acompte (TTC)
                          "Remarque" => "" );
        
        $pdf->addTVAs(
            $params,
            $tab_tva,
            $tot_prods,
            $this->idream_mt_ht($this->request->data[$this->modelClass]['id']),
            $this->idream_mt_remise($this->request->data[$this->modelClass]['id']),
            (int) $this->request->data[$this->modelClass]['remise'],
            $this->request->data['Tax']['tau'],
            $this->idream_mt_tax($this->request->data[$this->modelClass]['id']),
            0,
            $this->idream_mt_ttc($this->request->data[$this->modelClass]['id']),
            $this->idream_net_a_payer($this->request->data[$this->modelClass]['id'])
        );
        //$pdf->addTVAs( $this->request->data[$this->modelClass]['id'] );
        $pdf->addCadreEurosFrancs();
     
        $pdf->Output();
        
        $this->render('/Elements/empty');
    }
     */ 
    
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
    
    public function idream_mt_base($proforma_id)
    {
        $options['recursive'] = 1;
        $options['conditions'] = array(
        	'ProformaArticle.proforma_id' => $proforma_id,
        	'ProformaArticle.taxable' => true
		);
        $lignes = $this->{$this->modelClass}->ProformaArticle->find('all', $options);
		$som = 0;
		
		foreach ($lignes as $key => $value) {
			$mt = (int) $value['ProformaArticle']['prix_vente'] * (int) $value['ProformaArticle']['qte'];
			$remise = $mt * (int) $value['ProformaArticle']['remise'] / 100;
			
			$som += $mt - $remise;
		}
        return (int) $som;
        
        $this->render('/Elements/empty');
    }
    
    public function idream_mt_ht($proforma_id)
    {
        $options['recursive'] = 1;
        $options['conditions'] = array(
        	'ProformaArticle.proforma_id' => $proforma_id
		);
        $lignes = $this->{$this->modelClass}->ProformaArticle->find('all', $options);
		$som = 0;
		
		foreach ($lignes as $key => $value) {
			$mt = (int) $value['ProformaArticle']['prix_vente'] * (int) $value['ProformaArticle']['qte'];
			$remise = $mt * (int) $value['ProformaArticle']['remise'] / 100;
			
			$som += $mt - $remise;
		}
        return (int) $som;
        $this->render('/Elements/empty');
    }
    
    public function idream_mt_remise($proforma_id)
    {
        $data = $this->{$this->modelClass}->read(null, $proforma_id);
        
        return (int) ($this->idream_mt_ht($proforma_id) * ((int) $data[$this->modelClass]['remise'] / 100));
        $this->render('/Elements/empty');
    }
    
    public function idream_mt_tax($proforma_id)
    {
        $data = $this->{$this->modelClass}->read(null, $proforma_id);
		
        return (int) ($this->idream_mt_base($proforma_id) * (int) $data['Tax']['tau'] / 100);
        $this->render('/Elements/empty');
    }
    
    public function idream_mt_ttc($proforma_id)
    {
        return (int) ($this->idream_mt_ht($proforma_id) + $this->idream_mt_tax($proforma_id));
        $this->render('/Elements/empty');
    }
    
    public function idream_net_a_payer($proforma_id)
    {
        return (int) ($this->idream_mt_ttc($proforma_id) - $this->idream_mt_remise($proforma_id));
        $this->render('/Elements/empty');
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
		$this->_exists($id);
        
		$this->options['conditions'] = array('Proforma.' . $this->{$this->modelClass}->primaryKey => $id);
		$this->request->data = $this->{$this->modelClass}->find('first', $this->options);
	}

/**
 * add method
 *
 * @return void
 */
	public function add($statut)
	{
        if ($this->request->is('post'))
        {
            $check = 1;
            $this->{$this->modelClass}->create();
            $this->request->data[$this->modelClass]['proforma_statut_id'] = $statut;
            
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
            $return = array('check' => $check, 'response' => $response);
            echo json_encode($return);
            
            $this->render('/Elements/empty');
        } else {
            $options['recursive'] = 0;
            $options['conditions'] = array(
                'Client.account_id' => AuthComponent::user('account_id'),
            );
            $clients = $this->{$this->modelClass}->Client->find('list', $options);
            
            $paiementModalites = $this->{$this->modelClass}->PaiementModalite->find('list');
            $paiementTypes = $this->{$this->modelClass}->PaiementType->find('list');
            $taxes = $this->{$this->modelClass}->Tax->find('list');
            
            $opt['recursive'] = 0;
            $articlesAll = $this->{$this->modelClass}->ProformaArticle->Article->find('all', $opt);
            
            foreach ($articlesAll as $key => $value) {
                $articles[$value['Article']['id']] = __('[ %s ] %s', $value['Article']['reference'], $value['Article']['designation']);
            }
            
            $this->set(compact('clients', 'paiementModalites', 'paiementTypes', 'taxes', 'articles'));
        }
	}
    
    public function geteditarticle($id = false)
    {
        if ($id) {
            $options['recursive'] = 1;
            $options['conditions'] = array($this->modelClass.'.id' => $id);
            
            $data = $this->{$this->modelClass}->find('first',$options);
            
            foreach ($data['ProformaArticle'] as $key => $value) {
                $article_id = $value['article_id'];
                
                $opt['recursive'] = -1;
                $opt['conditions'] = array('Article.id' => $article_id);
                $art = $this->{$this->modelClass}->ProformaArticle->Article->find('first', $opt);
                
                foreach ($value as $k => $v) {
                    if (!in_array($k, array('created', 'modified'))) {
                        $art['ProformaArticle'][$k] = $v;
                    }
                };
                $request = $this->Session->write('ProformaArticle.' . $article_id, $art);
            }
        }
        $this->request->data = ($this->Session->read('ProformaArticle')) ? $this->Session->read('ProformaArticle') : array();
    }
    
    public function getarticle()
    {
        $this->request->data = ($this->Session->read('ProformaArticle')) ? $this->Session->read('ProformaArticle') : array();
    }
    
    public function deletearticle()
    {
        if ($this->Session->check('ProformaArticle.'.$this->request->data['article_id'])) {
            $this->Session->delete('ProformaArticle.'.$this->request->data['article_id']);
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
    
    public function updatearticle()
    {
        if ($this->Session->check('ProformaArticle.'.$this->request->data['article_id'])) {
            $data = $this->Session->read('ProformaArticle.'.$this->request->data['article_id']);
            $data['ProformaArticle']['qte'] = implode('', explode(',', trim($this->request->data['qte'])));
			
			if (array_key_exists('taxable', $this->request->data)) {
				$data['ProformaArticle']['taxable'] = true;
			} else {
				$data['ProformaArticle']['taxable'] = null;
			}
            
            $article_data = $this->{$this->modelClass}->ProformaArticle->Article->read(null, $this->request->data['article_id']);
			
            $data['ProformaArticle']['remise'] = implode('', explode(',', trim($this->request->data['remise'])));
            $data['ProformaArticle']['prix_vente'] = implode('', explode(',', trim($this->request->data['prix_vente'])));
            $data['ProformaArticle']['designation'] = $this->{$this->modelClass}->uppercase($this->request->data['designation']);
			
            $this->Session->write('ProformaArticle.'.$this->request->data['article_id'], $data);
            $check = 0;
            $response = '';
        } else {
            $check = 1;
            $response = 'Mise à jour impossible.';
        }
        $return = array('check' => $check, 'response' => $response);
        echo json_encode($return);
        
        $this->render('/Elements/empty');
    }
    
    public function setarticle()
    {
        $response = '';
        $check = 0;
        
        if (!$this->{$this->modelClass}->ProformaArticle->Article->exists($this->request->data['article_id'])) {
            $response = 'Article invalide. Sélectionnez un article à ajouter.';
            $check = 1;
        } else {
            $article_data = $this->{$this->modelClass}->ProformaArticle->Article->read(null, $this->request->data['article_id']);
            
            $options['recursive'] = -1;
            $options['conditions'] = array('Article.id' => $this->request->data['article_id']);
            
            $article = $this->{$this->modelClass}->ProformaArticle->Article->find('first', $options);
            
            $article['ProformaArticle'] = array(
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
			$this->Session->write('ProformaArticle.' . $this->request->data['article_id'], $article);
        }
        $return = array('check' => $check, 'response' => $response);
        echo json_encode($return);
        
        $this->render('/Elements/empty');
    }
    
    public function get_montant_total($proforma_id = false)
    {
        if (!$proforma_id) {
            if ($this->Session->check('ProformaArticle')) {
                $facture = $this->Session->read('ProformaArticle');
            } else {
                $facture = false;
            }
        } else {
            $options['conditions'] = array($this->modelClass.'.id' => $proforma_id);
            $facture = $this->{$this->modelClass}->find('all', $options);
        }
        
        if ($facture) {
            $s = 0;
            foreach ($facture as $key => $value) {
                $s = $s + (($value['ProformaArticle']['prix_vente'] * $value['ProformaArticle']['qte']) - $this->get_article_remise($value));
            }
            return $s;
        }
        return null;
    }
        
    public function get_article_remise($article_data)
    {
        if ($article_data['ProformaArticle']['remise'] > 0) {
            $percent = $article_data['ProformaArticle']['remise']/100;
            return $article_data['ProformaArticle']['prix_vente'] * $article_data['ProformaArticle']['qte'] * $percent;
        }
        return null;
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
            $this->request->data[$this->modelClass]['id'] = $this->request->params['pass'][0];
            
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
            $return = array('check' => $check, 'response' => $response);
            echo json_encode($return);
            
            $this->render('/Elements/empty');
		} else {
			$this->options['conditions'] = array($this->modelClass. '.' . $this->{$this->modelClass}->primaryKey => $id);
			$this->request->data = $this->{$this->modelClass}->find('first', $this->options);
		}
            $this->options['recursive'] = 0;
            $this->options['conditions'] = array(
                'Client.account_id' => AuthComponent::user('account_id'),
            );
            $clients = $this->{$this->modelClass}->Client->find('list', $this->options);
            
            $paiementModalites = $this->{$this->modelClass}->PaiementModalite->find('list');
            $paiementTypes = $this->{$this->modelClass}->PaiementType->find('list');
            $taxes = $this->{$this->modelClass}->Tax->find('list');
            
            $this->options['recursive'] = 0;
			$this->options['conditions'] = array();
            $articlesAll = $this->{$this->modelClass}->ProformaArticle->Article->find('all', $this->options);
            
            foreach ($articlesAll as $key => $value) {
                $articles[$value['Article']['id']] = __('[ %s ] %s', $value['Article']['reference'], $value['Article']['designation']);
            }
            
            $this->set(compact('clients', 'paiementModalites', 'paiementTypes', 'taxes', 'articles'));
	}

/**
 * state method
 *
 * @throws NotFoundException
 * @param string $id string $statut
 * @return void
 */
    public function state($id, $statut)
    {
        $this->_exists($id);
        
        $this->request->onlyAllow('post');
        $this->{$this->modelClass}->id = $id;
        $data = $this->{$this->modelClass}->read(null, $id);
        
        if ($this->{$this->modelClass}->saveField('proforma_statut_id', $statut)) {
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
		$this->Proforma->id = $id;
		if (!$this->Proforma->exists()) {
			throw new NotFoundException(__('Invalid proforma'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Proforma->delete()) {
			$this->Session->setFlash(__('The proforma has been deleted.'));
		} else {
			$this->Session->setFlash(__('The proforma could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
