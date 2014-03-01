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
                    { "bSortable": false },
                    { "bSortable": false },
                    { "bSortable": false },
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
				"bScrollCollapse": false,
				"bStateSave": false
			});
			$("select").selectBox();
			$("#add").on("click", AddForm);
			$(".btip").tipsy({gravity: "e",live: true});	
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

<h2> Catalogue articles </h2>
<hr />

<table class="table table-striped bcloud">
	<thead>
		<tr>
			<th width="5%"> &nbsp; </th>
            <th class="left">Référence</th>
            <th class="left">Désignation</th>
            <th class="right"> Prix d'achat </th>
            <th class="right"> Marge </th>
            <th class="right"> Prix de vente </th>
            <th class="right"> Stock dispo. </th>
            <th class="right"> Famille </th>
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
    				array('action' => 'view', $data['Article']['id']),
    				array('escape' => false)
    			);
				?>
			</td>
            <td class="left">
                <?php echo h($data['Article']['reference']); ?>
            </td>
            <td class="left">
                <?php echo h($data['Article']['designation']); ?>
            </td>
            <td class="right">
                <?php echo CakeNumber::format($data['Article']['prix_unitaire']); ?>
            </td>
            <td class="right">
                <?php echo CakeNumber::format($data['Article']['marge']).'%'; ?>
            </td>
            <td class="right">
                <?php echo CakeNumber::format($this->requestAction(array('action' => 'getPrixVente', $data['Article']['id']))); ?>
            </td>
            <td class="right">
                <?php echo CakeNumber::format($this->requestAction(array('action' => 'getStock', $data['Article']['id']))); ?>
            </td>
            <td class="right">
                <?php echo $data['ArticleFamille']['name']; ?>
            </td>
			<td>
				<?php
				echo $this->Form->postLink(
    				$this->Html->image('/images/icon/coquette-icons-set/24x24/delete.png'),
    				array('action' => 'delete', $data['Article']['id']),
    				array('escape' => false, 'confirm' => __('Voulez-vous supprimer définitivement %s ?', $data['Article']['designation']))
    			);
				?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>