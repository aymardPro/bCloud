<?php
$script = '
    $(document).ready(
    	function()
	    {
			$("form#UserEditForm").validationEngine();
			$("select").selectBox();
			$(".chief_checkbox").iphoneStyle({  //  Custom Label 
				  checkedLabel: "Oui",
				  uncheckedLabel: "Non",
				  labelWidth:"35px"
			});
			$(".admin_checkbox").iphoneStyle({  //  Custom Label 
				  checkedLabel: "Oui",
				  uncheckedLabel: "Non",
				  labelWidth:"35px"
			});
			$("form#UserEditForm").on(
	        	"submit",
	        	function()
	        	{
	        		loading("Loading");
					$("button[type=submit]").attr("disabled", "disabled").html("Mise à jour en cours");
					
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
							$("button[type=submit]").removeAttr("disabled").html("Mettre à jour");
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
											"'.$this->Html->url(array('action' => 'getprofil', $this->request->data['User']['id'])).'",
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
								$("button[type=submit]").removeAttr("disabled").html("Mettre à jour");
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
';
echo $this->Html->scriptBlock($script, array('inline' => true));
?>

<div class="btn-group pull-top-right btn-square">
	<a class="btn btn-large" href="javascript:void(0)" id="back"><i class="icon-share-alt"></i> <?php echo __('Retour') ?> </a>
</div>

<div class="formEl_b">
	<?php echo $this->Form->create('User', array('inputDefaults' => array('div' => false, 'label' => false))); ?>
		<fieldset>
			<legend> <?php echo __('Mettre à jour un profil') ?> </legend>
			
			<div class="section">
				 <label for="UserAccountId"> <?php echo __('Compte') ?> <small><?php echo __('Choisir parmi la liste') ?></small></label>
				 <div>
				 	<?php echo $this->Form->input('account_id', array('class' => 'large')); ?>
				 	<span class="f_help"><?php echo __('Obligatoire') ?></span>
				 </div>
			</div>
			
			<div class="section">
				 <label for="UserGroupId"> <?php echo __('Groupe') ?> <small><?php echo __('Choisir parmi la liste') ?></small></label>
				 <div>
				 	<?php echo $this->Form->input('group_id', array('class' => 'large')); ?>
				 	<span class="f_help"><?php echo __('Obligatoire') ?></span>
				 </div>
			</div>
			
			<div class="section">
				 <label for="UserFullname"> <?php echo __('Nom & prénoms') ?> <small><?php echo __('Entrez le nom & prénoms') ?></small></label>
				 <div>
				 	<?php echo $this->Form->input('fullname', array('class' => 'validate[required] large', 'readonly')); ?>
				 	<span class="f_help"></span>
				 </div>
			</div>
			
			<div class="section">
				 <label> <?php echo __('Login') ?> <small><?php echo __('Compte d\'accès') ?></small></label>
				 <div>
				 	<?php echo $this->Form->input('email', array('class' => 'validate[required,custom[email],minSize[8],maxSize[155]] large', 'readonly')); ?>
				 	<label for="UserEmail"><?php echo __('Email') ?></label>
				 	<span class="f_help"></span>
				 </div>
			</div>
			
			<div class="section">
				<label> <?php echo __('Responsable?') ?> <small> <?php echo __('Indiquez si l\'utilisateur doit être le responsable de son groupe') ?> </small></label>
				<div>
					<?php echo $this->Form->input('chief', array('type' => 'checkbox', 'class' => 'chief_checkbox')); ?>
					<span class="f_help"> &nbsp; </span>
				</div>
			</div>
			
			<div class="section">
				<label> <?php echo __('Administrateur?') ?> <small> <?php echo __('Indiquez si l\'utilisateur doit pouvoir administrer le logiciel') ?> </small></label>
				<div>
					<?php echo $this->Form->input('admin', array('type' => 'checkbox', 'class' => 'admin_checkbox')); ?>
					<span class="f_help"> &nbsp; </span>
				</div>
			</div>
			
			<div class="section last">
				<div>
					<a class="btn submit_form"> <?php echo __('Mettre à jour') ?> </a>
				</div>
			</div>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>