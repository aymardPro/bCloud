<?php
$script = '
    $(document).ready(
    	function()
	    {
			$("#back").on("click", backToContent);
			$("form#AccountAddForm").validationEngine();
			
			$("form#AccountAddForm").on(
	        	"submit",
	        	function()
	        	{
	        		loading("Loading");
					$("a.submit_form").attr("disabled", "disabled").html("Création en cours");
					
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
							$("a.submit_form").removeAttr("disabled").html("Créer");
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
								$("a.submit_form").removeAttr("disabled").html("Créer");
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

<div class="formEl_b">
	<?php echo $this->Form->create('Account', array('inputDefaults' => array('div' => false, 'label' => false))); ?>
		<fieldset>
			<legend> <?php echo __('Créer un compte') ?> </legend>
			
			<div class="section">
				 <label for="AccountName"> <?php echo __('Nom') ?> <small><?php echo __('Entrez le nom du compte') ?></small></label>
				 <div>
				 	<?php echo $this->Form->input('name', array('class' => 'upper large', 'autocomplete' => "off")); ?>
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