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
        $('#getter').load(
            '".$this->Html->url(array('controller' => 'client_datas', 'action' => 'add', $this->request->params['pass'][0]))."',
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
                            <i class="icon-share-alt"></i>
                        </a>
                    </div>