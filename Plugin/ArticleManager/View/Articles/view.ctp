<?php
$script = '
    $(document).ready(
        function()
        {
            $("#getArticle").on("click", loadcontent);
            $("#updateArticle").on("click", updatearticle);
            $("#Mvts").on("click", loadMvt);
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
            "'.$this->Html->url(array("action" => "getarticle", $this->request->params['pass'][0])).'", function() { unloading(); }
        ).fadeIn(400);
    }
    
    function updatearticle()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
            "'.$this->Html->url(array("action" => "edit", $this->request->params['pass'][0])).'", function() { unloading(); }
        ).fadeIn(400);
    }
    
    function loadMvt()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
            "'.$this->Html->url(array("action" => "mouvements", $this->request->params['pass'][0])).'", function() { unloading(); }
        ).fadeIn(400);
    }
';
echo $this->Html->scriptBlock($script, array('inline' => false));
?>

<div class="row-fluid">
    <!-- Widget -->
    <div class="widget span12 clearfix">
        <div class="widget-header">
            <span><i class="icon-bookmark"></i> <?php echo __('Fiche article'); ?> </span>
        </div><!-- End widget-header -->
        
        <div class="widget-content">
            
            <div class="row-fluid">
                <div class="span3">
                    <div class="profileSetting">
                        <div class="avartar">
                            <?php echo $this->Html->image('/images/icon/coquette-icons-set/128x128/package.png', array('width' => 180)); ?>
                        </div>
                    </div>
                </div>
                
                <div class="span9">
                    <div class="boxtitle min">
                        <h2><?php echo h($this->request->data['Article']['reference']) ?></h2>
                        
                        <p><?php echo h($this->request->data['Article']['designation']); ?></p>
                    </div>
                    
                    <div class="row-fluid">
                        <div class="span4">
                            <div class="section">
                                <label> Centralisateur</label>
                                
                                <div><?php echo h($centralisateurs[$this->request->data['ArticleFamille']['parent']]) ?></div>
                            </div><hr />
                            
                            <div class="section">
                                <label> Prix d'achat</label>
                                
                                <div>
                                    <?php echo __("Prix d'achat: %s", CakeNumber::format($this->request->data['Article']['prix_unitaire'])) ?>
                                </div>
                                <div><?php echo __('Marge: %s', (int) $this->request->data['Article']['marge']).'%' ?></div>
                            </div>
                        </div>
                        
                        <div class="span4">
                            
                            <div class="section">
                                <label> Famille</label>
                                
                                <div><?php echo h($this->request->data['ArticleFamille']['name']) ?></div>
                            </div><hr />
                            
                            <div class="section ">
                                <label> Prix de vente<small></small></label>
                                <div>
                                    <?php
                                    echo CakeNumber::format(
                                        $this->requestAction(
                                            array('action' => 'getPrixVente', $this->request->data['Article']['id'])
                                        )
                                    ); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="span4">
                            <!--
                            <div class="shoutcutBox" style="left: 0px;">
                                        <span class="ico color hand_point"></span>
                                        <strong><?php echo CakeNumber::format("25") ?></strong>
                                        <em>Ventes en cours</em>
                                    </div>
                                    
                                    <div class="shoutcutBox" style="left: 0px;">
                                        <span class="ico color hand_thumbsup"></span>
                                        <strong><?php echo CakeNumber::format("2554") ?></strong>
                                        <em>Ventes accepées</em>
                                    </div>
                                    
                                    <div class="shoutcutBox" style="left: 0px;">
                                        <span class="ico color hand_thumbsdown"></span>
                                        <strong><?php echo CakeNumber::format("552") ?></strong>
                                        <em>Ventes rejetées</em>
                                    </div>
                                    
                                    <div class="clearfix"></div>
                                    
                                </div>
                            -->
                            
                                <div class="ui-accordion ui-widget ui-helper-reset ui-accordion-icons">
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <?php
                                        echo $this->Html->link(
                                            __('Modifier'),
                                            array('action' => 'edit', $this->request->data['Article']['id'])
                                        );
                                        ?>
                                    </h4>
                                </div>
                                <div class="ui-accordion ui-widget ui-helper-reset ui-accordion-icons">
                                    <h4 class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
                                        <span class="ui-icon ui-icon-triangle-1-e"></span>
                                        <?php
                                        echo $this->Html->link(
                                            __('Retour'),
                                            array('action' => 'index')
                                        );
                                        ?>
                                    </h4>
                                </div>                                
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="clearfix"></div>
            </div>
            
            <!-- Table UITab -->
            <!--
            <div id="UITab" style="position:relative; top: 30px">
                <ul class="ajaxtabs">
                    <li class="active tab1"><a href="Javascript::void(0)"> <?php echo __('Liste des mouvements') ?> </a></li>
                    <li class="tab2"><a href="Javascript::void(0)"><?php echo __('Factures') ?></a></li>
                </ul>
                
                <div class="tab_container">
                    <div class="tab_content">
                        <div id="getcontent"></div>
                    </div>
                </div>
            </div>
            -->
            <!-- End UITab -->
            
        </div><!--  end widget-content -->
    </div><!-- widget  span12 clearfix-->
</div><!-- row-fluid -->