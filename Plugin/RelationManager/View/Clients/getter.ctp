<?php
$script = "
    $(document).ready (
        function()
        {
            $('select').chosen();
            
            $('#ClientGetterForm').on(
                'submit',
                function()
                {
                    alertHide();
                    loading('Loading');
                    $('button[type=submit]').attr('disabled', 'disabled').html('Mise à jour en cours');
                    
                    var Request = $.ajax(
                        {
                            url: $(this).attr('action'),
                            type: $(this).attr('method'),
                            data: $(this).serialize(),
                            cache: false,
                            dataType: 'json'
                        }
                    );
                        
                    Request.fail(
                       function(jqXHR, textStatus, errorThrown)
                       {
                           unloading();
                           $('button[type=submit]').removeAttr('disabled').html('Mettre à jour');
                           alertMessage('error', 'Error. Join your web admin to resolve it.');
                           return false;
                       }
                    );
                    
                    Request.done(
                        function(json, status, jqXHR)
                        {
                            if (json.check == 1) {
                                $('#getcontent').fadeIn(
                                    400,
                                    function()
                                    {
                                        $('#getcontent').load
                                        (
                                            '".$this->Html->url(array('action' => 'edit', $this->request->params['pass'][0]))."',
                                            function()
                                            {
                                                unloading();
                                                $.fancybox.close();
                                                alertMessage('success', json.response);
                                            }
                                        );
                                    }
                                );
                            } else {
                                unloading();
                                $('button[type=submit]').removeAttr('disabled').html('Créer le client');
                                alertMessage('warning', json.response);
                                return false;
                            }
                        }
                    );
                    return false;
                }
            );
        }
    );
";
echo $this->Html->scriptBlock($script, array('inline' => true));
?>

<div class="boxtitle">
    <?php echo __('Informations'); ?>
</div>
        
        <?php
        echo $this->Form->create(
            'Client',
            array(
                'url' => array('action' => 'edit', $this->request->params['pass'][0]),
                'inputDefaults' => array('div' => 'section')
            )
        );
        echo $this->Form->input(
            'economic_activity', array (
                'multiple',
                'options' => Configure::read('RelationManager.ActiviteEconomique'),
                'selected' => $associate,
                'name' => 'secteur[]',
                'class' => 'large',
                'between' => '<div>', 'after' => '</div>',
                'label' => __("Secteur d'activité  %sChoisir parmi la liste%s", "<small>", "</small>"),
            )
        );
        echo $this->Form->input(
            'name', array (
                'class' => 'large',
                'between' => '<div>', 'after' => '</div>',
                'label' => 'Dénomination <small>Entrez le nom du client</small>'
            )
        );
        echo $this->Form->input(
            'sigle', array (
                'class' => 'large',
                'between' => '<div>', 'after' => '</div>',
                'label' => "Sigle <small>Sigle usuel</small>"
            )
        );
        echo $this->Form->input(
            'rc', array (
                'class' => 'medium center',
                'between' => '<div>', 'after' => '</div>',
                'label' => 'Régistre de commerce <small>Entrez le numéro</small>'
            )
        );
        echo $this->Form->input(
            'cc', array (
                'class' => 'medium center',
                'between' => '<div>', 'after' => '</div>',
                'label' => 'Compte contribuable <small>Entrez le numéro</small>'
            )
        );
        ?>
        
        <div class="section last">
            <div>
                <button class="btn btn-large" type="submit" id="but_submit">Mettre à jour</button>
            </div>
        </div>
        
<?php echo $this->Form->end(); ?>