<?php
$script = '
    $(document).ready(
    	function()
	    {
	    	loadcontent();
	    	$(".tab1").on("click", loadcontent);
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
        	"'.$this->Html->url(array("action" => "get")).'",
            function() { unloading(); }
		).fadeIn(400);
    }
';
echo $this->Html->scriptBlock($script, array('inline' => false));
?>

<!-- row-fluid -->
<div class="row-fluid">
	<!-- Table widget -->
	<div class="widget span12 clearfix">
		<div class="widget-header">
			<span><i class="icon-table"></i> <?php echo __('Gestion des statuts') ?> </span>
		</div><!-- End widget-header -->
		
		<div class="widget-content">
			<!-- Table UITab -->
			<div id="UITab" style="position:relative;">
				<ul class="ajaxtabs">
					<li class="active tab1"><a href="Javascript::void(0)"> <?php echo __('accueil') ?> </a></li>
				</ul>
				
				<div class="tab_container">
					<div class="tab_content">
						<div id="getcontent"></div>
					</div><!--tab1-->
				</div>
			</div>
			<!-- End UITab -->
			<div class="clearfix"></div>
		</div>
		<!--  end widget-content -->
	</div>
	<!-- widget  span12 clearfix-->
</div>
<!-- end row-fluid -->