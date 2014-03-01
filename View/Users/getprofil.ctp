<form>
						<div class="span4">
							<div class="profileSetting">
								<div class="avartar">
									<?php echo $this->Html->image('/images/icon/coquette-icons-set/128x128/image.png', array('width' => 180)); ?>
								</div>
							</div>
							<hr/>
						</div>
							
						<div class="span8">
							<div class="section ">
								<label> Nom &amp; prénoms<small></small></label>
								<div><?php echo h(__('%s %s', $this->request->data['User']['nom'], $this->request->data['User']['prenoms'])) ?></div>
							</div>
								
							<div class="section">
								<label> Infos Compte  <small></small></label>
								<div>
									<span class="f_help"> Nom d'utilisateur.</span>
									<?php echo h(__('%s', $this->request->data['User']['email'])) ?>
								</div>
								
								<div>
									<span class="f_help"> Groupe d'utilisateur.</span>
									<?php echo h(__('%s', $this->request->data['Group']['name'])) ?>
								</div>
								
								<div>
									<span class="f_help"> Compte associé.</span>
									<?php echo h(__('%s', $this->request->data['Account']['name'])) ?>
								</div>
								
								<?php if (AuthComponent::user('id')===$this->request->data['User']['id']): ?>
								<div>
									<span class="f_help"> *** Mot de passa masqué ***. <br />
										<?php echo $this->Html->link('Réinitialiser mon mot de passe', '') ?>
									</span>
								</div>
								<?php endif; ?>
							</div>
								
							<div class="section ">
								<label> Dernière visite<small></small></label>
								<div>
									<?php
									echo (is_null($this->request->data['User']['lastvisite'])) ?
										__('Jamais connecté.') : CakeTime::timeAgoInWords($this->request->data['User']['lastvisite']);
									?>
								</div>
							</div>
								
							<div class="section ">
								<label> Date de création<small></small></label>
								<div><?php echo CakeTime::format('d-m-Y H:i', $this->request->data['User']['created']); ?></div>
							</div>
						</div>
					</form>