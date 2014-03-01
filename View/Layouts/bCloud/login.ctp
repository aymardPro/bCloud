<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<base href="<?php echo $this->request->webroot ?>" />
	<title><?php echo $title_for_layout; ?></title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0'));		
		echo $this->fetch('meta');
		
		echo $this->Html->css(array(
			'/components/bootstrap/bootstrap',
			'zice.style',
			'login'
		));
		echo $this->fetch('css');
		
		echo '<!--[if lt IE 9]>';
		echo $this->Html->script('http://html5shiv.googlecode.com/svn/trunk/html5.js');
		echo '<![endif]-->';
	?>
</head>        
<body>
	<div id="successLogin"></div>
	
	<div class="text_success">
		<?php echo $this->Html->image('/images/loadder/loader_green.gif', array('alt' => 'Loader')) ?>
		<span>Chargement</span>
	</div>
	
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->Session->flash('auth'); ?>
	
	<div id="login" >
		<!-- <div class="ribbon"></div> -->
		
		<div class="inner clearfix">
			<div class="logo">
				<?php echo $this->Html->image('/images/logo/logo_login.png', array('alt' => 'Logo')) ?>
			</div>

			<?php echo $this->fetch('content') ?>
		</div>

		<div class="shadow"></div>
	</div>
          			
	<div class="clear"></div>
        
	<div id="versionBar" >
		<div class="copyright">
			&copy; Copyright 2013 - All Rights Reserved - 
			<span class="tip">
				<a  href="#" title="bCloud Entreprise!">bCloud Entreprise!</a>
			</span>
		</div>
		<!-- // copyright-->
	</div>
        
	<!-- Link JScript-->
	<?php
		echo $this->Html->script(array(
			'jquery.min',
			'/components/ui/jquery.ui.min',
			'/components/form/form',
			'login'
		));
		echo $this->fetch('script');
	?>
</body>
</html>