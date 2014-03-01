<?php
$script = "
    $(document).ready (
        function()
        {
            Getter();
            var stateObj = {};
            history.replaceState(stateObj, '', '".$this->Html->url(array ('action' => 'view', $this->request->params['pass'][0]))."');
        }
    );
    
    function Getter()
    {
        alertHide();
        loading('Loading');
        $('#getter').load(
            '".$this->Html->url(array('action' => 'getter', $this->request->params['pass'][0]))."',
            function() { unloading(); }
        ).fadeIn(400);
    }
";
echo $this->Html->scriptBlock($script, array('inline' => true));
?>

<?php echo $this->element('RelationManager.client_action'); ?>

<div class="boxtitle" style="font-size: 16px; color: #900; font-weight: bold">
    <i class="icon-folder-open"></i>&nbsp;&nbsp;<?php echo __('%s', $this->request->data['Client']['name']); ?>
</div>

<div class="row-fluid">
    <div class="span9 clearfix">
        <div id="getter"></div>
    </div>
    
    <?php echo $this->element('fiche_client_menu', array(), array('plugin' => 'RelationManager')); ?>
</div>