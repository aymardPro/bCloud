<?php

$script = '
    $(document).ready(
        function()
        {
            loadcontent();
            $("#getFacture").on("click", loadcontent);
            $("#updateFacture").on("click", updatefacture);
            $("#Impression").on("click", loadImpression);
            $("#Acomptes").on("click", loadAcomptes);
            $("#AcompteAdd").on("click", loadAcompteAdd);
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
            "'.$this->Html->url(array("action" => "getfacture", $this->request->params['pass'][0])).'", function() { unloading(); }
        ).fadeIn(400);
    }
    
    function updatefacture()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
            "'.$this->Html->url(array("action" => "edit", $this->request->params['pass'][0])).'", function() { unloading(); }
        ).fadeIn(400);
    }
    
    function loadImpression()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
            "'.$this->Html->url(array("action" => "mouvements", $this->request->params['pass'][0])).'", function() { unloading(); }
        ).fadeIn(400);
    }
    
    function loadAcomptes()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
            "'.$this->Html->url(array("action" => "acomptes", $this->request->data['Facture']['id'])).'", function() { unloading(); }
        ).fadeIn(400);
    }
    
    function loadAcompteAdd()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
            "'.$this->Html->url(array("action" => "acompte_add", $this->request->data['Facture']['id'])).'", function() { unloading(); }
        ).fadeIn(400);
    }
';
echo $this->Html->scriptBlock($script, array('inline' => false));
?>

<div class="row-fluid">
    <!-- Widget -->
    <div class="widget  span12 clearfix">
        <div class="widget-header">
            <span><i class="icon-bookmark"></i> <?php echo __('Fiche Facture'); ?> </span>
        </div><!-- End widget-header -->
        
        <div class="widget-content">
          
            <div class="boxtitle min">
                <h2><?php echo h(__('Detail : %s', $this->request->data['Facture']['reference'])) ?></h2>
            </div>
          
            <div class="row-fluid">
                <div class="span10">
                    <div id="getcontent"></div>
                </div>
                
                <div class="span2">
                       <div>
                             <div class="ui-accordion ui-widget ui-helper-reset ui-accordion-icons">
                                    
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <?php echo $this->Html->link(__('Détails'), 'Javascript:void(0)', array('id' => 'getFacture')); ?>
                                    </h4>
                                    
                                    <?php if ((int) $this->request->data['Facture']['statut_id'] === (int) Configure::read('bCloud.Facture.Statut.WAITING')) { ?>
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <?php echo $this->Html->link(__('Modifier'), 'Javascript:void(0)', array('id' => 'updateFacture')); ?>
                                    </h4>
                                    <?php } ?>
                                    
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <?php
                                        echo $this->Html->link(
                                            __('Imprimer'),
                                            array('action' => 'printer', $this->request->data['Facture']['id']),
                                            array('id' => 'Impression', 'target' => '_blank')
                                        );
                                        ?>
                                    </h4>
                                    
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <?php
                                        echo $this->Html->link(
                                            __('Acomptes'),
                                            'Javascript:void(0)',
                                            array('id' => 'Acomptes')
                                        );
                                        ?>
                                    </h4>
                                    
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <?php
                                        echo $this->Html->link(
                                            __('Ajouter acompte'),
                                            'Javascript:void(0)',
                                            array('id' => 'AcompteAdd')
                                        );
                                        ?>
                                    </h4>
                                    
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <?php echo $this->Html->link(__('Retour'), array('action' => 'index')); ?>
                                    </h4>
                                    
                                </div>
                        </div>
                </div>
            </div><!-- row-fluid -->
        </div><!--  end widget-content -->
    </div><!-- widget  span12 clearfix-->
</div><!-- row-fluid -->