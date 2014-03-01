<?php
$script = '
    $(document).ready(
        function()
        {
            getClient();
            
            $(".atab1").on("click", getClient);
            $(".atab2").on("click", Contacts);
            $(".atab3").on("click", Proformas);
            $(".atab4").on("click", Factures);
            $(".alertMessage").on("click", hideAlert);
        }
    );
    
    function hideAlert()
    {
        $(this).stop(true, true).animate({ opacity: 0,right: "-20" }, 500, function() { $(this).hide(); });
    }
    
    function getClient()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load
        (
            "'.$this->Html->url(array('action' => 'getclient', $this->request->params['pass'][0])).'",
            function() { unloading(); }
        ).fadeIn(400);
    }
    
    function updateClient()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
            "'.$this->Html->url(array("action" => "edit", $this->request->params['pass'][0])).'", function() { unloading(); }
        ).fadeIn(400);
    }
    
    function Contacts()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
            "'.$this->Html->url(array("plugin" => "relation_manager", "controller" => "client_contacts", "action" => "get", $this->request->params['pass'][0])).'",
            function() { unloading(); }
        ).fadeIn(400);
    }
    
    function Proformas()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
            "'.$this->Html->url(array("plugin" => "facture_manager", "controller" => "proformas", "action" => "getClient", $this->request->params['pass'][0])).'",
            function() { unloading(); }
        ).fadeIn(400);
    }
    
    function Factures()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
            "'.$this->Html->url(array("plugin" => "facture_manager", "controller" => "proformas", "action" => "getClient", $this->request->params['pass'][0])).'",
            function() { unloading(); }
        ).fadeIn(400);
    }
';
echo $this->Html->scriptBlock($script, array('inline' => false));
?>

<div class="row-fluid">
    <!-- Widget -->
    <div class="widget  span12 clearfix">
        <div class="widget-header">
            <span><i class="icon-bookmark"></i> <?php echo __('Fiche Client'); ?> </span>
        </div><!-- End widget-header -->
        
        <div class="widget-content">
          
            <h2><?php echo h(__('%s - %s', $this->request->data['Client']['sigle'], $this->request->data['Client']['name'])) ?></h2>
            
            <div id="UITab" style="position:relative;">
                <ul class="ajaxtabs">
                    <li class="atab1 active"><a href="Javascript:void(0)">&nbsp;<?php echo __('Accueil') ?></a></li>
                    <li class="atab2"><a href="Javascript:void(0)">&nbsp;<?php echo __('Contacts') ?></a></li>
                    <!--
                    <li class="atab3"><a href="Javascript:void(0)">&nbsp;<?php echo __('Proformas') ?></a></li>
                    <li class="atab4"><a href="Javascript:void(0)">&nbsp;<?php echo __('Factures') ?></a></li>
                    -->
                </ul>
                
                <div class="tab_container">
                    <div class="tab_content">
                        <div id="getcontent"></div>
                    </div><!-- tab1 -->
                </div>
            </div>
            <!-- End UITab -->
            <div class="clearfix"></div>
            
            <!--
            <div class="row-fluid">
                <div class="span10">
                    <div id="getcontent"></div>
                </div>
                
                <div class="span2">
                            <div>
                                <div class="ui-accordion ui-widget ui-helper-reset ui-accordion-icons">
                                    
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <?php echo $this->Html->link(__('Voir la fiche'), 'Javascript:void(0)', array('id' => 'getClient')); ?>
                                    </h4>
                                    
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <?php echo $this->Html->link(__('Mettre à jour'), 'Javascript:void(0)', array('id' => 'updateClient')); ?>
                                    </h4>
                                    
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <?php echo $this->Html->link(__('Factures en cours'), 'Javascript:void(0)', array('id' => 'FactureClientWaiting')); ?>
                                    </h4>
                                    
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <?php echo $this->Html->link(__('Factures validées'), 'Javascript:void(0)', array('id' => 'FactureClientValide')); ?>
                                    </h4>
                                    
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <?php echo $this->Html->link(__('Factures rejetées'), 'Javascript:void(0)', array('id' => 'FactureClientReject')); ?>
                                    </h4>
                                    
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <?php echo $this->Html->link(__('Factures encaissées'), 'Javascript:void(0)', array('id' => 'FactureClientMonetise')); ?>
                                    </h4>
                                    
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <?php echo $this->Html->link(__('liste des clients'), array('action' => 'index')); ?>
                                    </h4>
                                </div>
                        </div>
                </div>
            </div><!-- row-fluid -->
            
        </div><!--  end widget-content -->
    </div><!-- widget  span12 clearfix-->
</div><!-- row-fluid -->