<?php
$script = '
    $(document).ready (
        function()
        {
            $("select").chosen();
            $("#ClientTel").mask("99-99-99-99");
            $("#ClientCel").mask("99-99-99-99");
            $("#ClientFax").mask("99-99-99-99");
            $("form#ClientEditForm").validationEngine();
            $("form#ClientEditForm").on(
                "submit",
                function()
                {
                    loading("Loading");
                    $(".submit_form").attr("disabled", "disabled").html("Mise à jour en cours");
                    
                    var Request = $.ajax(
                        {
                            url: $(this).attr("action"),
                            type: $(this).attr("method"),
                            data: $(this).serialize(),
                            cache: false,
                            dataType: "json"
                        }
                    );
                    
                    Request.fail(
                        function(jqXHR, textStatus, errorThrown)
                        {
                            unloading();
                            $(".submit_form").removeAttr("disabled").html("Mettre à jour");
                            alertMessage("error", "Join your web admin to resolve it.");
                            return false;
                        }
                    );
                    
                    Request.done(
                        function(json, status, jqXHR)
                        {
                            if (json.check == 0)
                            {
                                $("#getcontent").fadeIn(
                                    400,
                                    function()
                                    {
                                        $.fancybox.close();
                                        alertMessage("success", json.response);
                                        unloading();
                                    }
                                );
                            } else {
                                unloading();
                                alertMessage("warning", json.response);
                                return false;
                            }
                            $(".submit_form").removeAttr("disabled").html("Mettre à jour");
                        }
                    );
                    return false;
                }
            );
        }
    );
';
echo $this->Html->scriptBlock($script, array('inline' => true));
?>


<div class="formEl_b">
    <?php echo $this->Form->create('Client', array('inputDefaults' => array('div' => false, 'label' => false))); ?>
        <fieldset>
            <legend> <?php echo __('Mettre à jour un client') ?> </legend>
            
            <div class="row-fluid">
                <div class="span12">
                    
                    <div class="section">
                         <label for="ClientClientActivityId">
                             <?php echo __("Secteur d'activité économique") ?> <small><?php echo __('Choisir parmi la liste') ?></small>
                         </label>
                         <div>
                            <?php
                            echo $this->Form->input('economic_activity', array(
                                'class' => 'validate[required] large',
                                'multiple',
                                'name' => 'secteur[]',
                                'selected' => $secteur,
                                'options' => Configure::read('RelationManager.ActiviteEconomique')
                            ));
                            ?>
                            <span class="f_help"><?php echo __('Obligatoire') ?></span>
                         </div>
                    </div>
                </div>
            </div>
            
            <div class="row-fluid">
                
                <div class="span8">
                    
                    <div class="section">
                         <label for="ClientName"> <?php echo __("Identification de l'entreprise") ?> <small></small></label>
                         <div>
                            <?php
                            echo $this->Form->input('forme_juridique', array(
                                'class' => 'large',
                                'options' => Configure::read('RelationManager.FormeJuridique')
                            ));
                            ?>
                         </div>
                         <div>
                            <?php echo $this->Form->input('name', array('class' => 'large', 'placeholder' => 'Dénomination')); ?>
                         </div>
                         <div>
                            <?php echo $this->Form->input('sigle', array('class' => 'large', 'placeholder' => 'Sigle usuel')); ?>
                         </div>
                    </div>
                    
                    <div class="section">
                         <label for="ClientRc">
                             <?php echo __('Régistre de commerce') ?> <small><?php echo __('Entrez le régistre de commerce') ?></small>
                         </label>
                         <div>
                            <?php echo $this->Form->input('rc', array('class' => 'medium center')); ?>
                         </div>
                    </div>
                    
                    <div class="section">
                         <label for="ClientCc">
                             <?php echo __('Compte contribuable') ?> <small><?php echo __('Entrez le compte contribuable') ?></small>
                         </label>
                         <div>
                            <?php echo $this->Form->input('cc', array('class' => 'medium center')); ?>
                         </div>
                    </div>
            
                    <div class="section last">
                        <div>
                            <a class="btn submit_form"> <?php echo __('Mettre à jour') ?> </a>
                        </div>
                    </div>
                    
                </div>
                <div class="span4">
                    <br />
                    <div>
                        <?php echo $this->Form->input('tel', array('class' => 'large center', 'placeholder' => 'Téléphone bureau', 'type' => 'text')); ?>
                    </div>
                    <div>
                        <?php echo $this->Form->input('cel', array('class' => 'large center', 'placeholder' => 'Téléphone portable')); ?>
                    </div>
                    <div>
                        <?php echo $this->Form->input('fax', array('class' => 'large center', 'placeholder' => 'Télécopie')); ?>
                    </div>
                    <hr />
                    
                    <div>
                        <?php echo $this->Form->input('email', array('class' => 'large', 'placeholder' => 'E-mail')); ?>
                    </div>
                    <hr />
                    
                    <div>
                        <?php echo $this->Form->input('adresse', array('class' => 'large', 'placeholder' => 'Adresse')); ?>
                    </div>
                </div>
            </div>
        </fieldset>
    <?php echo $this->Form->end(); ?>
</div>