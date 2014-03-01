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
                    { "bSortable": false },
                    { "bSortable": false },
                    { "bSortable": false },
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

<?php if ((int)$this->request->params['pass'][0] !== (int)Configure::read('bCloud.Facture.Statut.REJETE')) { ?>
<div class="btn-group pull-top-right btn-square">
    <a class="btn btn-large" href="javascript:void(0)" id="add">
    	<i class="icon-plus"></i> 
    </a>
</div>
<?php } ?>

<h2>Liste des <?php echo $title; ?></h2>

<table class="table bcloud">
    <thead>
        <tr>
            <th width="5%"> &nbsp; </th>
            <th class="left" width="15%"> <?php echo __('Référence') ?> </th>
            <th class="left"> <?php echo __('Client') ?> </th>
            <th class="left"> <?php echo __('Objet') ?> </th>
            <th class="right" width="10%"> <?php echo __('Montant') ?> </th>
            <th width="5%"> &nbsp; </th>
            <th width="5%"> &nbsp; </th>
            <th width="5%"> &nbsp; </th>
            <th class="left" width="15%"> <?php echo __('Date de création') ?> </th>
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
                    array('action' => 'view', $data['Facture']['id']),
                    array('escape' => false)
                );
                ?>
            </td>
            <td class="left"> <?php echo $data['Facture']['reference']; ?> </td>
            <td class="left"> <?php echo $data['Client']['name']; ?> </td>
            <td class="left"> <?php echo $data['Facture']['name']; ?> </td>
            <td class="right">
                <?php
                echo CakeNumber::format($this->requestAction('/factures/idream_mt_ttc/'. $data['Facture']['id']));
                ?>
            </td>
            <td class="right wtip">
                <?php
                if ((int)Configure::read('bCloud.Facture.Statut.WAITING') === (int)$data['Facture']['statut_id']) {
                    echo $this->Form->postLink(
                        $this->Html->image('/images/icon/color_18/hand_thumbsup.png'),
                        array('action' => 'state', $data['Facture']['id'], Configure::read('bCloud.Facture.Statut.VALIDE')),
                        array(
                            'title' => 'Valider la proforma',
                            'escape' => false,
                            'confirm' => __('Voulez-vous marquer %s comme accepté ?', $data['Facture']['reference'])
                        )
                    );
                } else {
                    echo $this->Html->image('/images/icon/gray_18/hand_thumbsup.png');
                }
                ?>
            </td>
            <td class="right wtip">
                <?php
                if ((int)Configure::read('bCloud.Facture.Statut.WAITING') === (int)$data['Facture']['statut_id']) {
                    echo $this->Form->postLink(
                        $this->Html->image('/images/icon/color_18/hand_thumbsdown.png'),
                        array('action' => 'state', $data['Facture']['id'], Configure::read('bCloud.Facture.Statut.REJETE')),
                        array(
                            'title' => 'Rejeter la proforma',
                            'escape' => false,
                            'confirm' => __('Voulez-vous marquer %s comme rejeté ?', $data['Facture']['reference'])
                        )
                    );
                } else {
                    echo $this->Html->image('/images/icon/gray_18/hand_thumbsdown.png');
                }
                ?>
            </td>
            <td class="right wtip">
                <?php
                if ((int)Configure::read('bCloud.Facture.Statut.VALIDE') === (int)$data['Facture']['statut_id']) {
                    echo $this->Form->postLink(
                        $this->Html->image('/images/icon/coquette-icons-set/24x24/dollar_currency_sign.png'),
                        array('action' => 'state', $data['Facture']['id'], Configure::read('bCloud.Facture.Statut.FACTURE')),
                        array(
                            'title' => 'Comptabiliser la facture',
                            'escape' => false,
                            'confirm' => __('Voulez-vous confirmer que vous encaissez %s ?', $data['Facture']['reference']),
                        )
                    );
                } else {
                    echo $this->Html->image('/images/icon/coquette-icons-set/24x24/dollar_currency_sign_black.png');
                }
                ?>
            </td>
            <td class="left"> <?php echo CakeTime::format('d-m-Y H:i', $data['Facture']['date']); ?> </td>
            <td>
                <?php
                if (((int)Configure::read('bCloud.Facture.Statut.FACTURE') !== (int)$data['Facture']['statut_id']) &&
                    ((int)Configure::read('bCloud.Facture.Statut.VALIDE') !== (int)$data['Facture']['statut_id'])) {
                    echo $this->Form->postLink(
                        $this->Html->image('/images/icon/coquette-icons-set/16x16/delete.png'),
                        array('action' => 'delete', $data['Facture']['id']),
                        array('escape' => false, 'confirm' => __('Voulez-vous supprimer définitivement %s ?', $data['Facture']['reference']))
                    );
                }
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>