<?php
$script = '
    $(document).ready(
    	function()
	    {
			$("#back").on("click", backToContent);
			$("form#TaxAddForm").validationEngine();
			$("select").selectBox();
			
			$("form#TaxAddForm").on(
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
											"'.$this->Html->url(array('action' => 'get')).'" + "/" + json.type,
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
	<a class="btn btn-large" href="javascript:void(0)" id="back"><i class="icon-remove"></i></a>
</div>

<h2>Formulaire</h2>
<hr />

<div class="formEl_b">
	<?php echo $this->Form->create('Tax', array('inputDefaults' => array('div' => false, 'label' => false))); ?>
			
			<div class="section">
				 <label for="TaxName"> <?php echo __('Nom') ?> <small><?php echo __('Entrez le nom de la taxe') ?></small></label>
				 <div>
				 	<?php echo $this->Form->input('name', array('class' => 'large')); ?>
				 	<span class="f_help"><?php echo __('Obligatoire') ?></span>
				 </div>
			</div>
			
			<div class="section">
				 <label for="TaxTau"> <?php echo __('Valeur') ?> <small><?php echo __('Tau de la taxe') ?></small></label>
				 <div>
				 	<?php echo $this->Form->input('tau', array('class' => 'small center')); ?>
				 	<span class="f_help"></span>
				 </div>
			</div>
			
			<div class="section last">
				<div>
					<a class="btn submit_form"> <?php echo __('Créer') ?> </a>
				</div>
			</div>

	<?php echo $this->Form->end(); ?>
</div>