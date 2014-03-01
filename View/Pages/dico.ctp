<?php
$script = '
    $(document).ready(
        function()
        {
            $(".shoutcutBox").each(
                function() {
                    $(this).click(
                        function() {
                            var ID = $(this).attr("id");
                            loader(ID)
                        }
                    )
                }
            );
            
            $(".alertMessage").on("click", hideAlert);
        }
    );
    
    function hideAlert()
    {
        $(this).stop(true, true).animate({ opacity: 0,right: "-20" }, 500, function() { $(this).hide(); });
    }
    
    function loader(controller)
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
        	"'. Configure::read('bCloud.fullBaseUrl') .'/"+ controller +"/get",
        	function(responseTxt, statusTxt, xhr) {
        		if (statusTxt=="error") {
					alertMessage("error", "Error "+xhr.status+": "+xhr.statusText);
				}
				unloading();
			}).fadeIn(400);
    }
';
echo $this->Html->scriptBlock($script, array('inline' => false));
?>

<div class="row-fluid">
    <!-- Dashboard  widget -->
    <div class="widget  span12 clearfix">
        <div class="widget-header">
            <span><i class="icon-align-left"></i> Dictionnaire de données </span>
        </div><!-- End widget-header -->
        
        <div class="widget-content">
            
            <!-- Table UITab -->
            <div id="UITab" style="position:relative;">
                <ul class="ajaxtabs">
                    <li class="active tab1"><a href="Javascript::void(0)"> <?php echo __('accueil') ?> </a></li>
                </ul>
                
                <div class="tab_container">
                    <div class="tab_content">
                        
                        <div class="boxtitle">Gestion du dictionnaire</div>
            
                        <div class="row-fluid">
                
                            <div class="span3">
                                
                                <div class="overflow" style="height: 480px; overflow: hidden;">
                                    <?php foreach ($shoutcutBoxArray as $key => $value) { ?>
                                    <div class="shoutcutBox" style="left: 0px;" id="<?php echo $value['id'] ?>">
                                        <span class="ico color paragraph_justify"></span>
                                        <strong style="font-size: 12px"><?php echo $value['label'] ?></strong>
                                    </div>
                                    <?php } ?>
                                </div>
                                
                            </div><!-- span3 column-->
                            
                            <div class="span9">
                                <div id="getcontent"></div>
                                <br />
                            </div><!-- span9 column-->
                            
                        </div><!-- row-fluid column-->
                        
                    </div><!--tab1-->
                </div>
            </div>
            
        </div><!--  end widget-content -->
    </div><!-- widget  span12 clearfix-->
</div><!-- row-fluid -->
                    