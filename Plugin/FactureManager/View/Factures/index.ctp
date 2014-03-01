<?php
$script = '
    $(document).ready(
    	function()
	    {
	        loadContent("'. Configure::read('bCloud.Facture.Statut.ACOMPTABILISER') .'");
            
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
';
echo $this->Html->scriptBlock($script, array('inline' => false));
?>

<!-- row-fluid -->
<div class="row-fluid">
	<!-- Table widget -->
	<div class="widget span12 clearfix">
		<div class="widget-header">
			<span><i class="icon-table"></i> <?php echo __('Gestion des Factures') ?> </span>
		</div><!-- End widget-header -->
		
		<div class="widget-content">
			<!-- Table UITab -->
			<div id="UITab" style="position:relative;">
				<ul class="ajaxtabs">
                    <li class="active tab" id="<?php echo Configure::read('bCloud.Facture.Statut.ACOMPTABILISER') ?>">
                        <a href="Javascript::void(0)"> <?php echo __('A comptabiliser') ?> </a>
                    </li>
                    <li class="tab" id="<?php echo Configure::read('bCloud.Facture.Statut.REGLE') ?>">
                        <a href="Javascript::void(0)"> <?php echo __('Réglé') ?> </a>
                    </li>
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