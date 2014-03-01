<?php

$script = '
    $(document).ready(
        function()
        {
            loadcontent();
            $(".atab1").on("click", loadcontent);
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
';
echo $this->Html->scriptBlock($script, array('inline' => false));
?>

<div class="row-fluid">
    <!-- Widget -->
    <div class="widget span12 clearfix">
        <div class="widget-header">
            <span><i class="icon-bookmark"></i> <?php echo __('Fiche Proforma'); ?> </span>
        </div><!-- End widget-header -->
        
        <div class="widget-content">
        	
            <h2><?php echo h($this->request->data['Proforma']['reference']) ?></h2>
            
            <div id="UITab" style="position:relative;">
                <ul class="ajaxtabs">
                    <li class="atab1 active"><a href="Javascript:void(0)">&nbsp;<?php echo __('Accueil') ?></a></li>
                </ul>
                
                <div class="tab_container">
                    <div class="tab_content">
                        <div id="getcontent"></div>
                    </div><!-- tab1 -->
                </div>
            </div>
            <!-- End UITab -->
            <div class="clearfix"></div>
            
        </div><!--  end widget-content -->
    </div><!-- widget  span12 clearfix-->
</div><!-- row-fluid -->