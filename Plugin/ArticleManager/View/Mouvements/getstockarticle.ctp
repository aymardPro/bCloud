				<?php if (!empty($getstockarticle)) { ?>
				<table class="table">
					<thead>
						<tr>
							<th style="width: 5%">&nbsp;</th>
							<th class="left" style="width: 15%">Référence</th>
							<th class="left">Désignation</th>
							<th class="left" style="width: 15%">Qte</th>
							<th class="left" style="width: 15%">Prix d'achat unitaire</th>
                            <th style="width: 5%">&nbsp;</th>
						</tr>
					</thead>
					
					<tbody>
						<?php foreach($getstockarticle as $key => $article) { ?>
					
						<?php
						$scrpt = '
							$(document).ready(
						        function()
						        {
						        	$("#MouvementArticle'.$key.'Designation").elastic();
									$("#MouvementArticle'.$key.'PrixUnitaire").spinner({min: 0, decimals:0});
									
									$("#delMouvementArticle'.$key.'").on("click", 
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
							                   			$("#getStockArticle").load("'.$this->Html->url(array('action' => 'getstockarticle')).'");
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
                                    
                                    $("#majMouvementArticle'.$key.'").on("click", 
                                        function() {
                                            loading("Loading");
                                            var Request = $.ajax(
                                                {
                                                    url: "'.$this->Html->url(array('action' => 'updatearticle')).'",
                                                    data: {
                                                        article_id: '.$key.',
                                                        qte: $("#MouvementArticle'.$key.'Qte").val(),
                                                        prix_unitaire: $("#MouvementArticle'.$key.'PrixUnitaire").val()
                                                    },
                                                    cache: false,
                                                    type: "POST",
                                                    dataType: "json"
                                                }
                                            );
                    
                                            Request.done(function(json, status, jqXHR)
                                                {
                                                    unloading();
                                                    if (json.check == 1) {
                                                        $("#getStockArticle").load("'.$this->Html->url(array('action' => 'getstockarticle')).'");
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
				    				array('escape' => false, 'id' => 'delMouvementArticle'.$article['Article']['id'])
				    			);
								?>
							</td>
							<td>
								<?php
								echo $article['Article']['reference'];
								echo $this->Form->text(
								    'MouvementArticle.'.$key.'.article_id',
								    array('type' => 'hidden', 'value' => $article['Article']['id'])
                                )
								?>
							</td>
							<td><?php echo $article['MouvementArticle']['designation']; ?></td>
							<td class="left">
								<?php
								echo $this->Form->text(
								    'MouvementArticle.'.$key.'.qte', array(
    									'value' => $article['MouvementArticle']['qte'],
    									'style' => 'width:100px',
    									'class' => 'center',
    									'readonly'
								    )
                                )
								?>
							</td>
							<td>
								<?php
								echo $this->Form->text(
								    'MouvementArticle.'.$key.'.prix_unitaire', array(
    									'value' => $article['MouvementArticle']['prix_unitaire'],
    									'class' => 'left'
								    )
                                )
								?>
							</td>
                            <td>
                                <?php
                                echo $this->Html->link(
                                    $this->Html->image('/images/icon/coquette-icons-set/24x24/refresh.png'),
                                    'Javascript:void(0)',
                                    array('escape' => false, 'id' => 'majMouvementArticle'.$article['Article']['id'])
                                );
                                ?>
                            </td>
						</tr>
						<?php } ?>
					</tbody>
					
				</table>
				<?php } ?>