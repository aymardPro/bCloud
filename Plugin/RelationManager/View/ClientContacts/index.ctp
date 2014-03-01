<?php
$script = "
    $(document).ready(
        function()
        {
            getContactsContent();
            $('.atab1').on('click', getEditContent);
            $('.atab2').on('click', getContactsContent);
            
        }
    );
    
    
    function getContactsContent()
    {
        alertHide();
        loading('Loading');
        $('#getcontent').load
        (
            '".$this->Html->url(array('action' => 'get', $this->request->params['pass'][0]))."',
            function() { unloading(); }
        ).fadeIn(400);
    }
    
    function getEditContent()
    {
        alertHide();
        loading('Loading');
        $('#getcontent').load
        (
            '".$this->Html->url(array('controller' => 'clients', 'action' => 'edit', $this->request->params['pass'][0]))."',
            function() { unloading(); }
        ).fadeIn(400);
    }
    
";
echo $this->Html->scriptBlock($script, array('inline' => false));
?>

<div class="row-fluid">
    <!-- Dashboard widget -->
    <div class="widget span12 clearfix">
        <div class="widget-header">
            <span><i class="icon-tags"></i> <?php echo __('Gestion des clients') ?> </span>
        </div><!-- End widget-header -->
        
        <div class="widget-content">
            
            <div id="UITab" class="clearfix" style="position:relative;">
                <ul class="ajaxtabs">
                    <li class="atab1">
                        <a href="Javascript:void(0)">
                            &nbsp;<?php echo __('Fiche client') ?>
                        </a>
                    </li>
                    <li class="atab2 active">
                        <a href="Javascript:void(0)">
                            &nbsp;<?php echo __('Contacts') ?>
                        </a>
                    </li>
                </ul>
                
                <div class="tab_container">
                  
                    <div id="getcontent"></div>
                </div>
            </div><!-- end uitab-->     
                            
        </div><!--  end widget-content -->
        
    </div><!-- widget  span12 clearfix-->
</div><!-- row-fluid -->