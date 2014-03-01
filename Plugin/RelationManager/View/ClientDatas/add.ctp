<?php
$script = "
    $(document).ready(
    	function()
	    {
            $('#return').on('click', Return);
		    
		    $('select').selectBox();
		    
		    $('#ClientDataAddForm').on(
                'submit',
                function()
	        	{
	        		alertHide();
	        		loading('Loading');
					$('button[type=submit]').attr('disabled', 'disabled').html('création en cours');
					
	        		var Request = $.ajax(
						{
				            url: $(this).attr('action'),
				            type: $(this).attr('method'),
				            data: $(this).serialize(),
				            cache: false,
				            dataType: 'json'
				        }
					);
						
					Request.fail(
					   function(jqXHR, textStatus, errorThrown)
			           {
			               unloading();
			               $('button[type=submit]').removeAttr('disabled').html('créer');
			               alertMessage('error', 'Error. Join your web admin to resolve it.');
			               return false;
                       }
                    );
                    
                    Request.done(
                        function(json, status, jqXHR)
			           	{
			            	if (json.check == 1) {
								$('#getcontent').fadeIn(
									400,
									function()
									{
										$('#getter').load
										(
											'".$this->Html->url(array('action' => 'get'))."'+'/'+'".$this->request->params['pass'][0]."'+'/'+json.datatype,
											function()
											{
												unloading();
												$.fancybox.close();
												alertMessage('success', json.response);
											}
										);
									}
								);
							} else {
								unloading();
								$('button[type=submit]').removeAttr('disabled').html('créer');
								alertMessage('warning', json.response);
								return false;
							}
						}
					);
					return false;
				}
			);
	    }
    );
    
    function Return()
    {
        alertHide();
        loading('Loading');
        $('#getcontent').load(
            '".$this->Html->url(array('controller' => 'clients', 'action' => 'edit', $this->request->params['pass'][0]))."',
            function() { unloading(); }
        ).fadeIn(400);
    }
";
echo $this->Html->scriptBlock($script, array ('inline' => true));
?>

<div class="row-fluid">
    <div class="span12 clearfix">

<div class="boxtitle"><?php echo __('Formulaire: Ajouter une information'); ?></div>

<?php echo $this->Form->create('ClientData', array('inputDefaults' => array('div' => 'section'))); ?>

<?php
echo $this->Form->input(
    'datatype', array (
        'class' => 'large',
        'between' => '<div>', 'after' => '</div>',
        'label' => __("Type %sChoisir parmi la liste%s", "<small>", "</small>"),
        'options' => Configure::read('RelationManager.datatype'),
        'empty' => ''
    )
);
echo $this->Form->input(
	'data', array (
		'class' => 'large',
		'between' => '<div>', 'after' => '</div>',
		'label' => 'Valeur <small>Entrez le contenu</small>'
	)
);
?>

<div class="section last">
	<div>
		<button class="btn btn-large" type="submit" id="but_submit">créer</button>
		<a class="btn btn-large special" onClick="ResetForm()">effacer</a>
	</div>
</div>

<?php echo $this->Form->end(); ?>
</div></div>