<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8" />
        <title><?php echo $title_for_layout; ?> :: bCloud</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Link shortcut icon-->
        <link rel="shortcut icon" type="image/ico" href="images/favicon.ico"/>
        
        <!-- CSS Stylesheet-->
        <?php
        echo $this->Html->css(array(
			'/components/bootstrap/bootstrap',
			'/components/bootstrap/bootstrap-responsive',
			'zice.style',
		));
		echo $this->fetch('css');
        ?>
	</head>
	
	<body>
		<!-- header -->
        <?php echo $this->element('bCloud/header'); ?>
		<!-- End header -->
		
		<!-- left_menu -->
		<?php echo $this->element('bCloud/left_menu'); ?>
		<!-- End left_menu -->
		
		<!-- content -->
		<div id="content">
			<!-- inner -->
			<div class="inner">
				<div class="row-fluid">
					<div class="span12 clearfix">
                    	<div class="logo"></div>
                        
                        <ul id="shortcut" class="clearfix">
                        <li>
                        	<a href="#" title="Back To home">
                            	<?php echo $this->Html->image('/images/icon/shortcut/home.png', array('alt' => 'home')) ?>
                              	<strong>Home</strong>
                        	</a>
                        </li>
                      	<li>
                        	<a href="#" title="Website Graph">
                      			<?php echo $this->Html->image('/images/icon/shortcut/graph.png', array('alt' => 'graph')) ?>
                             	<strong>Graph</strong>
                           	</a>
                      	</li>
                     	<li>
                        	<a href="#" title="Setting">
                            	<?php echo $this->Html->image('/images/icon/shortcut/setting.png', array('alt' => 'setting')) ?>
                             	<strong>Setting</strong>
                         	</a>
                  		</li>
                      	<li>
                      		<a href="#" title="Messages">
                          		<?php echo $this->Html->image('/images/icon/shortcut/mail.png', array('alt' => 'messages')) ?>
                             	<strong>Message</strong>
                        	</a>
                       		<div class="notification" >10</div>
                       	</li>
                  	</ul>
              	</div>
           	</div>
           	
           	<?php echo $this->Session->flash('auth'); ?>
           	<?php echo $this->Session->flash(); ?>
           	
           	<div id="container">
          		<?php echo $this->fetch('content'); ?>
         	</div>
         	
         	<!-- footer -->
			<?php echo $this->element('bCloud/footer'); ?>
			<!-- End footer -->
		</div>
		<!-- End inner -->
	</div>
	<!-- End content -->
	
	<!--[if lte IE 8]>
	<?php echo $this->Html->script('/components/flot/excanvas.min'); ?>
	<![endif]-->
	
	<?php
	echo $this->Html->script(array(
		'jquery.min',
		'/components/ui/jquery.ui.min',
		'/components/bootstrap/bootstrap.min',
		'/components/ui/timepicker',
		'/components/colorpicker/js/colorpicker',
		'/components/form/form',
		'/components/elfinder/js/elfinder.full',
		'/components/datatables/dataTables.min',
		'/components/fancybox/jquery.fancybox',
		'/components/jscrollpane/jscrollpane.min',
		'/components/editor/jquery.cleditor',
		'/components/chosen/chosen',
		'/components/validationEngine/jquery.validationEngine',
		'/components/validationEngine/jquery.validationEngine-en',
		'/components/fullcalendar/fullcalendar',
		'/components/flot/flot',
		'/components/uploadify/uploadify',
		'/components/Jcrop/jquery.Jcrop',
		'/components/smartWizard/jquery.smartWizard.min',
		'jquery.cookie',
		'zice.custom'
	));
	echo $this->fetch('script');
	?>
	</body>
</html>