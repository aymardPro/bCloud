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
                "aaSorting": [[10, "desc"]],
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
?>

<div class="btn-group pull-top-right btn-square">
    <a class="btn btn-large" href="javascript:void(0)" id="add">
    	<i class="icon-plus"></i> 
    </a>
</div>

<h2>Liste des devis</h2>
<hr />

<table class="table bcloud table-striped">
    <thead>
        <tr>
            <th width="5%"> &nbsp; </th>
            <th class="left" width="15%"> <?php echo __('Référence') ?> </th>
            <th width="5%"> &nbsp; </th>
            <th class="left"> <?php echo __('Client') ?> </th>
            <th class="left"> <?php echo __('Objet') ?> </th>
            <th class="right" width="10%"> <?php echo __('Montant') ?> </th>
            
            <th class="left"> <?php echo __('Commercial') ?> </th>
            
            <th width="5%"> &nbsp; </th>
            <th width="5%"> &nbsp; </th>
            <th class="center" width="10%"> <?php echo __('Date') ?> </th>
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
                    array('action' => 'view', $data['Proforma']['id']),
                    array('escape' => false)
                );
                ?>
            </td>
            <td class="left"> <?php echo $data['Proforma']['reference']; ?> </td>
            <td class="etip">
                <?php
                if ((int) $data['Proforma']['proforma_statut_id'] === (int) Configure::read('bCloud.Proforma.Statut.WAITING')) {
                    $flag = CakeTime::isFuture($data['Proforma']['echeance']) ? 'green':'red';
                    
                    switch ($flag) {
                        case 'green':
                            $title = __("Valable jusqu'au %s", CakeTime::format($data['Proforma']['echeance'], '%d-%m-%Y'));
                            break;
                        
                        case 'red':
                            $title = __('Expiré depuis le %s', CakeTime::format($data['Proforma']['echeance'], '%d-%m-%Y'));
                            break;
                    }
                } else {
                    $flag = 'white';
                    $title = '';
                }
                echo $this->Html->link(
                    $this->Html->image('/images/icon/coquette-icons-set/24x24/'.$flag.'_flag.png'),
                    'Javascript:void(0)',
                    array('title' => $title, 'escape' => false)
                );
                ?>
            </td>
            <td class="left"> <?php echo $data['Client']['name']; ?> </td>
            <td class="left"> <?php echo $data['Proforma']['name']; ?> </td>
            <td class="right">
                <?php
                echo CakeNumber::format($this->requestAction('/proformas/idream_net_a_payer/'. $data['Proforma']['id']));
                ?>
            </td>
            
            <td class="left"> <?php echo __('%s %s', $data['User']['nom'], $data['User']['prenoms']); ?> </td>
            
            <td class="right wtip">
                <?php
                if ((int)Configure::read('bCloud.Proforma.Statut.WAITING') === (int)$data['Proforma']['proforma_statut_id']) {
                    echo $this->Form->postLink(
                        $this->Html->image('/images/icon/color_18/hand_thumbsup.png'),
                        array('action' => 'state', $data['Proforma']['id'], Configure::read('bCloud.Proforma.Statut.VALIDE')),
                        array(
                            'title' => 'Valider la proforma',
                            'escape' => false,
                            'confirm' => __('Voulez-vous marquer %s comme accepté ?', $data['Proforma']['reference'])
                        )
                    );
                } else {
                    echo $this->Html->image('/images/icon/gray_18/hand_thumbsup.png');
                }
                ?>
            </td>
            <td class="right wtip">
                <?php
                if ((int)Configure::read('bCloud.Proforma.Statut.WAITING') === (int)$data['Proforma']['proforma_statut_id']) {
                    echo $this->Form->postLink(
                        $this->Html->image('/images/icon/color_18/hand_thumbsdown.png'),
                        array('action' => 'state', $data['Proforma']['id'], Configure::read('bCloud.Proforma.Statut.REJETE')),
                        array(
                            'title' => 'Rejeter la proforma',
                            'escape' => false,
                            'confirm' => __('Voulez-vous marquer %s comme rejeté ?', $data['Proforma']['reference'])
                        )
                    );
                } else {
                    echo $this->Html->image('/images/icon/gray_18/hand_thumbsdown.png');
                }
                ?>
            </td>
            <td class="center"> <?php echo CakeTime::format($data['Proforma']['date'], '%d-%m-%Y'); ?> </td>
            <td>
                <?php
                if (((int)Configure::read('bCloud.Proforma.Statut.REJETE') !== (int)$data['Proforma']['proforma_statut_id']) &&
                    ((int)Configure::read('bCloud.Proforma.Statut.VALIDE') !== (int)$data['Proforma']['proforma_statut_id'])) {
                    echo $this->Form->postLink(
                        $this->Html->image('/images/icon/coquette-icons-set/24x24/delete.png'),
                        array('action' => 'delete', $data['Proforma']['id']),
                        array('escape' => false, 'confirm' => __('Voulez-vous supprimer définitivement %s ?', $data['Proforma']['reference']))
                    );
                }
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>