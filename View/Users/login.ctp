<?php
	$script = "
		$(document).ready(function() 
			{
				if ($('#authMessage').hasClass('message')) {
	                $('#authMessage').attr('class', 'alertMessage info');
	                $('#authMessage').attr('id', 'alertMessage');
	                
	                var string = $('.alertMessage').html();
	                alertMessage('info', string);
	            }
				
				// Hide All  Alert Message Before
				$('.alertMessage').live('click',function()
					{
						alertHide();
					}
				);
				
				// Tooltip
				$('.tip input').tipsy({gravity: 'w', live: true});
				
				// Loading Login Animation
				$('#login').show().animate({opacity: 1}, 2000);
				$('.logo').show().animate({opacity: 1,top: '32%'}, 800,function(){
					$('.logo').show().delay(1200).animate({opacity: 1,top: '1%' }, 300,function(){
						$('.formLogin').animate({opacity: 1,left: '0' }, 300);
						$('.userbox').animate({opacity: 0}, 200).hide();
					});
				});
				
				// Login Click
				$('#but_login').click(function(e){
					var Email = $('#UserEmail').val();
					var Password = $('#UserPassword').val();
					
					if ((Email=='') && (Password=='')) {
						alertMessage('info','Email / Mot de passe requis');
						$('.inner').jrumble({ x: 4,y: 0,rotation: 0 });	
						$('.inner').trigger('startRumble');
						setTimeout('$(\'.inner\').trigger(\'stopRumble\')',500);
						return false;
					} else if ((Email=='') && (Password!='')) {
						alertMessage('info','Email requis');
						$('.inner').jrumble({ x: 4,y: 0,rotation: 0 });	
						$('.inner').trigger('startRumble');
						setTimeout('$(\'.inner\').trigger(\'stopRumble\')',500);
						return false;
					} else if ((Email!='') && (Password=='')) {
						alertMessage('info','Mot de passe requis');
						$('.inner').jrumble({ x: 4,y: 0,rotation: 0 });	
						$('.inner').trigger('startRumble');
						setTimeout('$(\'.inner\').trigger(\'stopRumble\')',500);
						return false;
					} else {
						$('#but_login').attr('disabled', 'disabled').html('Vérification en cours');
						var Request = $.ajax(
							{
								url: $(this).parents('form').attr('action'),
								data: $(this).parents('form').serialize(),
								cache: false,
								type: 'POST',
								dataType: 'json'
							}
						);
						
						Request.fail(function(jqXHR, textStatus, errorThrown)
							{
								$('#but_login').removeAttr('disabled').html('Connexion');
								alertMessage('error', 'Error. Join your web admin to resolve it.');
								return false;
							}
						);
				         	
				       	Request.done(function(json, status, jqXHR)
					       	{
					        	if (json.check == 1) {
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
														}
													);							  
								 				}
											);
					   					}
									);
				  					setTimeout('window.location.href=\"'+json.url+'\"', 3000);									
								} else {
									$('#but_login').removeAttr('disabled').html('Connexion');
									alertMessage('warning', json.response);
									setTimeout(messageFailedRequest, 5000);
									return false;
								}
							}
						);
					}
					return false;
				});
	        }
		);
		
		function messageFailedRequest()
		{
			$('#but_login').removeAttr('disabled').html('Connexion');
		}
	";
	echo $this->Html->scriptBlock($script, array('inline' => false));
?>

<div class="formLogin">
	<?php
		echo $this->Form->create('User', array(
			'url' => array('action' => 'loginRequest'),
			'inputDefaults' => array('label' => false, 'div' => false),
			'default' => false
        ))
    ?>
	
		<div class="tip">
			<?php
			if (!isset($login)) {
				echo $this->Form->input('email', array('autocomplete' => 'off', 'autofocus', 'title' => __('Email')));
			} else {
				echo '<div>';
				echo $this->Html->image('/images/avatar_blank.png', array('width' => 30));
				echo '<br />';
				echo $login;
				echo '</div><br />';
				echo $this->Form->input('email', array('type' => 'hidden', 'value' => $login));
			}
			?>
		</div>
		
		<div class="tip">
			<?php
			$options = array();
			$options['autocomplete'] = 'off';
			$options['title'] = __('Mot de passe');
			
			if (isset($login)) {
				$options['autofocus'] = 'autofocus';
			}
			echo $this->Form->input('password', $options);
			?>
		</div>
		
		<div class="loginButton">
			<div class="pull-left">
				<?php if (isset($login)) echo $this->Html->link('Changer de compte', array('action' => 'login', true)) ?>
			</div>
			
			<div class="pull-right" style="margin-right:-8px;">
				<div class="btn-group">
					<button type="button" class="btn" id="but_login"><?php echo __('Connexion') ?></button>
				</div>
			</div>
			
			<div class="clear"></div>
		</div>		
	<?php echo $this->Form->end() ?>
</div>