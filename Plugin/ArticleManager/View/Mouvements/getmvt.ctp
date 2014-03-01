
<form>
    <div class="row-fluid">
        <div class="section">
            <label> Libellé<small></small></label>
            <div>
                <?php echo h(__('%s', $this->request->data['Mouvement']['name'])) ?>
            </div>
        </div>
        
        <div class="section">
            <label> Depôt départ<small></small></label>
            <div>
                <?php echo h($depots[$this->request->data['Mouvement']['depot_depart']]) ?>
            </div>
        </div>
        
        <div class="section">
            <label> Depôt arrivée<small></small></label>
            <div>
                <?php echo h($depots[$this->request->data['Mouvement']['depot_arrivee']]) ?>
            </div>
        </div>
        
        <div class="section ">
            <label> Date<small></small></label>
            <div>
                <?php echo h(__('%s', CakeTime::format('d-m-Y H:i', $this->request->data['Mouvement']['date']))) ?>
            </div>
        </div>
    </div> <br /><br />
    
    <p align="left"><label> LES DETAILS DU MOUVEMENT</label></p>
    
    <table class="table table-striped bcloud">
                    <thead>
                    <tr>
                        <th class="left">Référence</th>
                        <th class="left">Désignation</th>
                        <th class="center">Quantité</th>
                        <th width="15%" class="right">Prix d'achat unitaire</th>
                    </tr>
                  </thead>
                
                   <tbody align="center">
                    <?php foreach ($this->request->data['MouvementArticle'] as $mvtArticle): ?>
                    <tr class="odd gradeX">
                        
                        <td class="left">
                        <?php  echo ($mvtArticle['Article']['reference']);   ?>  
                        </td>    
                        
                        <td class="left">
                        <?php  echo ($mvtArticle['Article']['designation']);   ?>  
                        </td>    
                             
                          <td class="center"> 
                        <?php  echo ($mvtArticle['qte']);   ?>                             
                        </td>
                        
                        <td class="right"> 
                         <?php  echo CakeNumber::format($mvtArticle['prix_unitaire']);   ?> 
                          </td>
                        
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                </table>                                                                                                                              
        
          </div>
</form>