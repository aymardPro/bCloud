<?php
$script = '
    $(document).ready(
        function()
        {
            $(".bcloud").dataTable({
                "sDom": "<\"row-fluid tb-head\"<\"span6\"f><\"span6\"<\"pull-right\"Cl>>r>t<\"row-fluid tb-foot\"<\"span4\"i><\"span8\"p>>",
                "aoColumns": [
                    null,
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
                "aaSorting": [[9, "desc"]],
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
            "'.$this->Html->url(array("action" => "add", $this->request->params['pass'][0])).'",
            function() { unloading(); }
        ).fadeIn(400);
    }
    function AcompteAdd(i)
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
            "'.$this->Html->url(array('action' => 'acompte_add')).'"+"/"+i,
            function() { unloading(); }
        ).fadeIn(400);
    }
';
echo $this->Html->scriptBlock($script, array('inline' => true));

$wstatut = array((int) Configure::read('bCloud.Facture.Statut.WAITING'), (int) Configure::read('bCloud.Facture.Statut.REJETE'));

if (in_array((int) $this->request->params['pass'][0], $wstatut)) {
    $title = 'proformas';
} else {
	$title = 'factures';
}
?>

<h2><?php echo __('Liste des acomptes'); ?></h2>

<table class="table<?php echo $bordered . $striped; ?> bcloud">
    <thead>
        <tr>
            <th class="center" width="15%"> <?php echo __('Date') ?> </th>
            <th class="right"> <?php echo __('Montant') ?> </th>
            <th width="5%"> &nbsp; </th>
        </tr>
    </thead>
    
    <tbody align="center">
        <?php foreach ($this->request->data as $data): ?>
        <tr class="odd gradeX">
            <td class="center"> <?php echo CakeTime::format('d-m-Y H:i', $data['FactureAcompte']['date']); ?> </td>
            <td class="right"> <?php echo CakeNumber::format($data['FactureAcompte']['value']); ?> </td>
            <td>
                <?php
                echo $this->Form->postLink(
                    $this->Html->image('/images/icon/coquette-icons-set/16x16/delete.png'),
                    array('action' => 'delete_acompte', $data['FactureAcompte']['id']),
                    array(
                        'escape' => false,
                        'confirm' => __("Voulez-vous supprimer définitivement l'acompte en date du %s ?", CakeTime::format('d-m-Y H:i', $data['FactureAcompte']['date']))
                    )
                );
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>