<?php
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
				"aaSorting": [[0, "desc"]],
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
        	"'.$this->Html->url(array("action" => "add", $this->request->params['pass'][0])).'",
            function() { unloading(); }
		).fadeIn(400);
	}
';
echo $this->Html->scriptBlock($script, array('inline' => true));
?>

<div class="btn-group pull-top-right btn-square">
	<a class="btn btn-large" href="javascript:void(0)" id="add"><i class="icon-plus"></i></a>
</div>

<h2>Liste des mouvements de transfert</h2>
<hr />

<table class="table table-striped bcloud">
	<thead>
		<tr>
			<th width="5%"> &nbsp; </th>
            <th class="left"> <?php echo __('INTITULE') ?> </th>
            <th class="left"> <?php echo __('DE') ?> </th>
            <th class="left"> <?php echo __('VERS') ?> </th>
			<th class="center" width="15%"> <?php echo __('DATE') ?> </th>
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
    				array('action' => 'view', $data['Mouvement']['id']),
    				array('escape' => false)
    			);
				?>
			</td>
			<td class="left"> <?php echo $data['Mouvement']['name']; ?> </td>
            <td class="left">
                <?php echo __('%s', Configure::read('bCloud.Mouvement.Type.'.$data['Depot']['depot_depart'])); ?>
            </td>
            <td class="left">
                <?php echo __('%s', Configure::read('bCloud.Mouvement.Type.'.$data['Depot']['depot_arrive'])); ?>
            </td>
            <td class="center">
                <?php echo __('%s', CakeTime::format('d-m-Y H:i', $data['Mouvement']['date'])); ?>
            </td>
			<td>
				<?php
				echo $this->Form->postLink(
    				$this->Html->image('/images/icon/coquette-icons-set/16x16/delete.png'),
    				array('action' => 'delete', $data['Mouvement']['id']),
    				array('escape' => false, 'confirm' => __('Voulez-vous supprimer définitivement %s ?', $data['Mouvement']['name']))
    			);
				?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>