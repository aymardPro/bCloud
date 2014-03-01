<?php
$script = '
    $(document).ready(
    	function()
	    {
	    	if (!$("ul.ajaxtabs > li:first").hasClass("notab")) {
		    	var s = $("ul.ajaxtabs > li:first").attr("id");
		    	loadContent(s);
			}
			
	    	$(".tab").each(
	    		function() {
	    			$(this).click(
	    				function() {
	    					var ID = $(this).attr("id");
	    					loadContent(ID)
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
    
    function loadContent(i)
    {
    	alertHide();
    	loading("Loading");
		
        $("#getcontent").load(
        	"'.$this->Html->url(array("action" => "get")).'"+"/"+i,
            function() { unloading(); }
		).fadeIn(400);
    }
    
    function loadfournisseur()
    {
    	alertHide();
    	loading("Loading");
        $("#getcontent").load(
        	"'.$this->Html->url(array("action" => "get", Configure::read('bCloud.Fournisseur.id'))).'",
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
			<span><i class="icon-table"></i> <?php echo __('Gestion des mouvements de stock') ?> </span>
		</div><!-- End widget-header -->
		
		<div class="widget-content">
			<!-- Table UITab -->
			<div id="UITab" style="position:relative;">
				<ul class="ajaxtabs">
					<?php
					$tab = 1;
						foreach (Configure::read('bCloud.Mouvement.Type') as $key => $value) {
							if ($tab === 1) {
								$class = 'active ';
							} else {
								$class = '';
							}
							echo '<li class="'.$class.'tab" id="'.$key.'"><a href="Javascript::void(0)"> '.$value.' </a></li>';
							$tab++;
						}
					?>
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