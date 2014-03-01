<?php
$script = '
    $(document).ready(
        function()
        {
            loadcontent();
            $("#getMvt").on("click", loadcontent);
            $("#updateMvt").on("click", updatemvt);
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
            "'.$this->Html->url(array("action" => "getmvt", $this->request->params['pass'][0])).'", function() { unloading(); }
        ).fadeIn(400);
    }
    
    function updatemvt()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
            "'.$this->Html->url(array("action" => "edit", $this->request->params['pass'][0])).'", function() { unloading(); }
        ).fadeIn(400);
    }
    

';
echo $this->Html->scriptBlock($script, array('inline' => false));
?>

<div class="row-fluid">
    <!-- Widget -->
    <div class="widget  span12 clearfix">
        <div class="widget-header">
            <span><i class="icon-bookmark"></i> <?php echo __('Fiche de Mouvements'); ?> </span>
        </div><!-- End widget-header -->
        
        <div class="widget-content">
          
            <div class="boxtitle min">
                <h2>
                    <?php
                    echo __(
                        '%s%s',
                        $this->requestAction(array('action' => 'getprep', $this->request->data['Mouvement']['type'])),
                        $this->requestAction(array('action' => 'getcode', $this->request->data['Mouvement']['id']))
                    );
                    ?>
                </h2>
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
                                        <?php echo $this->Html->link(__('Voir la fiche'), 'Javascript:void(0)', array('id' => 'getMvt')); ?>
                                    </h4>
                                                                       
                                    <!--
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <?php echo $this->Html->link(__('Mettre à jour'), 'Javascript:void(0)', array('id' => 'updateMvt')); ?>
                                    </h4>
                                    -->
                                    
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <?php echo $this->Html->link(__('Mouvements'), array('action' => 'index')); ?>
                                    </h4>
                                    
                                </div>
                        </div>
                </div>
            </div><!-- row-fluid -->
        </div><!--  end widget-content -->
    </div><!-- widget  span12 clearfix-->
</div><!-- row-fluid -->