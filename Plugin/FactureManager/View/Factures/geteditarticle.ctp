<?php if (!empty($this->request->data)) { ?>
				<table class="table">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th>Référence</th>
							<th>Désignation</th>
							<th class="center">Qte</th>
							<th class="center">Remise (%)</th>
							<th class="center">Prix de vente U. HT</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					
					<tbody>
						<?php foreach($this->request->data as $key => $article) { ?>
					
						<?php
						$scrpt = '
							$(document).ready(
						        function()
						        {
						        	$("#FactureArticle'.$key.'Designation").elastic();
									$("#FactureArticle'.$key.'Remise").spinner({min: 0, max:100, stepping: 1, decimals:0});
									$("#FactureArticle'.$key.'Qte").spinner({min: 1, stepping: 1, decimals:0});
									$("#FactureArticle'.$key.'PrixVente").spinner({min: 0, decimals:0});
									
									$("#delFactureArticle'.$key.'").on("click", 
										function() {
										    loading("Loading");
											var Request = $.ajax(
												{
													url: "'.$this->Html->url(array('action' => 'deletearticle')).'",
													data: { article_id: '.$key.' },
													cache: false,
													type: "POST",
													dataType: "json"
												}
											);
                    
							                Request.done(function(json, status, jqXHR)
							                   	{
							                   	    unloading();
							                   		if (json.check == 1) {
							                   			$("#getArticle").load("'.$this->Html->url(array('action' => 'geteditarticle')).'");
													} else {
														alertMessage("warning", json.response);
													}
												}
											);
													
											Request.fail(function(jqXHR, textStatus, errorThrown)
												{
												    unloading();
													alertMessage("error", "Error.");
													return false;
												}
											);
										}
									);
											
									$("#majFactureArticle'.$key.'").on("click", 
										function() {
										    loading("Loading");
											var Request = $.ajax(
												{
													url: "'.$this->Html->url(array('action' => 'updatearticle')).'",
													data: {
														article_id: '.$key.',
														qte: $("#FactureArticle'.$key.'Qte").val(),
														designation: $("#FactureArticle'.$key.'Designation").val(),
														remise: $("#FactureArticle'.$key.'Remise").val(),
														prix_vente: $("#FactureArticle'.$key.'PrixVente").val(),
                                                        status: $("#editstatus").val()
													},
													cache: false,
													type: "POST",
													dataType: "json"
												}
											);
                    
							                Request.done(function(json, status, jqXHR)
							                   	{
							                   	    unloading();
							                   		if (json.check > 0) {
														alertMessage("warning", json.response);
													} else {
                                                        $("#getArticle").load("'.$this->Html->url(array('action' => 'geteditarticle')).'");
													}
												}
											);
													
											Request.fail(function(jqXHR, textStatus, errorThrown)
												{
												    unloading();
													alertMessage("error", "Error.");
													return false;
												}
											);
                    
										}
									)
								}
							);
						';
						echo $this->Html->scriptBlock($scrpt, array('inline' => true));
						?>
						<tr>
							<td>
								<?php
								echo $this->Html->link(
				    				$this->Html->image('/images/icon/coquette-icons-set/16x16/delete.png'),
				    				'Javascript:void(0)',
				    				array('escape' => false, 'id' => 'delFactureArticle'.$article['Article']['id'])
				    			);
								?>
							</td>
							<td>
								<?php
								echo $article['Article']['reference'];
								echo $this->Form->text('FactureArticle.'.$key.'.article_id', array('type' => 'hidden', 'value' => $article['Article']['id']))
								?>
							</td>
							<td>
								<?php
								echo $this->Form->textarea('FactureArticle.'.$key.'.designation', array(
									'value' => $article['FactureArticle']['designation'],
									'style' => 'width:200px; min-height: 18px !important;',
									'rows' => 1
								))
								?>
							</td>
							<td>
								<?php
								echo $this->Form->text('FactureArticle.'.$key.'.qte', array(
									'value' => $article['FactureArticle']['qte'],
									'style' => 'width:100px',
									'class' => 'center'
								))
								?>
							</td>
							<td>
								<?php
								echo $this->Form->text('FactureArticle.'.$key.'.remise', array(
									'value' => $article['FactureArticle']['remise'],
									'style' => 'width:100px',
									'class' => 'center'
								))
								?>
							</td>
							<td>
								<?php
								echo $this->Form->text('FactureArticle.'.$key.'.prix_vente', array(
									'value' => $article['FactureArticle']['prix_vente'],
									'style' => 'width:100px',
									'class' => 'center'
								))
								?>
							</td>
							<td>
								<?php
								echo $this->Html->link(
				    				$this->Html->image('/images/icon/coquette-icons-set/24x24/refresh.png'),
				    				'Javascript:void(0)',
				    				array('escape' => false, 'id' => 'majFactureArticle'.$article['Article']['id'])
				    			);
								?>
							</td>
						</tr>
						<?php } ?>
					</tbody>
					
					<tfoot>
						<tr>
							<td colspan="6" class="right">Total HT</td>
							<td>
							    <?php echo CakeNumber::format($this->requestAction(array('action' => 'get_montant_total'))); ?>
							</td>
						</tr>
					</tfoot>
					
				</table>
				<?php } ?>