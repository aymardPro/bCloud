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
                    { "bSortable": false },
                    { "bSortable": false },
                    { "bSortable": false },
                    null,
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
                "aaSorting": [[5, "desc"]],
                "bScrollCollapse": false,
                "bStateSave": true
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
';
echo $this->Html->scriptBlock($script, array('inline' => true));
?>

<h2>
    <?php
    $title = array(
        Configure::read('bCloud.Facture.Statut.WAITING') => 'en cours',
        Configure::read('bCloud.Facture.Statut.VALIDE') => 'validées',
        Configure::read('bCloud.Facture.Statut.REJETE') => 'rejetées',
        Configure::read('bCloud.Facture.Statut.FACTURE') => 'encaissées'
    );
    echo __('Factures %s', $title[$this->request->params['pass'][1]]);
    ?>
</h2>

<hr />

<table class="table<?php echo $bordered . $striped; ?> bcloud">
    <thead>
        <tr>
            <th width="5%"> &nbsp; </th>
            <th class="left" width="15%"> <?php echo __('Référence') ?> </th>
            <th class="left"> <?php echo __('Objet') ?> </th>
            <th class="left"> <?php echo __('Par') ?> </th>
            <th class="right" width="10%"> <?php echo __('Montant') ?> </th>
            <th class="left" width="15%"> <?php echo __('Date de création') ?> </th>
        </tr>
    </thead>
    
    <tbody align="center">
        <?php foreach ($this->request->data as $data): ?>
        <tr class="odd gradeX">
            <td>
                <?php
                echo $this->Html->link(
                    $this->Html->image('/images/icon/coquette-icons-set/24x24/info.png'),
                    array('action' => 'view', $data['Facture']['id']),
                    array('escape' => false)
                );
                ?>
            </td>
            <td class="left"> <?php echo $data['Facture']['reference']; ?> </td>
            <td class="left"> <?php echo $data['Facture']['name']; ?> </td>
            <td class="left"> <?php echo __('%s %s', $data['User']['firstname'], $data['User']['lastname']); ?> </td>
            <td class="right">
                <?php
                echo CakeNumber::format($this->requestAction('/factures/idream_mt_ttc/'. $data['Facture']['id']));
                ?>
            </td>
            <td class="left"> <?php echo CakeTime::format('d-m-Y H:i', $data['Facture']['date']); ?> </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>