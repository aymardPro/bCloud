<?php

$script = '
    $(document).ready(
        function()
        {
            $("#refresh").on("click", loadcontent);
            $("#edit").on("click", updatefacture);
            $("#print").on("click", printContent);
            $("#home").on("click", Home);
            $(".alertMessage").on("click", hideAlert);
        }
    );
    
    function hideAlert()
    {
        $(this).stop(true, true).animate({ opacity: 0,right: "-20" }, 500, function() { $(this).hide(); });
    }
    
    function loadcontent()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
            "'.$this->Html->url(array("action" => "getproforma", $this->request->params['pass'][0])).'", function() { unloading(); }
        ).fadeIn(400);
    }
    
    function printContent()
    {
        alertHide();
        window.open("'. $this->Html->url(array('action' => 'printer', $this->request->data['Proforma']['id'])) .'");
        return false;
    }
    
    function Home()
    {
        alertHide();
        $(location).attr("href", "'. $this->Html->url(array('action' => 'index')) .'");
    }
    
    function updatefacture()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
            "'.$this->Html->url(array("action" => "edit", $this->request->params['pass'][0])).'", function() { unloading(); }
        ).fadeIn(400);
    }
';
echo $this->Html->scriptBlock($script, array('inline' => true));
?>

<div class="btn-group pull-top-right btn-square">
    <a class="btn btn-large" href="javascript:void(0)" id="refresh">
        <i class="icon-refresh"></i> 
    </a>
    <a class="btn btn-large" href="javascript:void(0)" id="edit">
        <i class="icon-edit"></i> 
    </a>
    <a class="btn btn-large" href="javascript:void(0)" id="print" target="_blank">
        <i class="icon-print"></i> 
    </a>
    <a class="btn btn-large" href="javascript:void(0)" id="remove">
        <i class="icon-remove"></i> 
    </a>
    
    <a class="btn btn-large" href="javascript:void(0)" id="home">
        <i class="icon-home"></i> 
    </a>
</div>

<form>
    <div class="row-fluid">
        
        <div class="span4">
            
            <div class="section ">
                <label> Client<small></small></label>
                
                <div>
                    <?php echo h($this->request->data['Client']['name']) ?>
                </div>
            </div>
            
        </div>
        
        <div class="span4">
            
            <div class="section ">
                <label> Objet<small></small></label>
                
                <div>
                    <?php echo h($this->request->data['Proforma']['name']) ?>
                </div>
            </div>
            
            <div class="section">
                <label> Date<small></small></label>
                
                <div>
                    <?php echo h(CakeTime::format($this->request->data['Proforma']['date'], '%d-%m-%Y')) ?>
                </div>
            </div>
            
            <div class="section">
                <label> Echéance<small></small></label>
                
                <div>
                    <?php echo h(CakeTime::format($this->request->data['Proforma']['echeance'], '%d-%m-%Y')) ?>
                </div>
            </div>
            
        </div>
        
        <div class="span4">
            
            <div class="section ">
                <label> Garantie<small></small></label>
                
                <div>
                    <?php echo h($this->request->data['Proforma']['garantie']).'&nbsp;' ?>
                </div>
            </div>
            
            <div class="section">
                <label> Modalité </label>
                
                <div>
                    <?php echo h($this->request->data['PaiementModalite']['name']).'&nbsp;' ?>
                </div>
            </div>
            
            <div class="section">
                <label> Paiement par </label>
                
                <div>
                    <?php echo h($this->request->data['PaiementType']['name']).'&nbsp;' ?>
                </div>
            </div>
            
        </div>
    
    </div>
    
    <div class="row-fluid">
        
            <div class="boxtitle min">
                <h2><?php echo h('Détails articles') ?></h2>
            </div>
        
        <div class="section ">
            <table class="table table-striped iDream" id="data_table">
                <thead>
                    <tr>
                        <th class="left"> <?php echo __('Référence') ?> </th>
                        <th class="left"> <?php echo __('Designation') ?> </th>
                        <th class="center"> <?php echo __('Quantité') ?> </th>
                        <th class="right"> <?php echo __('Prx U.') ?> </th>
                        <th class="center"> <?php echo __('Remise (%)') ?> </th>
                        <th class="center"> <?php echo __('Taxe?') ?> </th>
                        <th class="right"> <?php echo __('Quantité X Prx U.') ?> </th>
                    </tr>
                </thead>
                
                <tbody align="center">
                    <?php foreach ($this->request->data['ProformaArticle'] as $factArticle): ?>
                        
                    <tr class="odd gradeX">
                        <td class="left"> 
                            <?php  echo h($factArticle['Article']['reference']);   ?>                                  
                        </td>    
                             
                        <td class="left"> 
                            <?php  echo h($factArticle['designation']);   ?>                             
                        </td>
                        
                        <td class="center"> 
                            <?php  echo CakeNumber::format($factArticle['qte']);   ?>                             
                        </td>
                        
                        <td class="right">
                            <?php  echo CakeNumber::format($factArticle['prix_vente']);   ?> 
                        </td>
                        
                        <td class="center"> 
                            <?php  echo ($factArticle['remise']);   ?>                             
                        </td>
                        
                        <td class="center"> 
                            <?php  echo ($factArticle['taxable']) ? 'Oui':'Non';   ?>                             
                        </td>
                        
                        <td class="right">
                            <?php  
                            $remise = ($factArticle['prix_vente'])*($factArticle['qte'])* ($factArticle['remise']/100);
                            echo CakeNumber::format(($factArticle['prix_vente'])*($factArticle['qte']) - ($remise));   
                            ?> 
                        </td>
                    </tr>
                    
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="span8" style="float: right">
            <table class="table table-striped iDream" id="data_table">
                <thead>
                    <tr>
                        <th class="right"> <?php echo __('Base') ?> </th>
                        <th class="center"> <?php echo __('% Taxe') ?> </th>
                        <th class="right"> <?php echo __('Montant Taxe') ?> </th>
                        <th class="center"><?php echo __('% Remise') ?> </th>
                        <th class="right"><?php echo __('Montant Remise') ?> </th>
                        <th class="right"> <?php echo __('Total HT') ?> </th>
                        <th class="right"><?php echo __('NET &Agrave; PAYER') ?> </th>
                    </tr>
                </thead>
                
                <tbody align="center">
                    <tr class="odd gradeX">
                        
                        <td class="right">
                            <?php
                            echo CakeNumber::format($this->requestAction('/proformas/idream_mt_base/'. $this->request->data['Proforma']['id']));
                            ?>
                        </td>
                        
                        <td class="center">
                            <?php echo (int) $this->request->data['Tax']['tau']. ' %' ?>
                        </td>
                        
                        <td class="right">
                            <?php
                            echo CakeNumber::format($this->requestAction('/proformas/idream_mt_tax/'. $this->request->data['Proforma']['id']));
                            ?>
                        </td>
                        
                        <td class="center">
                            <?php echo (int) $this->request->data['Proforma']['remise']. ' %' ?>
                        </td>
                        
                        <td class="right">
                            <?php
                            echo CakeNumber::format($this->requestAction('/proformas/idream_mt_remise/'. $this->request->data['Proforma']['id']));
                            ?>
                        </td>
                        
                        <td class="right">
                            <?php
                            echo CakeNumber::format($this->requestAction('/proformas/idream_mt_ht/'. $this->request->data['Proforma']['id']));
                            ?>
                        </td>
                        
                        <td class="right">
                            <strong style="font-size: 16px">
                            <?php
                            echo CakeNumber::format($this->requestAction('/proformas/idream_net_a_payer/'. $this->request->data['Proforma']['id']));
                            ?>
                            </strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</form>