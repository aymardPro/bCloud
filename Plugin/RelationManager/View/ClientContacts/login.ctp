<?php
    $js = 
    "
        $(document).ready
        (
        	function()
	        {
	        	$('#UserLoginForm').on
	        	(
	        		'submit',
	        		function()
	        		{
						$('#but_login').attr('disabled', 'disabled').html('Vérification en cours');
						
	        			var Request = $.ajax
						(
							{
				                url: $(this).attr('action'),
				                type: $(this).attr('method'),
				                data: $(this).serialize(),
				                cache: false,
				                dataType: 'json'
				            }
						);
						
						Request.fail
			            (
			            	function(jqXHR, textStatus, errorThrown)
			            	{
								$('#but_login').removeAttr('disabled').html('Connexion');
								alertMessage('error', 'Error. Join your web admin to resolve it.');
								return false;
							}
						);
			            
			            Request.done
			            (
			            	function(json, status, jqXHR)
			            	{
			            		if (json.check == 1)
								{
									alertHide();									
									$('#login').animate({opacity: 1,top: '49%'}, 200, function()
									{
			   							$('.userbox').show().animate({opacity: 1}, 500);
										$('#login').animate({opacity: 0,top: '60%'}, 500, function()
										{
											$(this).fadeOut(200,function()
											{
												$('.text_success').slideDown();
												$('#successLogin').animate({opacity: 1,height: '200px'}, 500);   			     
											});							  
				 						});
		   							});
		  							setTimeout('window.location.href=\"'+json.url+'\"', 3000);									
								}
								else
								{
									$('#but_login').html('Connexion refusée');
									alertMessage('warning', json.response);
									setTimeout(messageFailedRequest, 5000);
									return false;
								}
							}
						);
						return false;
					}
				);
        	}
		);
		
		function messageFailedRequest()
		{
			$('#but_login').removeAttr('disabled').html('Connexion');
		}
		
		// Unloading
		function unloading()
		{
			$('#preloader').fadeOut(400,function(){ $('#overlay').fadeOut(); $.fancybox.close(); }).remove();
		}
	  
        // Unload 
        function unload()
        {
            $('#preloader').fadeOut
            (
            	400,
            	function()
            	{
            		$('#overlay').fadeOut();
				}
			).remove();
        }
    ";
	echo $this->Html->scriptBlock($js, array('inline' => false));
?>

<div id="login">
	<!--<div class="ribbon"></div>-->
	<div class="inner clearfix">
		<div class="logo">
			<?php echo $this->Html->image('/images/logo/logo_login.png') ?>
		</div>
		<div class="formLogin">
			<?php echo $this->Form->create('User', array('inputDefaults' => array('label' => false, 'div' => false))); ?>
                <div class="tip">
                	<?php echo $this->Form->input('email', array('title' => 'E-mail', 'autocomplete' => 'off')); ?>
                </div>
                
                <div class="tip">
                	<?php echo $this->Form->input('password', array('title' => 'Mot de passe')); ?>
                </div>
                
                <div class="loginButton">
                	<div style="float:left; margin-left:-9px;">
                		<?php
                		echo $this->Form->input('remember', array('type' => 'checkbox', 'id' => 'on_off', 'class' => 'on_off_checkbox', 'value' => 1));
                		?>
                		<span class="f_help">Conserver ma session</span>
                	</div>
                	
                	<div class="pull-right" style="margin-right:-8px;">
                		<div class="btn-group">
                			<button type="button" class="btn" id="forgetpass">Oublié?</button>
                			<button type="submit" class="btn" id="but_login">Connexion</button>
                		</div>
                		<!--<span class="f_help">or <a href="#" id="createacc">Create Account</a></span>-->
                	</div>
                	<div class="clear"></div>
                </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
 	<div class="shadow"></div>
</div>