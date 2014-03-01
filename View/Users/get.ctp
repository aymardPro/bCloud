<?php
$script = '
    $(document).ready(
    	function()
	    {
	    	$(".bcloud").dataTable({
	    		"sDom": "<\"row-fluid tb-head\"<\"span6\"f><\"span6\"<\"pull-right\"Cl>>r>t<\"row-fluid tb-foot\"<\"span4\"i><\"span8\"p>>",
	    		"aoColumns":
	    		[
                    { "bSortable": false },
                    null,
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
				"aaSorting": [[10, "asc"]],
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

<h2>Liste des utilisateurs</h2>
<hr />

<table class="table table-striped bcloud">
	<thead>
		<tr>
			<th width="5%"> &nbsp; </th>
			<th class="left"> <?php echo __('NOM &amp; PRENOMS') ?> </th>
            <th width="15%" class="right"> <?php echo __('COMPTE') ?> </th>
            <th width="10%"> <?php echo __('STATUT') ?> </th>
            <th width="15%" class="right"> <?php echo __('GROUPE') ?> </th>
            <th width="20%" class="right"> <?php echo __('DERNIERE CONNEXION') ?> </th>
			<th width="5%"> &nbsp; </th>
		</tr>
	</thead>
	
	<tbody align="center">
		<?php foreach ($this->request->data as $data): ?>
		<tr class="odd gradeX wtip">
			<td>
				<?php
				echo $this->Html->link(
    				$this->Html->image('/images/icon/coquette-icons-set/24x24/info.png'),
    				array('action' => 'view', $data['User']['id']),
    				array('escape' => false, 'title' => __('Profil de %s %s', $data['User']['prenoms'], $data['User']['nom']))
    			);
				?>
			</td>
            <td class="left">
                <?php echo __('%s %s', $data['User']['prenoms'], $data['User']['nom']); ?>
            </td>
            <td class="right">
                <?php echo $data['Account']['name']; ?>
            </td>
            <td class="center">
                <?php
                $status = (bool) $data['User']['status'] ? 'Activé':'Désactivé';
                echo $this->Html->image(
                    '/images/icon/coquette-icons-set/16x16/'.((bool) $data['User']['status'] ? 'green':'red').'_button.png',
                    array(
                        'alt' => $status,
                        'title' => $status
                    )
                );
                ?>
            </td>
            <td class="right">
                <?php echo $data['Group']['name']; ?>
            </td>
			<td class="right">
                    <?php
                    if (!is_null($data['User']['lastvisite'])) {
                     echo CakeTime::timeAgoInWords($data['User']['lastvisite']);
                    } else {
                        echo __('Jamais');
                    }
                    ?>
			</td>
			<td>
				<?php
				if ($data['User']['id'] === AuthComponent::user('id')) {
					echo $this->Html->image('/images/icon/gray_18/cross.png');
				} else {
					echo $this->Form->postLink(
	    				$this->Html->image('/images/icon/coquette-icons-set/24x24/delete.png'),
	    				array('action' => 'delete', $data['User']['id']),
	    				array(
	    				    'escape' => false,
	    				    'confirm' => __('Voulez-vous supprimer définitivement %s %s ?',
	    				    $data['User']['nom'], $data['User']['prenoms'])
	                    )
	    			);
				}
				?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>