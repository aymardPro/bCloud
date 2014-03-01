<?php
echo $this->element('shortcut');

$script = "
    $(document).ready
    (
    	function()
	    {
	        getEditContent();
	    	$('.atab1').on('click', getEditContent);
            $('#info').on('click', getEditContent);
            $('#addrfact').on('click', addrfact);
            $('#sitgeo').on('click', sitgeo);
            $('#tel').on('click', tel);
            $('#cel').on('click', cel);
            $('#fax').on('click', fax);
            $('#email').on('click', email);
            $('#contacts').on('click', clientscontacts);
            $('#clientsproduits').on('click', clientsproduits);
	    }
    );
    
    function getEditContent()
    {
    	alertHide();
    	loading('Loading');
        $('#getcontent').load
        (
        	'".$this->Html->url(array('action' => 'edit', $this->request->params['pass'][0]))."',
            function()
            {
            	unloading();
			}
		).fadeIn(400);
    }
    
    function Notify()
    {
        alertHide();
        var NAME = $(this).attr('data-name');
        var ID = $(this).attr('data-id');
        
        $.confirm(
        {
            'title': 'FENETRE DE NOFICATION',
            'message': '<strong>VOULEZ-VOUS SUPPRIMER </strong><br /><font color=red>'+ NAME +'</font>',
            'buttons':
            {
                'Confirmer':
                {
                    'class': 'special',
                    'action': function ()
                    {
                        // Action when button Yes click.
                        loading('Loading');
                        
                        var Request = $.ajax(
                            {
                                url: '".$this->Html->url(array('action' => 'delete'))."' + '/' + ID,
                                cache: false,
                                type: 'DELETE',
                                dataType: 'json'
                            }
                        );
                        
                        Request.fail(
                            function(jqXHR, textStatus, errorThrown)
                            {
                                unloading();
                                alertMessage('error', 'Error. Join your web admin to resolve it.');
                                return false;
                            }
                        );
                        
                        Request.done(
                            function(msg)
                            {
                                if (msg.check == 1) {
                                    $('#getcontent').fadeIn(
                                        400,
                                        function()
                                        {
                                            $('#getcontent').load(
                                                '".$this->Html->url(array('action' => 'get'))."',
                                                function()
                                                {
                                                    unloading();
                                                    alertMessage('success', msg.response);
                                                }
                                            );
                                        }
                                    );
                                } else {
                                    unloading();
                                    alertMessage('warning', msg.response);
                                    return false;
                                }
                            }
                        );
                    }
                },
                'Annuler': {'class' : ''}
            }
        });
    }

    function addrfact(){
        loading('Loading');
        $('#getcontent').load('".$this->Html->url(array(
            'controller' => 'clients_adresses_facturations',
            'action' => 'get',
            $this->request->data['Client']['id']
        ))."', function(){unloading();}).fadeIn(400);
    }
    
        
    function sitgeo(){
        loading('Loading');
        $('#getcontent').load('".$this->Html->url(array(
            'controller' => 'clients_adresses',
            'action' => 'get',
            $this->request->data['Client']['id']
        ))."', function(){unloading();}).fadeIn(400);
    }
    
    function tel(){
        loading('Loading');
        $('#getcontent').load('".$this->Html->url(array(
            'controller' => 'clients_telephones',
            'action' => 'get',
            $this->request->data['Client']['id']
        ))."', function(){unloading();}).fadeIn(400);
    }
    
    function cel(){
        loading('Loading');
        $('#getcontent').load('".$this->Html->url(array(
            'controller' => 'clients_cellulaires',
            'action' => 'get',
            $this->request->data['Client']['id']
        ))."', function(){unloading();}).fadeIn(400);
    }
    
    function fax(){
        loading('Loading');
        $('#getcontent').load('".$this->Html->url(array(
            'controller' => 'clients_fax_numeros',
            'action' => 'get',
            $this->request->data['Client']['id']
        ))."', function(){unloading();}).fadeIn(400);
    }
    
    function email(){
        loading('Loading');
        $('#getcontent').load('".$this->Html->url(array(
            'controller' => 'clients_emails',
            'action' => 'get',
            $this->request->data['Client']['id']
        ))."', function(){unloading();}).fadeIn(400);
    }
    
    function clientscontacts(){
        loading('Loading');
        $('#getcontent').load('".$this->Html->url(array(
            'controller' => 'clients_contacts',
            'action' => 'get',
            $this->request->data['Client']['id']
        ))."', function(){unloading();}).fadeIn(400);
    }
    
    function clientsproduits(){
        loading('Loading');
        $('#getcontent').load('".$this->Html->url(array(
            'controller' => 'clients_produits',
            'action' => 'get',
            $this->request->data['Client']['id']
        ))."', function(){unloading();}).fadeIn(400);
    }
";
echo $this->Html->scriptBlock($script, array('inline' => true));
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
                    <li class="atab1 active"><a href="Javascript:void(0)">&nbsp;<?php echo __('Fiche client') ?></a></li>
                </ul>
                
                <div class="tab_container">
                    
                    <div class="btn-group pull-top-right btn-square">
                        <!--
                        <a class="btn btn-large" href="javascript:void(0)" id="DeleteSel" title="<?php echo __('Supprimer la sélection'); ?>">
                            <i class="icon-cut"></i>&nbsp;&nbsp;<?php echo __('supprimer'); ?>
                        </a>
                        -->
                        <a class="btn btn-large" href="<?php echo $this->Html->url(array('action' => 'index')) ?>" id="loadForm" title="<?php echo __('Gérer les clients'); ?>">
                            <i class="icon-home"></i>&nbsp;&nbsp;<?php echo __('retour'); ?>
                        </a>
                    </div>
                    
                    <div class="boxtitle" style="font-size: 16px; color: #900; font-weight: bold">
                        <i class="icon-folder-open"></i><?php echo __('%s', $this->request->data['Client']['name']); ?>
                    </div>
                    
                    <div class="row-fluid">
                        <div class="span9 clearfix">
                           <div id="getcontent"></div>
                        </div>
                        
                        <div class="span3 clearfix">                     
                            <div>
                                <div class="ui-accordion ui-widget ui-helper-reset ui-accordion-icons">
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <a href="javascript:void(0)" id="info">Informations</a>
                                    </h4>
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <a href="javascript:void(0)" id="addrfact">Adresses de facturation</a>
                                    </h4>
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <a href="javascript:void(0)" id="sitgeo">Situations géographiques</a>
                                    </h4>
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <a href="javascript:void(0)" id="tel">Téléphones</a>
                                    </h4>
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <a href="javascript:void(0)" id="cel">Cellulaires</a>
                                    </h4>
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <a href="javascript:void(0)" id="fax">Fax</a>
                                    </h4>
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <a href="javascript:void(0)" id="email">E-mails</a>
                                    </h4>
                                    
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <a href="javascript:void(0)" id="contacts">
                                        Contacts associés
                                        </a>
                                    </h4>
                                    
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <a href="javascript:void(0)" id="clientsproduits">Pack produit</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
            
                    </div>

                </div>
            </div><!-- end uitab-->
        </div><!--  end widget-content -->
        
    </div><!-- widget  span12 clearfix-->
</div><!-- row-fluid -->

<?php
echo $this->element('footer');
echo $this->Js->writeBuffer();
?>