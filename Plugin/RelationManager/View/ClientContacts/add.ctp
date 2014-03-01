<?php

if (isset($this->request->params['pass'][0])) {
	$getUrl = $this->Html->url(array('action' => 'get', $this->request->params['pass'][0]));
} else {
	$getUrl = $this->Html->url(array('action' => 'get'));
}
											
$script = "
    $(document).ready(
        function()
        {
        	$('#back').on('click', backToContent);
            $('#getContent').on('click', getContent);
            $('#telephone').mask('99-99-99-99');
            $('#cellulaire').mask('99-99-99-99');
            $('#fax').mask('99-99-99-99');
            $('select').selectBox();
            
            $('#ClientContactAddForm').on(
                'submit',
                function()
                {
                    alertHide();
                    loading('Loading');
                    $('button[type=submit]').attr('disabled', 'disabled').html('Création en cours');
                    
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
                           $('button[type=submit]').removeAttr('disabled').html('Créer');
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
                                            '".$getUrl."',
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
                                $('button[type=submit]').removeAttr('disabled').html('Créer');
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
    
    function getContent()
    {
        alertHide();
        loading('Loading');
        $('#getcontent').load
        (
            '".$getUrl."',
            function()
            { unloading(); }
        ).fadeIn(400);
    }
	
	function backToContent()
	{
		alertHide();
    	loading('Loading');
        $('#getcontent').load(
        	'".$this->Html->url(array("action" => "get"))."',
            function() { unloading(); }
		).fadeIn(400);
	}
";
echo $this->Html->scriptBlock($script, array('inline' => true));
?>

<div class="btn-group pull-top-right btn-square">
	<a class="btn btn-large" href="javascript:void(0)" id="back"><i class="icon-remove"></i></a>
</div>

<h2><?php echo __('Formulaire'); ?></h2>
<hr />

<?php echo $this->Form->create('ClientContact', array('inputDefaults' => array('div' => 'section'))); ?>

<?php
echo $this->Form->input(
    'client_id', array (
        'class' => 'large',
        'between' => '<div>', 'after' => '</div>',
        'label' => __("Client %sChoisir parmi la liste%s", "<small>", "</small>"),
        'selected' => isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0]:'',
    )
);
echo $this->Form->input(
    'genre', array (
        'class' => 'large',
        'between' => '<div>', 'after' => '</div>',
        'label' => __("Genre %sChoisir parmi la liste%s", "<small>", "</small>"),
        'options' => Configure::read('RelationManager.Genre'),
    )
);
echo $this->Form->input(
    'nom', array (
        'class' => 'medium',
        'between' => '<div>', 'after' => '</div>',
        'label' => 'Nom <small>Entrez le nom</small>'
    )
);
echo $this->Form->input(
    'prenoms', array (
        'class' => 'large',
        'between' => '<div>', 'after' => '</div>',
        'label' => 'Prénoms <small>Entrez le(s) prénom(s)</small>'
    )
);
echo $this->Form->input(
    'fonction', array (
        'class' => 'large',
        'between' => '<div>', 'after' => '</div>',
        'label' => 'Fonction <small>Entrez le fonction</small>'
    )
);

echo $this->Form->input(
    'tel', array (
    	'type' => 'text',
        'class' => 'small center',
        'between' => '<div>', 'after' => '</div>',
        'label' => 'Téléphone <small>Entrez le numéro de téléphone</small>',
        'id'=>'telephone'
    )
);

echo $this->Form->input(
    'cel', array (
        'class' => 'small center',
        'between' => '<div>', 'after' => '</div>',
        'label' => 'Cellulaire <small>Entrez le numéro cellulaire</small>',
        'id'=>'cellulaire'
    )
);

echo $this->Form->input(
    'email', array (
        'class' => 'large',
        'between' => '<div>', 'after' => '</div>',
        'label' => 'E-mail <small>Entrez l\'adresse email</small>'
    )
);
?>

<div class="section last">
    <div>
        <button class="btn btn-large" type="submit" id="but_submit">Créer</button>
        <a class="btn btn-large special" onClick="ResetForm()">Effacer</a>
    </div>
</div>

<?php echo $this->Form->end(); ?>