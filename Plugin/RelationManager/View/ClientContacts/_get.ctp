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
	   <!-- 	$('table.iDream > thead > tr > th > a').each(Table); -->
	    	$('.Deleter').on('click', Notify);
            
            var stateObj = {};
           <!-- history.replaceState(stateObj, '', '".$this->Html->url(array ('action' => 'index', $this->request->params['pass'][0]))."'); -->
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
											$('#getcontent').load(
												'".$this->Html->url(array('action' => 'get', $this->request->params['pass'][0]))."',
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
?>
<?php echo $this->element('RelationManager.client_contact_action'); ?>

<div class="boxtitle" style="font-size: 16px; color: #900; font-weight: bold">
    <i class="icon-folder-open"></i>&nbsp;&nbsp;<?php echo __('%s', $client['Client']['name']); ?>
</div>

<div class="boxtitle">
    <?php echo __('Liste de contacts'); ?>
</div>

<table class="table table-striped iDream" id="data_table">
	<thead>
		<?php
		echo $this->Html->tableHeaders(
			// TR
			array (
				// TH
				array (
					'<div class="checksquared">
					<input type="checkbox" id="checkAll1" class="checkAll" />
					<label for="checkAll1"></label>
					</div>',
					array ('width' => '5%')
				),
                // TH
                array ($this->Paginator->sort('nom', __('Nom & prénoms')) => array('align' => 'left')),
                // TH
                array ($this->Paginator->sort('fontion', __('Fonction')) => array('align' => 'left')),
                // TH
                array ($this->Paginator->sort('tel', __('Téléphone')) => array('align' => 'left')),
                // TH
                array ($this->Paginator->sort('cel', __('Cellulaire')) => array('align' => 'left')),
                // TH
                array ($this->Paginator->sort('email', __('E-mail')) => array('align' => 'left')),
                // TH
            //    array ($this->Paginator->sort('created', __('Date création')) => array('width' => '15%')),
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
							'<div class="checksquared">
								<input type="checkbox" name="checkbox[]" id="'.$data['ClientContact']['id'].'" />
								<label></label></div>',
                            // TD
                            array (
                                h(__('%s %s', $data['ClientContact']['nom'], $data['ClientContact']['prenoms'])),
                                array ('align' => 'left')
                            ),
                            // TD Fonction
                            array (
                                h(__('%s', $data['ClientContact']['fonction'])),
                                array ('align' => 'left')
                            ),
                            // TD Telephone
                            array (
                                h(__('%s', $data['ClientContact']['tel'])),
                                array ('align' => 'left')
                            ),
                            // TD Cellulaire
                            array (
                                h(__('%s', $data['ClientContact']['cel'])),
                                array ('align' => 'left')
                            ),
                            // TD Email
                            array (
                                h(__('%s', $data['ClientContact']['email'])),
                                array ('align' => 'left')
                            ),
                            // TD
                          //  h(__('%s', $data['ClientContact']['created'])),
							// TD
							$this->Html->link
							(
								$this->Html->image('/images/icon/coquette-icons-set/16x16/delete.png'),
								'javascript:void(0)',
								array (
									'class' => 'Deleter',
									'data-name' => __('%s %s', $data['ClientContact']['nom'], $data['ClientContact']['prenoms']),
									'escape' => false,
									'data-id' => $data['ClientContact']['id']
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

<?php
echo $this->element('pagination');
echo $this->Js->writeBuffer();
?>