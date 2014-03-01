<?php
$script = '
    $(document).ready(
    	function()
	    {
			$("#back").on("click", backToContent);
			$("form#StatutAddForm").validationEngine();
			$("select").selectBox();
			
			$("form#StatutAddForm").on(
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
        	"'.$this->Html->url(array("action" => "get")).'",
            function() { unloading(); }
		).fadeIn(400);
	}
';
echo $this->Html->scriptBlock($script, array('inline' => true));
?>

<div class="btn-group pull-top-right btn-square">
	<a class="btn btn-large" href="javascript:void(0)" id="back"><i class="icon-share-alt"></i> <?php echo __('Retour') ?> </a>
</div>

<div class="formEl_b">
	<?php echo $this->Form->create('Statut', array('inputDefaults' => array('div' => false, 'label' => false))); ?>
		<fieldset>
			<legend> <?php echo __('Créer un statut') ?> </legend>
			
			<div class="section">
				 <label for="StatutName"> <?php echo __('Nom') ?> <small><?php echo __('Entrez le nom du mode') ?></small></label>
				 <div>
				 	<?php echo $this->Form->input('name', array('class' => 'validate[required] large')); ?>
				 	<?php echo $this->Form->input('account_id', array('type' => 'hidden', 'value' => AuthComponent::user('account_id'))); ?>
				 	<span class="f_help"><?php echo __('Obligatoire') ?></span>
				 </div>
			</div>
			
			<div class="section last">
				<div>
					<a class="btn submit_form"> <?php echo __('Créer') ?> </a>
					<a class="btn" onClick="ResetForm()" title="Reset Form">Clear Form</a>
				</div>
			</div>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>