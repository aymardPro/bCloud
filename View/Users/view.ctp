<?php
$script = '
    $(document).ready(
    	function()
	    {
	    	loadProformaW();
            $(".tab1").on("click", loadProformaW);
            $(".tab2").on("click", loadProformaV);
            $(".tab3").on("click", loadProformaR);
	    	$("#updateProfil").on("click", updateprofil);
	    	$(".alertMessage").on("click", hideAlert);
	    }
    );
	
	function hideAlert()
	{
		$(this).stop(true, true).animate({ opacity: 0,right: "-20" }, 500, function() { $(this).hide(); });
	}
    
    function loadProformaW()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
            "'.$this->Html->url(array(
               "plugin" => "facture_manager",
               "controller" => "proformas",
               "action" => "getFromUser",
               Configure::read('bCloud.Proforma.Statut.WAITING'),
               $this->request->data['User']['id']
           )).'", function() { unloading(); }
        ).fadeIn(400);
    }
    
    function loadProformaV()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
            "'.$this->Html->url(array(
               "plugin" => "facture_manager",
               "controller" => "proformas",
               "action" => "getFromUser",
               Configure::read('bCloud.Proforma.Statut.VALIDE'),
               $this->request->data['User']['id']
           )).'", function() { unloading(); }
        ).fadeIn(400);
    }
    
    function loadProformaR()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
            "'.$this->Html->url(array(
               "plugin" => "facture_manager",
               "controller" => "proformas",
               "action" => "getFromUser",
               Configure::read('bCloud.Proforma.Statut.REJETE'),
               $this->request->data['User']['id']
           )).'", function() { unloading(); }
        ).fadeIn(400);
    }
    
    function updateprofil()
    {
    	alertHide();
    	loading("Loading");
        $("#getcontent").load(
        	"'.$this->Html->url(array("action" => "edit", $this->request->data['User']['id'])).'", function() { unloading(); }
		).fadeIn(400);
    }
';
echo $this->Html->scriptBlock($script, array('inline' => false));
?>

<div class="row-fluid">
	<!-- Widget -->
	<div class="widget span12 clearfix">
		<div class="widget-header">
			<span><i class="icon-bookmark"></i> <?php echo __('Profil utilisateur'); ?> </span>
		</div><!-- End widget-header -->
		
		<div class="widget-content">
		    
                        
		    <div class="row-fluid">
		        
                        <div class="span3">
                            <div class="profileSetting">
                                <div class="avartar">
                                    <?php echo $this->Html->image('/images/icon/coquette-icons-set/128x128/image.png', array('width' => 180)); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="span9">
                            <div class="boxtitle min">
                                <h2><?php echo h(__('%s %s', $this->request->data['User']['nom'], $this->request->data['User']['prenoms'])) ?></h2>
                            </div>
                            
                            <div class="row-fluid">
                                
                                <div class="span4">
                                    
                                    <div class="section">
                                        <label> Nom d'utilisateur</label>
                                        
                                        <div>
                                            <?php echo h(__('%s', $this->request->data['User']['email'])) ?>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="section">
                                        <label> Groupe d'utilisateur.</label>
                                        
                                        <div>
                                            <?php echo h(__('%s', $this->request->data['Group']['name'])) ?>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="span4">
                                    
                                    <div class="section ">
                                        <label> Dernière visite<small></small></label>
                                        <div>
                                            <?php
                                            echo (is_null($this->request->data['User']['lastvisite'])) ?
                                                __('Jamais connecté.') : CakeTime::timeAgoInWords($this->request->data['User']['lastvisite']);
                                            ?>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="section ">
                                        <label> Date de création<small></small></label>
                                        <div><?php echo CakeTime::format('d-m-Y H:i', $this->request->data['User']['created']); ?></div>
                                    </div>
                                    
                                </div>
                                
                                <div class="span4">
                                    <h4>Chiffre d'affaire: <?php echo gmdate('M Y') ?></h4>
                                    <div class="shoutcutBox" style="left: 0px;">
                                        <span class="ico color hand_point"></span>
                                        <?php
                                        $n = 0;
                                        foreach ($waiting as $key => $value) {
                                            $n += $this->requestAction(array(
                                                'controller' => 'proformas',
                                                'action' => 'idream_mt_ttc',
                                                $value['Proforma']['id']
                                            ));
                                        }
                                        ?>
                                        <strong><?php echo CakeNumber::format((int) $n) ?></strong>
                                    </div>
                                    
                                    <div class="shoutcutBox" style="left: 0px;">
                                        <span class="ico color hand_thumbsup"></span>
                                        <?php
                                        $n = 0;
                                        foreach ($valide as $key => $value) {
                                            $n += $this->requestAction(array(
                                                'controller' => 'proformas',
                                                'action' => 'idream_mt_ttc',
                                                $value['Proforma']['id']
                                            ));
                                        }
                                        ?>
                                        <strong><?php echo CakeNumber::format((int) $n) ?></strong>
                                        &nbsp;&nbsp;
                                        <span class="ico color arrow_<?php echo ((int) $n > 0) ? 'up2':'down2'; ?>"></span>
                                    </div>
                                    
                                    <div class="shoutcutBox" style="left: 0px;">
                                        <span class="ico color hand_thumbsdown"></span>
                                        <?php
                                        $n = 0;
                                        foreach ($rejete as $key => $value) {
                                            $n += $this->requestAction(array(
                                                'controller' => 'proformas',
                                                'action' => 'idream_mt_ttc',
                                                $value['Proforma']['id']
                                            ));
                                        }
                                        ?>
                                        <strong><?php echo CakeNumber::format((int) $n) ?></strong>
                                    </div>
                                    
                                    <div class="clearfix"></div>
                                    
                                </div>
                                
                                <div class="clearfix"></div>
                                
                            </div>
                            
                            <div class="clearfix"></div>
                            
                        </div>
                        
                        <div class="clearfix"></div>
                
            </div>
            
		    
            <!-- Table UITab -->
            <div id="UITab" style="position:relative;">
                <ul class="ajaxtabs">
                    <li class="active tab1"><a href="Javascript::void(0)"> <?php echo __('En cours') ?> </a></li>
                    <li class="tab2"><a href="Javascript::void(0)"> <?php echo __('Accepté') ?> </a></li>
                    <li class="tab3"><a href="Javascript::void(0)"> <?php echo __('Refusé') ?> </a></li>
                </ul>
                
                <div class="tab_container">
                    <div class="tab_content">
                        <div id="getcontent"></div>
            <br />
                    </div><!--tab1-->
                </div>
            </div>
            <!-- End UITab -->
			
		</div><!--  end widget-content -->
	</div><!-- widget  span12 clearfix-->
</div><!-- row-fluid -->