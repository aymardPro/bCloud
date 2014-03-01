<?php
$script = '
    $(document).ready(
    	function()
	    {
			$("form#FactureAcompteAcompteAddForm").validationEngine();
            $("#FactureAcompteDate").mask("9999-99-99 99:99").datetimepicker({
                dateFormat:"yy-mm-dd"
            });
            $("#FactureAcompteValue").spinner({min: 0, decimals:0});
            
			$("form#FactureAcompteAcompteAddForm").on(
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
											"'.$this->Html->url(array('action' => 'acomptes', $this->request->params['pass'][0])).'",
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

<h2>Ajouter un acompte</h2>

<div class="formEl_b">
	<?php echo $this->Form->create('FactureAcompte', array('inputDefaults' => array('div' => false, 'label' => false))); ?>
			
            <div class="section">
                 <label for="FactureAcompteDate"> <?php echo __('Date') ?> <small><?php echo __("Date") ?></small></label>
                 <div>
                    <?php echo $this->Form->input('date', array('class' => 'medium center')); ?>
                 </div>
            </div>
            
            <div class="section">
                 <label for="FactureAcompteValue"> <?php echo __('Montant') ?> <small><?php echo __("Montant de l'acompte") ?></small></label>
                 <div>
                    <?php echo $this->Form->input('value', array('class' => 'large')); ?>
                 </div>
            </div>
			
			<div class="section last">
				<div>
					<a class="btn submit_form"> <?php echo __('Créer') ?> </a>
					<a class="btn" onClick="ResetForm()" title="Reset Form">Clear Form</a>
				</div>
			</div>
	<?php echo $this->Form->end(); ?>
</div>