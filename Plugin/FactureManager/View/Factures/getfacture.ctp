
<form>
    <div class="row-fluid">
        <div class="section ">
            <label> Objet<small></small></label>
            
            <div style="font-size: 16px; font-weight: bold;">
                <?php echo h($this->request->data['Facture']['name']) ?>
            </div>
        </div>
        
        <div class="section ">
            <label> Client<small></small></label>
            
            <div style="font-size: 16px; font-weight: bold;">
                <?php echo h($this->request->data['Client']['name']) ?>
            </div>
        </div>
        
        <div class="section">
            <div style="font-size: 16px; font-weight: bold;">
                <span class="f_help"> Date</span>
                <?php echo h(CakeTime::format('d-m-Y H:i', $this->request->data['Facture']['date'])) ?>
            </div>
        </div>
        <br />
        
        <h3><?php echo __("Détails articles") ?></h3>
        
        <div class="section ">
            <table class="table table-striped iDream" id="data_table">
                <thead>
                    <tr>
                        <th class="left"> <?php echo __('Référence') ?> </th>
                        <th class="left"> <?php echo __('Designation') ?> </th>
                        <th class="center"> <?php echo __('Quantité') ?> </th>
                        <th class="right"> <?php echo __('Prx U.') ?> </th>
                        <th class="center"> <?php echo __('Remise (%)') ?> </th>
                        <th class="right"> <?php echo __('Quantité X Prx U.') ?> </th>
                    </tr>
                </thead>
                
                <tbody align="center">
                    <?php foreach ($this->request->data['FactureArticle'] as $factArticle): ?>
                        
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
                        <th class="right"> <?php echo __('Taxe') ?> </th>
                        <th class="right"><?php echo __('Tau Remise') ?> </th>
                        <th class="right"><?php echo __('Montant Remise') ?> </th>
                        <th class="right"><?php echo __('Acompte') ?> </th>
                        <th class="right"> <?php echo __('Total HT') ?> </th>
                        <th class="right"><?php echo __('NET &Agrave; PAYER') ?> </th>
                    </tr>
                </thead>
                
                <tbody align="center">
                    <tr class="odd gradeX">
                        <td class="right">
                            <?php
                            echo CakeNumber::format($this->requestAction('/factures/idream_mt_tax/'. $this->request->data['Facture']['id']));
                            ?>
                        </td>
                        
                        <td class="right">
                            <?php echo $this->request->data['Facture']['remise']. ' %' ?>
                        </td>
                        
                        <td class="right">
                            <?php
                            echo CakeNumber::format($this->requestAction('/factures/idream_mt_remise/'. $this->request->data['Facture']['id']));
                            ?>
                        </td>
                        
                        <td class="right">
                            <?php
                            echo CakeNumber::format($this->requestAction('/factures/idream_mt_acomptes/'. $this->request->data['Facture']['id']));
                            ?>
                        </td>
                        
                        <td class="right">
                            <?php
                            echo CakeNumber::format($this->requestAction('/factures/idream_mt_ht/'. $this->request->data['Facture']['id']));
                            ?>
                        </td>
                        
                        <td class="right">
                            <strong style="font-size: 16px">
                            <?php
                            echo CakeNumber::format($this->requestAction('/factures/idream_mt_ttc/'. $this->request->data['Facture']['id']));
                            ?>
                            </strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</form>