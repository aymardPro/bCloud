<?php
$script = '
    $(document).ready(
        function()
        {
            $("form#ArticleEditForm").validationEngine();
            $("#ArticleDesignation").elastic().limit("200", ".limitchars");
            $("select").chosen();
            
            if ($("#ArticleStockable").is(":checked")) {
                $(".stockBlock").fadeIn();
            }
			$("#ArticleTaxable").iphoneStyle({
			    // Custom Label
			    checkedLabel: "Oui",
			    uncheckedLabel: "Non",
			    labelWidth:"40px"
			});
            
            $("#ArticleStockable").change(function(){
                if ($(this).is(":checked")) {
                    $("#ArticleStockMin").attr("value", 0);
                    $("#ArticleStockMax").attr("value", 0);
                    $("#ArticleStockSecurite").attr("value", 0);
                    $(".stockBlock").fadeIn();
                } else {
                    $(".stockBlock").fadeOut();
                }
            });
            
            $("#ArticlePrixUnitaire").spinner({min: 0, decimals:0});
            $("#ArticleMarge").spinner({min: 0, max: 100, decimals:0});
            $("#ArticleStockMin").spinner({min: 0, decimals:0});
            $("#ArticleStockMax").spinner({min: 0, decimals:0});
            $("#ArticleStockSecurite").spinner({min: 0, decimals:0});
            
             $("#wizardvalidate").smartWizard(
                {
                    transitionEffect:"slideleft",
                    onLeaveStep:leaveAStepCallback,
                    onFinish:onFinishCallback,
                    enableFinishButton:true,
                    labelNext: "Etape suivante",
                    labelPrevious: "Etape précédente",
                    labelFinish: "Valider et modifier"
                }
            );
           
            
              function leaveAStepCallback(obj) {
                    var step_num= obj.attr("rel");
                    return validateSteps(step_num);
              }
              
              function onFinishCallback() {
                   if (validateAllSteps()) {
                         $("form#ArticleEditForm").submit();
                   }
              }
            
            $("form#ArticleEditForm").on(
                "submit",
                function()
                {
                    loading("Loading");
                    $(".buttonFinish").attr("disabled", "disabled").html("Création en cours");
                    
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
                            $(".buttonFinish").removeAttr("disabled").html("Valider et modifier");
                            alertMessage("error", "Join your web admin to resolve it.");
                            return false;
                        }
                    );
                    
                    Request.done(
                        function(json, status, jqXHR)
                        {
                            $(".buttonFinish").removeAttr("disabled").html("Valider et modifier");
                            
                            if (json.check == 0) {
                                $(location).attr("href", "'.$this->Html->url(array('action' => 'view', $this->request->data['Article']['id'])).'");
                            } else {
                                unloading();
                                alertMessage("warning", json.response);
                                return false;
                            }
                        }
                    );
                    return false;
                }
            );
        }
    );
    
    function validateAllSteps()
    {
        var isStepValid = true;
        
        if (validateStep1() == false) {
            isStepValid = false;
            $("#wizardvalidate").smartWizard("setError",{stepnum:1,iserror:true});
        } else {
            $("#wizardvalidate").smartWizard("setError",{stepnum:1,iserror:false});
        }
        
        // add more if you want to validateStep 2
        if (validateStep2() == false) {
            isStepValid = false;
            $("#wizardvalidate").smartWizard("setError",{stepnum:3,iserror:true});
        } else {
            $("#wizardvalidate").smartWizard("setError",{stepnum:3,iserror:false});
        }
        
        if (validateStep3() == false) {
            isStepValid = false;
            $("#wizardvalidate").smartWizard("setError",{stepnum:3,iserror:true});
        } else {
            $("#wizardvalidate").smartWizard("setError",{stepnum:3,iserror:false});
        }
        
        if(!isStepValid){
            $("#wizardvalidate").smartWizard("showMessage","Renseignez les champs requis avant de poursuivre.");
        }
        
        return isStepValid;
    }
    
    function validateSteps(step)
    {
        var isStepValid = true;
        
        // validate step 1
        if (step == 1) {
            if (validateStep1() == false ) {
                isStepValid = false;
                $("#wizardvalidate").smartWizard("showMessage","Renseignez les champs requis à l\'étape "+step+ " et allez à l\'étape suivante.");
                $("#wizardvalidate").smartWizard("setError",{stepnum:step,iserror:true});
            } else {
                $("#wizardvalidate").smartWizard("setError",{stepnum:step,iserror:false});
            }
        }
        
        // validate step 2
        if (step == 2) {
            if(validateStep2() == false ) {
                isStepValid = false;
                $("#wizardvalidate").smartWizard("showMessage","Renseignez les champs requis à l\'étape "+step+ " et allez à l\'étape suivante.");
                $("#wizardvalidate").smartWizard("setError",{stepnum:step,iserror:true});
            } else {
                $("#wizardvalidate").smartWizard("setError",{stepnum:step,iserror:false});
            }
        }
        
        // validate step3
        if (step == 3) {
            
            if (validateStep3() == false ) {
                isStepValid = false;
                $("#wizardvalidate").smartWizard("showMessage","Renseignez les champs requis à l\'étape "+step+ " et allez à l\'étape suivante.");
                $("#wizardvalidate").smartWizard("setError",{stepnum:step,iserror:true});
            } else {
                $("#wizardvalidate").smartWizard("setError",{stepnum:step,iserror:false});
            }
        }
        
        return isStepValid;
    }
    
    function validateStep1()
    {
        var isValid = true;
        return isValid;
    }
    
    function validateStep2()
    {
        var isValid = true;
        return isValid;
    }
    
    function validateStep3()
    {
        var isValid = true;
        return isValid;
    }
';
echo $this->Html->scriptBlock($script, array('inline' => false));
?>

<!-- row-fluid -->
<div class="row-fluid">
    <!-- Table widget -->
    <div class="widget span12 clearfix">
        <div class="widget-header">
            <span><i class="icon-table"></i> <?php echo __('Gestion des articles') ?> </span>
        </div><!-- End widget-header -->
        
        <div class="widget-content">
            
            <div class="row-fluid">
                <h2><?php echo __('FORMULAIRE'); ?></h2>
                <hr />
                
                <div class="btn-group pull-top-right btn-square">
                    <a class="btn btn-large" href="javascript:void(0)" id="back"><i class="icon-remove"></i></a>
                </div>
                
                <?php echo $this->Form->create('Article', array('inputDefaults' => array('div' => false, 'label' => false))); ?>
                
                <input type="hidden" name="issubmit" value="1">
                
                <!-- Smart Wizard -->
                <div id="wizardvalidate" class="swMain">
                    <ul>
            <li>
                <a href="#step-1">
                    <label class="stepNumber">1</label>
                    <span class="stepDesc">
                        Article <br />
                        <small>informations générales</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-2">
                    <label class="stepNumber">2</label>
                    <span class="stepDesc">
                        Tarifs <br />
                        <small>informations sur les tarifs</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-3">
                    <label class="stepNumber">3</label>
                    <span class="stepDesc">
                        Stock <br />
                        <small>gestion du stock</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="#step-4">
                    <label class="stepNumber">4</label>
                    <span class="stepDesc">
                        Fournisseur <br />
                        <small>Informations fournisseurs</small>
                    </span>
                </a>
            </li>
                    </ul>
                    
                    <div id="step-1" style="width:100%; height: auto">
                        <h2 class="StepTitle">&Eacute;tape 1: Informations générales</h2>
                        <hr />
                        
                        <div class="section">
                                     <label for="ArticleArticleFamilleId">
                                         <?php echo __('Famille') ?> <small><?php echo __('Choisir parmi la liste') ?></small>
                                     </label>
                                     <div>
                                        <?php echo $this->Form->input('article_famille_id', array('class' => 'large')); ?>
                                     </div>
                                </div>
                                
                                <div class="section">
                                     <label for="ArticleReference">
                                         <?php echo __('Référence') ?> <small><?php echo __("Entrez la référence ou le code de l'article") ?></small>
                                     </label>
                                     <div>
                                        <?php echo $this->Form->input('reference', array('class' => 'large upper', 'readonly')); ?>
                                     </div>
                                </div>
                                
                                <div class="section">
                                     <label for="ArticleUniteId">
                                         <?php echo __('Unité de vente') ?> <small><?php echo __('Choisir parmi la liste') ?></small>
                                     </label>
                                     <div>
                                        <?php echo $this->Form->input('unite_id', array('class' => 'large')); ?>
                                     </div>
                                </div>
                                
                                <div class="section">
                                     <label for="ArticleDesignation">
                                         <?php echo __('Désignation') ?> <small><?php echo __('Entrez la désignation') ?></small>
                                     </label>
                                     <div>
                                        <?php echo $this->Form->input('designation', array('class' => 'large', 'type' => 'textarea')); ?>
                                        <span class="f_help"><?php echo __('Caractères restant ') ?><span class="limitchars">200</span></span>
                                     </div>
                                </div>
                                
                                <div class="section">
                                     <label for="ArticleCodeBarre"> <?php echo __('Code barre') ?> <small><?php echo __('') ?></small></label>
                                     <div>
                                        <?php echo $this->Form->input('code_barre', array('class' => 'large')); ?>
                                     </div>
                                </div>
                    
                    <div class="section">
                         <label for="ArticleTaxable"> <?php echo __('Appliquer la taxe?') ?></label>
                         <div>
                            <?php echo $this->Form->input('taxable', array('type' => 'checkbox')); ?>
                         </div>
                    </div>
                    
                    </div>
                    
                    <div id="step-2" style="width:100%; height: auto">
                        <h2 class="StepTitle">&Eacute;tape 2: Tarifs</h2>
                        <hr />
                        
                                <div class="section">
                                     <label for="ArticlePrixUnitaire"> <?php echo __("Prix unitaire") ?> <small></small></label>
                                     <div>
                                        <?php echo $this->Form->input('prix_unitaire', array('class' => 'large center', 'type' => 'text')); ?>
                                     </div>
                                </div>
                                
                                <div class="section">
                                     <label for="ArticleMarge"> <?php echo __('Marge') ?> 
                                         <small><?php echo __('Entrez la marge en %') ?></small>
                                     </label>
                                     
                                     <div>
                                        <?php echo $this->Form->input('marge', array('class' => 'large center', 'type' => 'text')); ?>
                                     </div>
                                </div>
                                
                    </div>
                    
                    <div id="step-3" style="width:100%; height: auto">
                        <h2 class="StepTitle">&Eacute;tape 3: Stock</h2>
                        <hr />
                                
                                <div class="section">
                                     <!--<label for="ArticleInStock"> <?php echo __('Gérer en stock?') ?> <small><?php echo __('') ?></small></label>-->
                                     <div>
                                         
                                         <div class="checksquared">
                                            <?php echo $this->Form->input('stockable', array('type' => 'checkbox', 'value' => 1)); ?>
                                            <label for="ArticleStockable" title="Gérer en stock"></label>
                                         </div>
                                     </div>
                                </div>
                                
                                <div class="stockBlock" style="display: none">
                                    
                                    <div class="section">
                                         <label for="ArticleStockMin">
                                             <?php echo __('Stock min') ?>
                                             <small><?php echo __('Niveau qui déclanche une commande') ?></small>
                                         </label>
                                         
                                         <div>
                                            <?php echo $this->Form->input('stock_min', array('class' => 'large center', 'type' => 'text')); ?>
                                         </div>
                                    </div>
                                    
                                    <div class="section">
                                         <label for="ArticleStockMax">
                                             <?php echo __('Stock max') ?>
                                             <small><?php echo __("Niveau qu'il ne faut sutout pas dépasser") ?></small>
                                         </label>
                                         
                                         <div>
                                            <?php echo $this->Form->input('stock_max', array('class' => 'large center', 'type' => 'text')); ?>
                                         </div>
                                    </div>
                                    
                                    <div class="section">
                                         <label for="ArticleStockSecurite">
                                             <?php echo __('Stock de sécurité') ?>
                                             <small><?php echo __('Niveau qui évite la rupture de stock') ?></small>
                                         </label>
                                         
                                         <div>
                                            <?php echo $this->Form->input('stock_securite', array('class' => 'large center', 'type' => 'text')); ?>
                                         </div>
                                    </div>
                                    
                                </div>
                                
                    </div>
                    
                    <div id="step-4" style="width:100%; height: auto">
                        <h2 class="StepTitle">&Eacute;tape 4: Fournisseur</h2>
                        <hr />
                    </div>
                </div><!-- End SmartWizard Content -->
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
</div>