<?php

$script = '
    $(document).ready(
    	function()
	    {
			$("#back").on("click", backToContent);
			$("form#MouvementAddForm").validationEngine();
			$("#qte").spinner({min: 1, decimals:0});
			$("select").chosen();
			$("#MouvementDate").mask("9999-99-99").datepicker({
				dateFormat:"yy-mm-dd"
			});
            
            $("#set_form").click(function() {
                loading("Loading");
                $("#set_form").attr("disabled", "disabled").html("Ajout en cours");
                
                var Request = $.ajax(
                    {
                        url: "'.$this->Html->url(array('action' => 'setarticle')).'",
                        data:
                        {
                            type_id: "'.$this->request->params['pass'][0].'",
                            depot_id: $("#MouvementDepotDepart").val(),
                            article_id: $("#article_id").val(),
                            qte: $("#qte").val()
                        },
                        cache: false,
                        type: "POST",
                        dataType: "json"
                    }
                );
                    
                Request.done(function(json, status, jqXHR)
                    {
                        if (json.check > 0) {
                        	unloading();
                            alertMessage("warning", json.response);
							$("#set_form").removeAttr("disabled").html("Ajouter");
                        } else {
                            $("#getStockArticle").load("'.$this->Html->url(array('action' => 'getstockarticle')).'",function(){
                            	unloading();
								$("#set_form").removeAttr("disabled").html("Ajouter");
							});
                            $("#qte").attr("value", 1);
                        }
                    }
                );
                        
                Request.fail(function(jqXHR, textStatus, errorThrown)
                    {
                        unloading();
                        $("#set_form").removeAttr("disabled").html("Ajouter");
                        alertMessage("error", "Error.");
                        return false;
                    }
                );
            });
			
			$(".status_checkbox").iphoneStyle({  //  Custom Label 
				  checkedLabel: "Activé",
				  uncheckedLabel: "Désactivé",
				  labelWidth:"72px"
			});
			$("form#MouvementAddForm").on(
	        	"submit",
	        	function()
	        	{
	        		loading("Loading");
					$("button[type=submit]").attr("disabled", "disabled").html("Création en cours");
					
	        		var Request = $.ajax(
						{
							url: $(this).attr("action"),
							type: $(this).attr("method"),
							data: $(this).serialize(),
							cache: false,
							dataType: "json"
						}
					);
					
					Request.fail(
			           	function(jqXHR, textStatus, errorThrown)
			           	{
				           	unloading();
							$("button[type=submit]").removeAttr("disabled").html("Créer");
							alertMessage("error", "Join your web admin to resolve it.");
							return false;
						}
					);
					
					Request.done(
			           	function(json, status, jqXHR)
			           	{
			           		if (json.check == 0)
							{
								$("#getcontent").fadeIn(
									400,
									function()
									{
										$("#getcontent").load(
											"'.$this->Html->url(array('action' => 'get')).'"+"/"+json.type,
											function()
											{
												$.fancybox.close();
												alertMessage("success", json.response);
												unloading();
											}
										);
									}
								);
							} else {
								unloading();
								$("button[type=submit]").removeAttr("disabled").html("Créer");
								alertMessage("warning", json.response);
								return false;
							}
						}
					);
					return false;
				}
			);
	    }
    );
	
	function backToContent()
	{
		alertHide();
    	loading("Loading");
        $("#getcontent").load(
        	"'.$this->Html->url(array("action" => "get", $this->request->params['pass'][0])).'",
            function() { unloading(); }
		).fadeIn(400);
	}
';
echo $this->Html->scriptBlock($script, array('inline' => true));
?>

<div class="btn-group pull-top-right btn-square">
	<a class="btn btn-large" href="javascript:void(0)" id="back"><i class="icon-remove"></i></a>
</div>

<h2>Formulaire</h2>
<hr />

<div class="formEl_b">
	<?php echo $this->Form->create('Mouvement', array('inputDefaults' => array('div' => false, 'label' => false))); ?>
			
			<div class="section">
				 <label for="MouvementDepotId">
				     <?php echo __('Dépôt') ?> <small><?php echo __('Choisir parmi la liste') ?></small>
				 </label>
				 
				 <div class="row">
					 <div class="span6">
                         <div>
                            <?php
                            echo $this->Form->input('depot_depart', array(
                                'class' => 'large',
                                'options' => $depots,
                            ));
                            ?>
                            <span class="f_help"> <?php echo __("Dépôt de départ") ?> </span>
                         </div>
                         
                         <?php if ($this->request->params['pass'][0] > 1) { ?>
                         <br />
                         <div>
                            <?php
                            echo $this->Form->input('depot_arrivee', array(
                                'class' => 'large',
                                'options' => $depots,
                            ));
                            ?>
                            <span class="f_help"> <?php echo __("Dépôt d'arrivée") ?> </span>
                         </div>
                         <?php } ?>
					 </div>
					 
					 <div class="span6">
						 <div>
						 	<?php echo $this->Form->input('date', array('class' => 'large center', 'type' => 'text')); ?>
						 	<span class="f_help"> <?php echo __('Date du mouvement') ?> </span>
						 </div>
					 </div>
				 </div>
			</div>
            
            <div class="section">
                 <label for="MouvementName"> <?php echo __('Intitlué') ?> <small><?php echo __('') ?></small></label>
                 <div>
                    <?php echo $this->Form->input('name', array('class' => 'large upper')); ?>
                 </div>
            </div>
			
			<div class="section">
                 <label> <?php echo __('Choix articles') ?> </label>
                 
                 <div class="row">
                    <div class="span6">
                        <div>
                            <?php
                            echo $this->Form->input('article_id', array(
                                'class' => 'large',
                                'empty' => '',
                                'id' => 'article_id',
                            ));
                            ?>
                            <input type="hidden" name="hidden_article_id" id="hidden_article_id" value="" />
                        </div>
                    </div>
                    
                    <div class="span3">
                        <div>
                            <?php echo $this->Form->input('qte', array('class' => 'large center', 'id' => 'qte', 'type' => 'text', 'value' => 1)); ?>
                        </div>
                    </div>
                    <div class="span3">
                        <div>
                            <a id="set_form" class="btn">Ajouter</a>
                        </div>
                    </div>
                 </div>
            </div>
            <br />
            
            <div id="getStockArticle"></div>
			
			<!--
			<div class="section">
				 <label> <?php echo __('Choix articles') ?> </label>
				 
				 <?php for ($i=0; $i < 11; $i++) { ?>
				 <div class="row">
				 	<div class="span6">
						<div>
						 	<?php echo $this->Form->input('MouvementArticle.'.$i.'.article_id', array('class' => 'large', 'empty' => '')); ?>
						</div>
				 	</div>
				 	
					<div class="span3">
						<div>
							<?php echo $this->Form->input('MouvementArticle.'.$i.'.qte', array('class' => 'large center', 'type' => 'text', 'value' => 1)); ?>
						</div>
					</div>
					<div class="span3">
						<div>
							<?php echo $this->Form->input('MouvementArticle.'.$i.'.prix_achat', array('class' => 'large center', 'type' => 'text')); ?>
						</div>
					</div>
				 </div>
				 <?php } ?>
			</div>
			-->
			
			<div class="section last">
				<div>
					<a class="btn submit_form"> <?php echo __('Créer') ?> </a>
					<a class="btn" onClick="ResetForm()" title="Reset Form">Clear Form</a>
				</div>
			</div>
			
	<?php echo $this->Form->end(); ?>
</div>