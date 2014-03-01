<?php
$script = "
    $(document).ready (
        function()
        {
            $('#info').on('click', getEditContent);
            $('#addrfact').on('click', addrfact);
            $('#sitgeo').on('click', sitgeo);
            $('#tel').on('click', tel);
            $('#cel').on('click', cel);
            $('#fax').on('click', fax);
            $('#email').on('click', email);
        }
    );
    
    function addrfact(){
         alertHide();
        loading('Loading');
        $('#getter').load('".$this->Html->url(array (
            'controller' => 'client_datas',
            'action' => 'get', $client['Client']['id'], 69
        ))."', function(){unloading();}).fadeIn(400);
    }
    
    function sitgeo(){
         alertHide();
        loading('Loading');
        $('#getter').load('".$this->Html->url(array (
            'controller' => 'client_datas',
            'action' => 'get', $client['Client']['id'], 70
        ))."', function(){unloading();}).fadeIn(400);
    }
    
    function tel(){
         alertHide();
        loading('Loading');
        $('#getter').load('".$this->Html->url(array (
            'controller' => 'client_datas',
            'action' => 'get', $client['Client']['id'], 71
        ))."', function(){unloading();}).fadeIn(400);
    }
    
    function cel(){
         alertHide();
        loading('Loading');
        $('#getter').load('".$this->Html->url(array (
            'controller' => 'client_datas',
            'action' => 'get', $client['Client']['id'], 72
        ))."', function(){unloading();}).fadeIn(400);
    }
    
    function fax(){
         alertHide();
        loading('Loading');
        $('#getter').load('".$this->Html->url(array (
            'controller' => 'client_datas',
            'action' => 'get', $client['Client']['id'], 73
        ))."', function(){unloading();}).fadeIn(400);
    }
    
    function email(){
         alertHide();
        loading('Loading');
        $('#getter').load('".$this->Html->url(array (
            'controller' => 'client_datas',
            'action' => 'get', $client['Client']['id'], 74
        ))."', function(){unloading();}).fadeIn(400);
    }
";
echo $this->Html->scriptBlock($script, array('inline' => true));
?>

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
                                </div>
                            </div>
                        </div>