<?php
$script = '
    $(document).ready(
    	function()
	    {
	    	$(".bcloud").dataTable({
	    		"sDom": "<\"row-fluid tb-head\"<\"span6\"f><\"span6\"<\"pull-right\"Cl>>r>t<\"row-fluid tb-foot\"<\"span4\"i><\"span8\"p>>",
	    		"aoColumns": 
                [
                    null,
                    null,
                    { "bSortable": false },
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
				"aaSorting": [[2, "asc"]],
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
        	"'.$this->Html->url(array("action" => "add")).'",
            function() { unloading(); }
		).fadeIn(400);
	}
';
echo $this->Html->scriptBlock($script, array('inline' => true));
?>

<div class="btn-group pull-top-right btn-square">
    <a class="btn btn-large" href="javascript:void(0)" id="add">
        <i class="icon-plus"></i>
    </a>
</div>

<h2>Liste</h2>
<hr />

<table class="table table-bordered table-striped bcloud">
	<thead>
		<tr>
			<th class="left"> <?php echo __("GROUPE D'UTILISATEUR") ?> </th>
			<th> <?php echo __("ID") ?> </th>
			<th width="5%"> <?php echo __('ACTION') ?> </th>
		</tr>
	</thead>
	
	<tbody align="center">
		<?php foreach ($this->request->data as $data): ?>
		<tr class="odd gradeX">
			<td class="left"> <?php echo h($data['Group']['name']); ?> </td>
			<td> <?php echo h($data['Group']['id']); ?> </td>
			<td>
				<?php
				if ($data['Group']['id'] === AuthComponent::user('group_id')) {
					echo $this->Html->image('/images/icon/gray_18/cross.png');
				} else {
					echo $this->Form->postLink(
	    				$this->Html->image('/images/icon/coquette-icons-set/24x24/delete.png'),
	    				array('action' => 'delete', $data['Group']['id']),
	    				array(
	    				    'escape' => false,
	    				    'confirm' => __('Voulez-vous supprimer définitivement %s ?',
	    				    $data['Group']['name'])
	                    )
	    			);
				}
				?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>