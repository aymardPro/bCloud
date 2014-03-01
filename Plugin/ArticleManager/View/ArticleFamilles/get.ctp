<?php
$script = '
    $(document).ready(
    	function()
	    {
	    	$(".bcloud").dataTable({
	    		"sDom": "<\"row-fluid tb-head\"<\"span6\"f><\"span6\"<\"pull-right\"Cl>>r>t<\"row-fluid tb-foot\"<\"span4\"i><\"span8\"p>>",
	    		"aoColumns": [
	    			{ "bSortable": false },
	    			{ "bSortable": false },
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
echo $this->element('bCloud/action_menu');
?>

<h2>Liste</h2>
<hr />

<table class="table table-bordered table-striped bcloud">
	<thead>
		<tr>
            <th class="left"> <?php echo __('NOM DE FAMILLE') ?> </th>
            <th class="left" width="15%"> <?php echo __('TYPE') ?> </th>
			<th width="5%"> <?php echo __('ACTION') ?> </th>
		</tr>
	</thead>
	
	<tbody align="center">
		<?php foreach ($this->request->data as $data): ?>
		<tr class="odd gradeX">
            <td class="left">
                <?php
                if (((int) $data['ArticleFamille']['type'] === 1)) echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                echo $data['ArticleFamille']['name'];
                ?>
            </td>
            <td class="left">
            	<span style="background: #ccc; padding: 2px 5px; font-size: 10px;">
            		<?php echo ((int) $data['ArticleFamille']['type'] === 1) ? 'Détail':'Centralisateur'; ?>
            	</span>
                
            </td>
			<td>
				<?php
				echo $this->Form->postLink(
    				$this->Html->image('/images/icon/coquette-icons-set/24x24/delete.png'),
    				array('action' => 'delete', $data['ArticleFamille']['id']),
    				array('escape' => false, 'confirm' => __('Voulez-vous supprimer définitivement %s ?', $data['ArticleFamille']['name']))
    			);
				?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>