<?php
$script = '
    $(document).ready(
    	function()
	    {
			$("#back").on("click", backToContent);
			$("form#UserAddForm").validationEngine();
			$("select").chosen();
			$(".status_checkbox").iphoneStyle({
			    // Custom Label
			    checkedLabel: "Activé",
			    uncheckedLabel: "Désactivé",
			    labelWidth:"72px"
			});
			$("#UserRandompass").change(function(){
				if ($(this).is(":checked")) {
    				$(".randomstate1").slideUp();
    				$(".randomstate2").slideUp();
  				} else {
    				$(".randomstate1").slideDown();
    				$(".randomstate2").slideDown();
  				}
			});
			$(".chief_checkbox").iphoneStyle({
			    // Custom Label
			    checkedLabel: "Oui",
			    uncheckedLabel: "Non",
			    labelWidth:"35px"
			});
			$(".admin_checkbox").iphoneStyle({
			    // Custom Label
			    checkedLabel: "Oui",
			    uncheckedLabel: "Non",
			    labelWidth:"35px"
			});
			$("form#UserAddForm").on(
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
			           		if (json.check == 0) {
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
<hr />

<div class="formEl_b">
	<?php
	echo $this->Form->create('User', array(
		'inputDefaults' => array('div' => false, 'label' => false),
		'url' => array('action' => 'addRequest')
	));
	?>
			
			<div class="section">
				 <label for="UserAccountId">
				     <?php echo __('Compte') ?>
				     <small><?php echo __('Choisir parmi la liste') ?></small>
				 </label>
				 
				 <div>
				 	<?php echo $this->Form->input('account_id', array('class' => 'large')); ?>
				 </div>
			</div>
			
			<div class="section">
				 <label for="UserGroupId">
				     <?php echo __('Groupe') ?>
				     <small><?php echo __('Choisir parmi la liste') ?></small>
				 </label>
				 
				 <div>
				 	<?php echo $this->Form->input('group_id', array('class' => 'large')); ?>
				 </div>
			</div>
			
			<div class="section">
				 <label for="UserPrenoms">
				     <?php echo __('Nom & prénoms') ?>
				     <small><?php echo __('Entrez le nom & prénoms') ?></small>
				 </label>
				 
                 <div>
                    <?php echo $this->Form->input('prenoms', array('class' => 'large', 'placeholder' => 'Prénom(s)', 'autocomplete' => "off")); ?>
                 </div>
                 <div>
                    <?php echo $this->Form->input('nom', array('class' => 'medium', 'placeholder' => 'Nom', 'autocomplete' => "off")); ?>
                 </div>
			</div>
			
			<div class="section">
				 <label for="UserEmail">
				     <?php echo __('Email') ?>
				     <small><?php echo __("") ?></small>
				 </label>
                 <div>
                    <?php echo $this->Form->input('email', array('class' => 'large', 'placeholder' => "E-mail", 'autocomplete' => "off")); ?>
                 </div>
            </div>
			
			<div class="section">
				 <label for="UserUsername">
				     <?php echo __("Nom d'utilisateur") ?>
				     <small><?php echo __("") ?></small>
				 </label>
                 
                 <div>
                    <?php echo $this->Form->input('username', array('class' => 'large', 'placeholder' => "Nom d'utilisateur", 'autocomplete' => "off")); ?>
                 </div>
             </div>
            
            <div class="section">
				 <label for="UserPassword">
				     <?php echo __('Mot de passe') ?>
				     <small><?php echo __("") ?></small>
				 </label>
				 
				<div>
				 	<?php
				 	echo $this->Form->input(
                        'password',
                        array(
                            'class' => 'medium',
                            'placeholder' => "Mot de passe",
                            'autocomplete' => "off"
                        )
                    );
                    ?>
				</div>
				<div>
				 	<?php
				 	echo $this->Form->input(
                        'password2',
                        array(
                            'class' => 'medium',
                            'type' => 'password',
                            'placeholder' => "Répétez Mot de passe",
                            'autocomplete' => "off"
                        )
                    );
                    ?>
				</div>
			</div>
			
			<div class="section">
				<label for="UserStatus">
					<?php echo __('Statut') ?>
					<small> <?php echo __('Statut du nouveau membre') ?> </small>
				</label>
				
				<div>
					<?php echo $this->Form->input('status', array('type' => 'checkbox', 'class' => 'status_checkbox')); ?>
					<span class="f_help"> <?php echo __('Indiquez si le membre doit être activé') ?> </span>
				</div>
			</div>
			
			<div class="section last">
				<div>
					<a class="btn submit_form"> <?php echo __('Créer') ?> </a>
				</div>
			</div>

	<?php echo $this->Form->end(); ?>
</div>