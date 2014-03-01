<?php
$script = '
    $(document).ready(
        function()
        {
			$("#article_id").change(function() {
				var HIDDEN = $(this).val();
				$("#hidden_article_id").attr("value", HIDDEN);
			});
			
			$("#FactureRemise").mask("99%",{completed:function(){ Processgraph(); }});
			$("#article_id").chosen();
			$("#qte").spinner({min: 1, stepping: 1, decimals:0});
			
			$("#set_form").click(function(e) {
			    loading("Loading");
				$("#set_form").attr("disabled", "disabled").html("Ajout en cours");
				
				var Request = $.ajax(
					{
						url: "'.$this->Html->url(array('action' => 'setarticle')).'",
						data: { article_id: $("#hidden_article_id").val(), qte: $("#qte").val(), status: $("#status").val() },
						cache: false,
						type: "POST",
						dataType: "json"
					}
				);
                    
                Request.done(function(json, status, jqXHR)
                   	{
                   	    unloading();
                		$("#set_form").removeAttr("disabled").html("Ajouter");
						
                   		if (json.check > 0) {
                   			alertMessage("warning", json.response);
                   		} else {
							$("#getArticle").load("'.$this->Html->url(array('action' => 'getarticle')).'");
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
					
            $("#back").on("click", backToContent);
            $("form#FactureAddForm").validationEngine();
            $("select").chosen();
            $("#FactureDate").mask("9999-99-99 99:99").datetimepicker({
                dateFormat:"yy-mm-dd"
            });
			 $("#wizardvalidate").smartWizard(
			 	{
			 		transitionEffect:"slideleft",
			 		onLeaveStep:leaveAStepCallback,
			 		onFinish:onFinishCallback,
			 		enableFinishButton:true,
			 		labelNext: "Etape suivante",
			 		labelPrevious: "Etape précédente",
			 		labelFinish: "Valider et créer la facture"
				}
			);
           
            
              function leaveAStepCallback(obj) {
					var step_num= obj.attr("rel");
					return validateSteps(step_num);
              }
              
              function onFinishCallback() {
				   if (validateAllSteps()) {
						 $("form#FactureAddForm").submit();
				   }
              }
               
            $("#FactureArticlePrixVente").spinner({min: 0, max:99999999, decimals:0});
         
            $("form#FactureAddForm").on(
                "submit",
                function()
                {
                    loading("Loading");
                    $(".buttonFinish").attr("disabled", "disabled").html("Création en cours");
                    
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
                            $(".buttonFinish").removeAttr("disabled").html("Valider et créer la facture");
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
                                            "'.$this->Html->url(array('action' => 'get')).'"+"/"+json.statut,
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
                                $(".buttonFinish").removeAttr("disabled").html("Valider et créer la facture");
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
        
        function Processgraph()
        {
        	var bar = $(".bar");
			var bw = bar.width();
			var percent = bar.find(".percent");
			var circle = bar.find(".circle");
			var ps =  percent.find("span");
			var cs = circle.find("span");
			var name = "rotate";
			var t = $("#FactureRemise");
			var val = t.val();
			
			if (val) { 
				val = t.val().replace("%", "");
				
				if (val >=0 && val <= 100){
					var w = 100-val;
					var pw = (bw*w)/100;
					var pa = { width: w+"%" };
					var cw = (bw-pw);
					var ca = { "left": cw };
					
					ps.animate(pa);
					cs.text(val+"%");
					circle.animate(ca, function(){ circle.removeClass(name) }).addClass(name);	
				} else {
					alert("range: 0 - 100");
					t.val("");
				}
			}
		}
    
    function getArticle()
    {
        $("#getArticle").load("'.$this->Html->url(array("action" => "getarticle")).'").fadeIn(400);
    }
    
    function backToContent()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
            "'.$this->Html->url(array("action" => "get", $this->request->params['pass'][0])).'",
            function() { unloading(); }
        ).fadeIn(400);
    }
    
    function validateAllSteps()
    {
    	var isStepValid = true;
    	
    	if (validateStep1() == false) {
    		isStepValid = false;
    		$("#wizardvalidate").smartWizard("setError",{stepnum:1,iserror:true});
		} else {
			$("#wizardvalidate").smartWizard("setError",{stepnum:1,iserror:false});
		}
		
		// add more if you want to validateStep 2
		if (validateStep2() == false) {
			isStepValid = false;
			$("#wizardvalidate").smartWizard("setError",{stepnum:3,iserror:true});
		} else {
			$("#wizardvalidate").smartWizard("setError",{stepnum:3,iserror:false});
		}
		
		if (validateStep3() == false) {
			isStepValid = false;
			$("#wizardvalidate").smartWizard("setError",{stepnum:3,iserror:true});
		} else {
			$("#wizardvalidate").smartWizard("setError",{stepnum:3,iserror:false});
		}
		
		if(!isStepValid){
			$("#wizardvalidate").smartWizard("showMessage","Renseignez les champs requis avant de poursuivre.");
		}
		
		return isStepValid;
	}
	
	function validateSteps(step)
	{
		var isStepValid = true;
		
		// validate step 1
		if (step == 1) {
			if (validateStep1() == false ) {
				isStepValid = false;
				$("#wizardvalidate").smartWizard("showMessage","Renseignez les champs requis à l\'étape "+step+ " et allez à l\'étape suivante.");
				$("#wizardvalidate").smartWizard("setError",{stepnum:step,iserror:true});
			} else {
				$("#wizardvalidate").smartWizard("setError",{stepnum:step,iserror:false});
			}
		}
		
		// validate step 2
		if (step == 2) {
			if(validateStep2() == false ) {
				isStepValid = false;
				$("#wizardvalidate").smartWizard("showMessage","Renseignez les champs requis à l\'étape "+step+ " et allez à l\'étape suivante.");
				$("#wizardvalidate").smartWizard("setError",{stepnum:step,iserror:true});
			} else {
				getArticle();
				$("#wizardvalidate").smartWizard("setError",{stepnum:step,iserror:false});
			}
		}
		
		// validate step3
		if (step == 3) {
			
			if (validateStep3() == false ) {
				isStepValid = false;
				$("#wizardvalidate").smartWizard("showMessage","Renseignez les champs requis à l\'étape "+step+ " et allez à l\'étape suivante.");
				$("#wizardvalidate").smartWizard("setError",{stepnum:step,iserror:true});
			} else {
				$("#wizardvalidate").smartWizard("setError",{stepnum:step,iserror:false});
			}
		}
		
		return isStepValid;
	}
	
	function validateStep1()
	{
		var isValid = false;
		
		if ($("#FactureClientId").val() > 0) {
			isValid = true;
		}
		return isValid;
	}
	
	function validateStep2()
	{
		var isValid = false;
		
		if (($("#FactureDate").val() != "") && ($("#FactureName").val() != "")) {
			isValid = true;
		}
		return isValid;
	}
	
	function validateStep3()
	{
		var isValid = true;
		return isValid;
	}
';
echo $this->Html->scriptBlock($script, array('inline' => true));
?>

<div>
    <h2><?php echo __('FORMULAIRE'); ?></h2>
</div>
<hr />

<div class="btn-group pull-top-right btn-square">
    <a class="btn btn-large" href="javascript:void(0)" id="back"><i class="icon-share-alt"></i></a>
</div>

<?php echo $this->Form->create('Facture', array('inputDefaults' => array('div' => false, 'label' => false))); ?>

	<input type="hidden" name="issubmit" value="1">
	
	<!-- Smart Wizard -->
	<div id="wizardvalidate" class="swMain">
		<ul>
			<li>
				<a href="#step-1">
					<label class="stepNumber">1</label>
					<span class="stepDesc">
						Client <br />
						<small>informations Client</small>
					</span>
				</a>
			</li>
			<li>
				<a href="#step-2">
					<label class="stepNumber">2</label>
					<span class="stepDesc">
						Facture <br />
						<small>informations Facture</small>
					</span>
				</a>
			</li>
			<li>
				<a href="#step-3">
					<label class="stepNumber">3</label>
					<span class="stepDesc">
						Articles <br />
						<small>Choix Articles</small>
					</span>
				</a>
			</li>
			<li>
				<a href="#step-4">
					<label class="stepNumber">4</label>
					<span class="stepDesc">
						Autres <br />
						<small>Compléments</small>
					</span>
				</a>
			</li>
		</ul>
		
		<div id="step-1" style="width:100%; height: auto">
			<h2 class="StepTitle">&Eacute;tape 1: Informations Client</h2>
			
			<div class="section">
				<label for="FactureClientId"> <?php echo __('Client') ?> <small><?php echo __('Selectionner le client') ?></small></label>
				<div>
					<?php echo $this->Form->input('client_id', array('class' => 'medium', 'empty' => '')); ?>
					<?php echo $this->Form->input('status', array('id' => 'status', 'type' => 'hidden', 'value' => $this->request->params['pass'][0])); ?>
					<span class="f_help"><?php echo __('Obligatoire') ?></span>
				</div>
			</div>
		</div>
		
		<div id="step-2" style="width:100%; height: auto">
			<h2 class="StepTitle">&Eacute;tape 2: Informations Facture</h2>
			
			<div class="section">
				<label for="FactureDate"> <?php echo __('Date') ?> <small><?php echo __('Date de création') ?></small></label>
				<div>
					<?php echo $this->Form->input('date', array('class' => 'small center', 'type' => 'text')); ?>
				</div>
			</div>
			
			<div class="section">
				<label for="FactureName"> <?php echo __('Objet') ?> <small><?php echo __('Objet de la facture') ?></small></label>
				<div>
					<?php echo $this->Form->input('name', array('class' => 'upper large')); ?>
				</div>
			</div>
		</div>
		
		<div id="step-3" style="width:100%; height: auto;">
			<h2 class="StepTitle">&Eacute;tape 3: Choix Articles</h2>
			<div class="section last">
				 <label> <?php echo __('Choix articles') ?> </label>
				 
				 <div class="row">
				 	<div class="span6">
						<div>
						 	<?php echo $this->Form->input('article_id', array('class' => 'large', 'empty' => '', 'id' => 'article_id')); ?>
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
							<button id="set_form" class="btn">Ajouter</button>
						</div>
					</div>
				 </div>
			</div>
			
			<div id="getArticle"></div>
		</div>
		
		<div id="step-4" style="width:100%; height: auto">
			<h2 class="StepTitle">&Eacute;tape 4: Other Details</h2>
			
			<div class="section">
			    <label for="FactureGarantie"> <?php echo __('Garantie') ?> <small></small></label>
			    <div>
			        <?php echo $this->Form->input('garantie', array('class' => 'medium')); ?>
			        <span class="f_help"> <?php echo __('Garantie de votre offre') ?> </span>
			    </div>
			</div>
			
			<div class="section">
			    <label for="FactureValidite"> <?php echo __('Validité') ?> <small></small></label>
			    <div>
			        <?php echo $this->Form->input('validite', array('class' => 'medium')); ?>
			        <span class="f_help"> <?php echo __('Délai de validité de votre offre') ?> </span>
			    </div>
			</div>
			
			<div class="section">
			    <label for="FactureTaxId"> <?php echo __('Taxe') ?> <small></small></label>
			    <div>
			        <?php echo $this->Form->input('tax_id', array('class' => 'validate[required] medium')); ?>
			        <span class="f_help"> <?php echo __('Taxe à appliquer à la facture') ?> </span>
			    </div>
			</div>
			
			<div class="section">
			    <label for="FacturePaiementId"> <?php echo __('Paiement') ?> <small></small></label>
			    <div>
			        <?php echo $this->Form->input('paiement_id', array('class' => 'validate[required] medium')); ?>
			        <span class="f_help"> <?php echo __('Mode de paiement') ?> </span>
			    </div>
			</div>
			
			<div class="section last">
			    <label for="FactureRemise"> <?php echo __('Remise') ?> <small></small></label>
			    <div>
			        <?php echo $this->Form->input('remise', array('type' => 'text', 'class' => 'small center')); ?>
			        <span class="f_help"> <?php echo __('Remise appliquée sur le montant total') ?> </span>
			        <div class="bar clearfix">
			            <div class="percent"><span style="width: 100%;"></span></div>
			            <div class="circle"><span>0%</span></div>
			        </div>
			    </div>
			</div>
        </div>
    </div>
</div><!-- End SmartWizard Content -->
<?php echo $this->Form->end(); ?>

<div class="clearfix"></div>