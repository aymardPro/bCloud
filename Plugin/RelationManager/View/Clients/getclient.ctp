<?php
$script = '
    $(document).ready(
        function()
        {
            $("#refresh").on("click", getClient);
            $("#edit").on("click", Edit);
        }
    );
    
    function hideAlert()
    {
        $(this).stop(true, true).animate({ opacity: 0,right: "-20" }, 500, function() { $(this).hide(); });
    }
    
    function getClient()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load
        (
            "'.$this->Html->url(array('action' => 'getclient', $this->request->params['pass'][0])).'",
            function() { unloading(); }
        ).fadeIn(400);
    }
    
    function Edit()
    {
        alertHide();
        loading("Loading");
        $("#getcontent").load(
            "'.$this->Html->url(array("action" => "edit", $this->request->params['pass'][0])).'", function() { unloading(); }
        ).fadeIn(400);
    }
';
echo $this->Html->scriptBlock($script, array('inline' => true));
?>


<div class="btn-group pull-top-right btn-square">
    <a class="btn btn-large" href="javascript:void(0)" id="refresh">
        <i class="icon-refresh"></i> 
    </a>
    <a class="btn btn-large" href="javascript:void(0)" id="edit">
        <i class="icon-edit"></i> 
    </a>
    <a class="btn btn-large" href="<?php echo $this->Html->url(array('action' => 'index')) ?>">
        <i class="icon-home"></i> 
    </a>
</div>

<form>
						<div class="span4">
							<div class="profileSetting">
								<div class="avartar">
									<?php echo $this->Html->image('/images/icon/coquette-icons-set/128x128/home.png', array('width' => 180)); ?>
								</div>
							</div>
							<hr/>
						</div>
							
						<div class="span8">
							<div class="section ">
								<label> Secteur d'activité économique<small></small></label>
                            <div>
                            <?php
                            foreach ($eco_s as $key => $value) {
                                echo '<h5>'.$key.'</h5>';
                                echo '<ul>';
                                
                                foreach ($value as $k => $v) {
                                    echo '<li>'.$v.'</li>';
                                }
                                echo '</ul>';
                            }
                            ?><br />
						    </div>
							</div>
								
							<div class="section">
								<label> Identification de l'entreprise  <small></small></label>
								<div>
									<span class="f_help"> Dénomination</span>
									<?php echo h(__('%s', $this->request->data['Client']['name'])) ?>
								</div>
								<div>
                                    <span class="f_help"> Sigle usuel</span>
                                    <?php echo h(__('%s', $this->request->data['Client']['sigle'])) ?>
                                </div>
							</div>
                                                                                                                
                            <div class="section">
                                <label> Fiscalité<small></small></label>
                                
                                <div>
                                    <span class="f_help"> Régistre de commerce</span>
                                    <?php echo h(__('%s', $this->request->data['Client']['rc'])) ?>
                                </div>
                                <div>
                                    <span class="f_help"> Compte contribuable</span>
                                    <?php echo h(__('%s', $this->request->data['Client']['cc'])) ?>
                                </div>
                            </div>
                                                                                                                
                            <div class="section">
                                <label> Téléphones<small></small></label>
                                
                                <div>
                                    <span class="f_help"> Bureau</span>
                                    <?php echo h(__('%s', $this->request->data['Client']['tel'])) ?>
                                </div>
                                <div>
                                    <span class="f_help"> Portable</span>
                                    <?php echo h(__('%s', $this->request->data['Client']['cel'])) ?>
                                </div>
                                <div>
                                    <span class="f_help"> Télécopie</span>
                                    <?php echo h(__('%s', $this->request->data['Client']['fax'])) ?>
                                </div>
                            </div>
                                                                                                                
                            <div class="section">
                                <label> Adresse<small></small></label>
                                
                                <div>
                                    <span class="f_help"> Adresse</span>
                                    <?php echo h(__('%s', $this->request->data['Client']['adresse'])) ?>
                                </div>
                                <div>
                                    <span class="f_help"> E-mail</span>
                                    <?php echo h(__('%s', $this->request->data['Client']['email'])) ?>
                                </div>
                            </div>
                                                                                                                
                            <div class="section">
                                <label> Date de création<small></small></label>
                                <div><?php echo CakeTime::format('d-m-Y H:i', $this->request->data['Client']['created']); ?></div>
                            </div>
						</div>
					</form>