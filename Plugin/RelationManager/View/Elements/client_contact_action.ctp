<?php
$script = "
    $(document).ready(
        function()
        {
            $('#loadForm').on('click', Form);
        }
    );
    
    function Form()
    {
        alertHide();
        loading('Loading');
        $('#getcontent').load(
            '".$this->Html->url(array('controller' => 'client_contacts', 'action' => 'add', $this->request->params['pass'][0]))."',
            function() { unloading(); }
        ).fadeIn(400);
    }
";
echo $this->Html->scriptBlock($script, array('inline' => true));
?>

<div class="btn-group pull-top-right btn-square">
                        <a 
                            class="btn btn-large" 
                            href="<?php echo $this->Html->url(array('controller' => 'clients', 'action' => 'index')) ?>" 
                            title="<?php echo __('Gérer les clients'); ?>">
                            <i class="icon-share-alt"></i> &nbsp;&nbsp;<?php echo __('Retour'); ?>
                        </a>
                        <a class="btn btn-large" href="javascript:void(0)" id="loadForm" title="<?php echo __('Ajouter un contact'); ?>">
                            <i class="icon-plus"></i>&nbsp;&nbsp;<?php echo __('Ajouter'); ?>
                        </a>
                    </div>