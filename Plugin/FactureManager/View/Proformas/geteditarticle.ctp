<?php if (!empty($this->request->data)) { ?>
				<table class="table">
					<thead>
						<tr>
                            <th>&nbsp;</th>
                            <th>Référence</th>
                            <th>Désignation</th>
                            <th class="left">Qte</th>
                            <th class="left">Remise (%)</th>
                            <th class="left">Prix de vente U. HT</th>
                            <th width="8%">Taxe?</th>
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
						        	$("#ProformaArticle'.$key.'Designation").elastic();
									$("#ProformaArticle'.$key.'Remise").spinner({min: 0, max:100, stepping: 1, decimals:0});
									$("#ProformaArticle'.$key.'PrixVente").spinner({min: '.$article['ProformaArticle']['prix_vente'].', decimals:0});
									
									$("#delProformaArticle'.$key.'").on("click", 
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
											
									$("#majProformaArticle'.$key.'").on("click", 
										function() {
										    loading("Loading");
											var Request = $.ajax(
												{
													url: "'.$this->Html->url(array('action' => 'updatearticle')).'",
													data: {
														article_id: '.$key.',
														qte: $("#ProformaArticle'.$key.'Qte").val(),
														designation: $("#ProformaArticle'.$key.'Designation").val(),
														remise: $("#ProformaArticle'.$key.'Remise").val(),
														prix_vente: $("#ProformaArticle'.$key.'PrixVente").val(),
														taxable: $("#ProformaArticle'.$key.'Taxable").val(),
                                                        status: $("#editstatus").val()
													},
													cache: false,
													type: "POST",
													dataType: "json"
												}
											);
                    
							                Request.done(function(json, status, jqXHR)
							                   	{
							                   		if (json.check > 0) {
							                   			unloading();
														alertMessage("warning", json.response);
													} else {
                                                        $("#getArticle").load("'.$this->Html->url(array('action' => 'geteditarticle')).'",
															function()
															{
																unloading();
															});
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
                                    array('escape' => false, 'id' => 'delProformaArticle'.$article['Article']['id'])
                                );
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $article['Article']['reference'];
                                echo $this->Form->text('ProformaArticle.'.$key.'.article_id', array('type' => 'hidden', 'value' => $article['Article']['id']))
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Form->textarea('ProformaArticle.'.$key.'.designation', array(
                                    'value' => $article['ProformaArticle']['designation'],
                                    'style' => 'width:300px; min-height: 18px !important;',
                                    'rows' => 1
                                ))
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $article['ProformaArticle']['qte'];
                                echo $this->Form->hidden('ProformaArticle.'.$key.'.qte', array(
                                    'value' => $article['ProformaArticle']['qte']
                                ));
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Form->text('ProformaArticle.'.$key.'.remise', array(
                                    'value' => $article['ProformaArticle']['remise'],
                                    'style' => 'width:100px',
                                    'class' => 'center'
                                ))
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Form->text('ProformaArticle.'.$key.'.prix_vente', array(
                                    'value' => $article['ProformaArticle']['prix_vente'],
                                    'style' => 'width:100px',
                                    'class' => 'center'
                                ))
                                ?>
                            </td>
                            <td>
                            	<?php
                            	echo ($article['Article']['taxable']) ? 'Oui':'Non';
								echo $this->Form->hidden('ProformaArticle.'.$key.'.taxable', array('value' => (int) $article['Article']['taxable']));
                            	?>
                            </td>
                            <td>
                                <?php
                                echo $this->Html->link(
                                    $this->Html->image('/images/icon/coquette-icons-set/24x24/refresh.png'),
                                    'Javascript:void(0)',
                                    array('escape' => false, 'id' => 'majProformaArticle'.$article['Article']['id'])
                                );
                                ?>
                            </td>
                        </tr>
						<?php } ?>
					</tbody>
					
					<tfoot>
						<tr>
							<td colspan="7" class="right">Total HT</td>
							<td>
							    <?php echo CakeNumber::format($this->requestAction(array('action' => 'get_montant_total'))); ?>
							</td>
						</tr>
					</tfoot>
					
				</table>
				<?php } ?>