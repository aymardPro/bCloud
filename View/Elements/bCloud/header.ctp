<?php
$script = '
	$(document).ready(
    	function()
	    {
			// Logout Click  
			$(".logout").live("click", function()
				{ 
		  			loading("Logout",1);
		  			setTimeout("unloading()",1500);
		  			setTimeout( "window.location.href=\"'.$this->Html->url(array('controller' => 'users', 'action' => 'logout', 'plugin' => false)).'\"", 2000 );
	  			}
			);
		}
	);
';
echo $this->Html->scriptBlock($script, array('inline' => false));
?>

<div id="header">
	<?php if (AuthComponent::user()): ?>
	<ul id="account_info" class="pull-right">
		<li><?php echo $this->Html->image('/images/icon/coquette-icons-set/32x32/image.png', array('alt' => 'Online')); ?></li>
		<li class="setting">
			Bienvenue <b class="white"><?php echo __('%s', AuthComponent::user('email')) ?></b>
			<ul class="subnav">
				<li>
					<a href="<?php echo $this->Html->url(array('controller' => 'pages', 'action' => 'display', 'home', 'plugin' => false)) ?>">
						Dashboard
					</a>
				</li>
				<li><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'view', 'admin' => false, AuthComponent::user('id'), 'plugin' => false)) ?>">Mon profil</a></li>
				<li><a href="#">Paramètres</a></li>
				<br class="clearfix"/>
			</ul>
		</li>
		<li class="logout" title="Disconnect">Logout</li>
	</ul>
	<?php endif; ?>
</div>