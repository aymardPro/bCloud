<form>
						<div class="span4">
							<div class="profileSetting">
								<div class="avartar">
									<?php echo $this->Html->image('/images/icon/coquette-icons-set/128x128/laptop.png', array('width' => 180)); ?>
								</div>
							</div>
							<hr/>
						</div>
							
						<div class="span8">
							<div class="section ">
								<label> Famille Article<small></small></label>
						      <div>
                            <?php echo __('%s', $centralisateurs[$this->request->data['ArticleFamille']['parent']]); ?><br />
                            <?php echo __('%s', $this->request->data['ArticleFamille']['name']); ?>
						    </div>
							</div>
								
							<div class="section">
								<label> Infos Article  <small></small></label>
								<div>
									<span class="f_help"> Reférence</span>
									<?php echo h(__('%s', $this->request->data['Article']['reference'])) ?>
								</div>
								<div>
                                    <span class="f_help"> Désignation</span>
                                    <?php echo h(__('%s', $this->request->data['Article']['designation'])) ?>
                                </div>
							</div>
                                                                                                                
                            <div class="section">
                                <label> Prix<small></small></label>
                                
                                <div>
                                    <span class="f_help"> Prix d'acchat unitaire</span>
                                    <?php echo CakeNumber::format($this->request->data['Article']['prix_unitaire']) ?>
                                </div>
                                <div>
                                    <span class="f_help"> Marge</span>
                                    <?php echo $this->request->data['Article']['marge']. '%' ?>
                                </div>
                                <div>
                                    <span class="f_help"> Prix de vente unitaire</span>
                                    <?php echo CakeNumber::format($this->requestAction(array('action' => 'getPrixVente', $this->request->data['Article']['id']))) ?>
                                </div>
                            </div>
                                                                                                                
                            <div class="section">
                                <label> Date de création<small></small></label>
                                <div><?php echo CakeTime::format('d-m-Y H:i', $this->request->data['Article']['created']); ?></div>
                            </div>
						</div>
					</form>