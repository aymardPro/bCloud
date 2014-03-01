<div class="clients form">
<?php
$script = '
    $(document).ready(
    	function()
	    {
			$("#back").on("click", backToContent);
            $("form#ClientAddForm").validationEngine();
            $("select").chosen();
            $("#ClientTel").mask("99-99-99-99");
            $("#ClientCel").mask("99-99-99-99");
            $("#ClientFax").mask("99-99-99-99");
			$(".status_checkbox").iphoneStyle({  //  Custom Label 
				  checkedLabel: "Activé",
				  uncheckedLabel: "Désactivé",
				  labelWidth:"72px"
			});
			$("form#ClientAddForm").on(
	        	"submit",
	        	function()
	        	{
	        		loading("Loading");
					$(".submit_form").attr("disabled", "disabled").html("Création en cours");
					
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
							$(".submit_form").removeAttr("disabled").html("Créer");
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
											"'.$this->Html->url(array('action' => 'get')).'",
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
								$(".submit_form").removeAttr("disabled").html("Créer");
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
        	"'.$this->Html->url(array("action" => "get")).'",
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
	<?php echo $this->Form->create('Client', array('inputDefaults' => array('div' => false, 'label' => false))); ?>
			
			<div class="row-fluid">
                <div class="span8">
                    
                    <div class="section">
                         <label for="ClientClientActivityId">
                             <?php echo __("Secteur d'activité économique") ?> <small><?php echo __('Choisir parmi la liste') ?></small>
                         </label>
                         <div>
                            <?php
                            echo $this->Form->input('economic_activity', array(
                                'class' => 'validate[required] large',
                                'multiple',
                                'name' => 'secteur[]',
                                'options' => Configure::read('RelationManager.ActiviteEconomique')
                            ));
                            ?>
                            <span class="f_help"><?php echo __('Obligatoire') ?></span>
                         </div>
                    </div>
                    
                    <div class="section">
                         <label for="ClientName"> <?php echo __("Identification de l'entreprise") ?> <small></small></label>
                         <div>
                            <?php
                            echo $this->Form->input('forme_juridique', array(
                                'class' => 'large',
                                'options' => Configure::read('RelationManager.FormeJuridique')
                            ));
                            ?>
                         </div>
                         <div>
                            <?php echo $this->Form->input('name', array('class' => 'large', 'placeholder' => 'Dénomination')); ?>
                         </div>
                         <div>
                            <?php echo $this->Form->input('sigle', array('class' => 'large', 'placeholder' => 'Sigle usuel')); ?>
                         </div>
                    </div>
                    
                    <div class="section">
                         <label for="ClientRc">
                             <?php echo __('Régistre de commerce') ?> <small><?php echo __('Entrez le régistre de commerce') ?></small>
                         </label>
                         <div>
                            <?php echo $this->Form->input('rc', array('class' => 'medium center')); ?>
                         </div>
                    </div>
                    
                    <div class="section">
                         <label for="ClientCc">
                             <?php echo __('Compte contribuable') ?> <small><?php echo __('Entrez le compte contribuable') ?></small>
                         </label>
                         <div>
                            <?php echo $this->Form->input('cc', array('class' => 'medium center')); ?>
                         </div>
                    </div>
            
                    <div class="section last">
                        <div>
                            <a class="btn submit_form"> <?php echo __('Créer') ?> </a>
                        </div>
                    </div>
                    
                </div>
                <div class="span4">
                    <div>
                        <?php echo $this->Form->input('tel', array('class' => 'large center', 'placeholder' => 'Téléphone bureau', 'type' => 'text')); ?>
                    </div>
                    <div>
                        <?php echo $this->Form->input('cel', array('class' => 'large center', 'placeholder' => 'Téléphone portable')); ?>
                    </div>
                    <div>
                        <?php echo $this->Form->input('fax', array('class' => 'large center', 'placeholder' => 'Télécopie')); ?>
                    </div>
                    <hr />
                    
                    <div>
                        <?php echo $this->Form->input('email', array('class' => 'large', 'placeholder' => 'E-mail')); ?>
                    </div>
                    <hr />
                    
                    <div>
                        <?php echo $this->Form->input('adresse', array('class' => 'large', 'placeholder' => 'Adresse')); ?>
                    </div>
                </div>
			</div>
			
	<?php echo $this->Form->end(); ?>
</div>