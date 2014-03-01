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
?>

<h2>Liste des devis</h2>

<table class="table<?php echo $bordered . $striped; ?> bcloud">
    <thead>
        <tr>
            <th width="5%"> &nbsp; </th>
            <th class="left" width="15%"> <?php echo __('Référence') ?> </th>
            <th class="left"> <?php echo __('Objet') ?> </th>
            <th class="right" width="10%"> <?php echo __('Montant') ?> </th>
            
            <th class="left"> <?php echo __('Commercial') ?> </th>
            
            <th width="5%"> &nbsp; </th>
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
                    array('action' => 'view', $data['Proforma']['id']),
                    array('escape' => false)
                );
                ?>
            </td>
            <td class="left"> <?php echo $data['Proforma']['reference']; ?> </td>
            <td class="left"> <?php echo $data['Proforma']['name']; ?> </td>
            <td class="right">
                <?php
                echo CakeNumber::format($this->requestAction('/proformas/idream_mt_ttc/'. $data['Proforma']['id']));
                ?>
            </td>
            
            <td class="left"> <?php echo __('%s %s', $data['User']['nom'], $data['User']['prenoms']); ?> </td>
            
            <td class="right wtip">
                <?php
                switch ((int)$data['Proforma']['proforma_statut_id']) {
                    case (int)Configure::read('bCloud.Proforma.Statut.WAITING'):
                        $handstate = 'point';
                        $handtitle = 'En cours';
                        break;
                        
                    case (int)Configure::read('bCloud.Proforma.Statut.VALIDE'):
                        $handstate = 'thumbsup';
                        $handtitle = 'Acceptée';
                        break;
                        
                    case (int)Configure::read('bCloud.Proforma.Statut.REJETE'):
                        $handstate = 'thumbsdown';
                        $handtitle = 'Rejetée';
                        break;
                }
                
                echo $this->Html->image('/images/icon/color_18/hand_'. $handstate .'.png', array('title' => $handtitle));
                ?>
            </td>
            <td class="left"> <?php echo CakeTime::format('d-m-Y H:i', $data['Proforma']['date']); ?> </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>