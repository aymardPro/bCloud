<?php
echo $this->element('shortcut');

$script = "
    $(document).ready
    (
        function()
        {
            loadClients();
            
            $('.atab1').on('click', loadClients);
        }
    );
    
    function loadClients()
    {
        alertHide();
        loading('Loading');
        $('#getcontent').load
        (
            '".$this->Html->url(array('controller' => 'clients', 'action' => 'get'))."',
            function() { unloading(); }
        ).fadeIn(400);
    }
";
echo $this->Html->scriptBlock($script, array('inline' => true));
?>

<div class="row-fluid">
	<!-- Dashboard widget -->
	<div class="widget span12 clearfix">
		<div class="widget-header">
			<span><i class="icon-user"></i> <?php echo __('Gestion des clients') ?> </span>
		</div><!-- End widget-header -->
		
		<div class="widget-content">
            
            <div id="UITab" class="clearfix" style="position:relative;">
                <ul class="ajaxtabs">
                    <li class="atab1 active"><a href="Javascript:void(0)">&nbsp;<?php echo __('Clients') ?></a></li>
                </ul>
				
				<div class="tab_container">
					<div id="getcontent"></div>
				</div>
			</div><!-- end uitab-->     
                            
		</div><!--  end widget-content -->
		
	</div><!-- widget  span12 clearfix-->
</div><!-- row-fluid -->

<?php
echo $this->element('footer');
echo $this->Js->writeBuffer();
?>
