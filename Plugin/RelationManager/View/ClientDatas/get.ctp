<?php
$this->Paginator->options
(
	array (
        'update' => '#getcontent',
        'evalScripts' => true,
        //'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
        //'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false))
    )
);

$script = "
    $(document).ready (
    	function()
	    {
	    <!--	$('table.iDream > thead > tr > th > a').each(Table); -->
	    	$('.Deleter').on('click', Notify);
	    }
    );
	
	function Notify()
	{
		alertHide();
		var NAME = $(this).attr('data-name');
		var ID = $(this).attr('data-id');
		
		$.confirm(
		{
			'title': 'FENETRE DE NOFICATION',
			'message': '<strong>VOULEZ-VOUS SUPPRIMER </strong><br /><font color=red>'+ NAME +'</font>',
			'buttons':
			{
				'Confirmer':
				{
					'class': 'special',
					'action': function ()
					{
						// Action when button Yes click.
						loading('Loading');
						
						var Request = $.ajax(
							{
								url: '".$this->Html->url(array('action' => 'delete'))."' + '/' + ID,
								cache: false,
								type: 'DELETE',
								dataType: 'json'
							}
						);
						
						Request.fail(
			            	function(jqXHR, textStatus, errorThrown)
			            	{
			            		unloading();
								alertMessage('error', 'Error. Join your web admin to resolve it.');
								return false;
							}
						);
						
						Request.done(
							function(msg)
							{
								if (msg.check == 1) {
									$('#getcontent').fadeIn(
										400,
										function()
										{
											$('#getter').load(
												'".$this->Html->url(array('action' => 'get'))."'+'/'+'".$this->request->params['pass'][0]."'+'/'+msg.datatype,
												function()
												{
													unloading();
													alertMessage('success', msg.response);
												}
											);
										}
									);
								} else {
									unloading();
									alertMessage('warning', msg.response);
									return false;
								}
							}
						);
					}
				},
				'Annuler': {'class' : ''}
			}
		});
	}
";
echo $this->Html->scriptBlock($script, array('inline' => true));
echo $this->element('bCloud/action_menu');
?>

<div class="row-fluid">
    <div class="span12 clearfix">
        
        <div class="boxtitle">
            <?php
            echo Configure::read('RelationManager.datatype.'.$this->request->params['pass'][1]);
            ?>
        </div>
        
        <table class="table table-striped iDream" id="data_table">
        	<thead>
        		<?php
        		echo $this->Html->tableHeaders(
        			// TR
        			array (
        				// TH
        				array ($this->Paginator->sort('datatype', Configure::read('RelationManager.datatype.'.$this->request->params['pass'][1])) => array('align' => 'left')),
        				// TH
        				array ('&nbsp;' => array('width' => '5%'))
        			)
        		);
        		?>
        	</thead>
        	
        	<tbody align="center">
        		<?php
                if (!$this->request->data) {
                    echo $this->element('empty_data');
                } else {
        			foreach ($this->request->data as $data)
        			{
        				echo $this->Html->tableCells(
        					array (
        						// TR
        						array (
        							// TD
        							array (
        								h(__('%s', $data['ClientData']['data'])),
        								array ('align' => 'left')
        							),
        							// TD
        							$this->Html->link
        							(
        								$this->Html->image('/images/icon/color_18/cross.png'),
        								'javascript:void(0)',
        								array (
        									'class' => 'Deleter',
        									'data-name' => __('%s', $data['ClientData']['data']),
        									'escape' => false,
        									'data-id' => $data['ClientData']['id']
        								)
        							)
        						)
        					)
        				);
        			}
        		}
        		?>
        	</tbody>
        </table>
        <?php echo $this->element('pagination'); ?>
        
    </div>

</div>
<?php echo $this->Js->writeBuffer(); ?>