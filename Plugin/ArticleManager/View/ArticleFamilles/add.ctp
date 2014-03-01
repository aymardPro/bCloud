<?php
$script = '
    $(document).ready(
    	function()
	    {
			$("#back").on("click", backToContent);
			$("form#ArticleFamilleAddForm").validationEngine();
			$("select").chosen();
			
			var TYPE = $("#ArticleFamilleType option:selected").attr("value");
			setType(TYPE);
			
			$("#ArticleFamilleType").change(function(){
				TYPE = $("#ArticleFamilleType option:selected").attr("value");
				setType(TYPE);
			});
			
			$("form#ArticleFamilleAddForm").on(
	        	"submit",
	        	function()
	        	{
	        		alertHide();
	        		loading("Loading");
					$(".submit_form").attr("disabled", "disabled").html("Création en cours <img src=\"./images/loadder/loader_green.gif\" />");
					
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
			           		if (json.check == 0) {
			           			$(".submit_form").html("Opération réussie.");
								
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
								$(".submit_form").removeAttr("disabled").html("Créer");
								
								unloading();
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
	
	function setType(i)
	{
		if (i == 0) {
			//$("#parent").slideUp();
			$("#parent").fadeOut();
		} else {
			//$("#parent").slideDown();
			$("#parent").fadeIn();
		}
	}
	
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

<h2>Formulaire</h2><hr />

<div class="formEl_b">
	<?php echo $this->Form->create('ArticleFamille', array('inputDefaults' => array('div' => false, 'label' => false))); ?>
	
			<div class="section">
				 <label for="ArticleFamilleType"> <?php echo __('Type') ?> <small><?php echo __('Choisir parmi la liste') ?></small></label>
				 <div>
				 	<?php echo $this->Form->input('type', array('class' => 'validate[required] large', 'options' => Configure::read('bCloud.Article.Type'))); ?>
				 	<span class="f_help"><?php echo __('Obligatoire') ?></span>
				 </div>
			</div>
			
			<div class="section" id="parent" style="display: none;">
				 <label for="ArticleFamilleParent"> <?php echo __('Famille parente') ?> <small><?php echo __('Choisir parmi la liste') ?></small></label>
				 <div>
				 	<?php echo $this->Form->input('parent', array('class' => 'validate[required] large', 'options' => $centralisateurs)); ?>
				 	<span class="f_help"><?php echo __('') ?></span>
				 </div>
			</div>
			
			<div class="section">
				 <label for="ArticleFamilleName">
				     <?php echo __('Intitulé') ?> <small><?php echo __('Entrez le nom de la famille') ?></small>
				 </label>
                 <div>
                    <?php echo $this->Form->input('name', array('class' => 'large')); ?>
                    <span class="f_help"><?php echo __('Nom') ?></span>
                 </div>
			</div>
			
			<div class="section last">
				<div>
					<a class="btn submit_form"> <?php echo __('Créer') ?> </a>
				</div>
			</div>
	<?php echo $this->Form->end(); ?>
</div>