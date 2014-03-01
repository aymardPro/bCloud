<?php

if (isset($this->request->params['pass'][0])) {
	$addUrl = $this->Html->url(array('action' => 'add', $this->request->params['pass'][0]));
} else {
	$addUrl = $this->Html->url(array('action' => 'add'));
}
					
$script = '
    $(document).ready(
    	function()
	    {
	    	$(".bcloud").dataTable({
	    		"sDom": "<\"row-fluid tb-head\"<\"span6\"f><\"span6\"<\"pull-right\"Cl>>r>t<\"row-fluid tb-foot\"<\"span4\"i><\"span8\"p>>",
	    		"aoColumns": [
	    			{ "bSortable": false },
	    			null,
	    			null,
	    			null,
	    			null,
	    			null,
	    			null,
	    			{ "bSortable": false }
	    		],
	    		"bJQueryUI": false,
	    		"iDisplayLength": 10,
	    		"bSort": true,
	    		"sPaginationType": "bootstrap",
	    		"oLanguage": {
	    			"sLengthMenu": "_MENU_",
	    			"sSearch": "Recherche",
					"oPaginate": {
		    			"sNext": "Suivant",
		    			"sPrevious": "Précédent"
					},
					"sInfo": "Affichage de _START_ à _END_ sur _TOTAL_",
					"sInfoEmpty": "Affichage de 0 donnée",
					"sEmptyTable": "Aucune donnée disponible",
					"sInfoFiltered": "(filtrée sur un total de _MAX_)",
					"sZeroRecords": "Pas de correspondance à partir de ce filtre"
				},
				"aaSorting": [[0, "asc"]],
				"bScrollCollapse": false,
				"bStateSave": false
			});
			$("select").selectBox();
			$("#add").on("click", AddForm);
	    }
    );
	
	function AddForm()
	{
		alertHide();
    	loading("Loading");
        $("#getcontent").load(
        	"'.$addUrl.'",
            function() { unloading(); }
		).fadeIn(400);
	}
';
echo $this->Html->scriptBlock($script, array('inline' => true));
echo $this->element('bCloud/action_menu');
?>

<h2>Liste des contacts</h2>
<hr />

<table class="table table-striped bcloud">
	<thead>
		<tr>
			<th width="5%"> &nbsp; </th>
			<th class="left"> <?php echo __('Nom & prénoms') ?> </th>
			<th class="left"> <?php echo __('Entreprise') ?> </th>
			<th class="left"> <?php echo __('Fonction') ?> </th>
			<th class="left"> <?php echo __('Téléphone') ?> </th>
			<th class="left"> <?php echo __('Cellulaire') ?> </th>
			<th class="left"> <?php echo __('E-mail') ?> </th>
			<th width="5%"> &nbsp; </th>
		</tr>
	</thead>
	
	<tbody align="center">
		<?php foreach ($this->request->data as $data): ?>
		<tr class="odd gradeX">
			<td>
				<?php
				echo $this->Html->link(
    				$this->Html->image('/images/icon/coquette-icons-set/24x24/info.png'),
    				array('action' => 'view', $data['ClientContact']['id']),
    				array('escape' => false)
    			);
				?>
			</td>
			<td class="left"> <?php echo __('%s (%s)', $data['ClientContact']['nom'], $data['ClientContact']['prenoms']); ?> </td>
			<td class="left"> <?php echo __('%s', $data['Client']['name']); ?> </td>
			<td class="left"> <?php echo __('%s', $data['ClientContact']['fonction']); ?> </td>
			<td class="left"> <?php echo __('%s', $data['ClientContact']['tel']); ?> </td>
			<td class="left"> <?php echo __('%s', $data['ClientContact']['cel']); ?> </td>
			<td class="left"> <?php echo __('%s', $data['ClientContact']['email']); ?> </td>
			<td>
				<?php
				echo $this->Form->postLink(
    				$this->Html->image('/images/icon/coquette-icons-set/24x24/delete.png'),
    				array('action' => 'delete', $data['ClientContact']['id']),
    				array(
    					'escape' => false,
    					'confirm' => __(
    						'Voulez-vous supprimer définitivement %s %s ?',
    						$data['ClientContact']['nom'], $data['ClientContact']['prenoms']
						)
					)
    			);
				?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>