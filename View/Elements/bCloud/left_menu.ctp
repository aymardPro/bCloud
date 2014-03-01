<div id="left_menu" style="position: fixed;">
	
	<ul id="main_menu" class="main_menu">
		
		<?php
		$select = 'select';
		
		$dashboard = (($this->request->params['controller']==='pages') && ($this->request->params['pass'][0] === 'home')) ? $select:'';
		$dashboard_link = $this->Html->url(array('controller' => 'pages', 'action' => 'display', 'home', 'plugin' => false, 'admin' => false));
		
		$dico = (($this->request->params['controller']==='pages') && ($this->request->params['pass'][0] === 'dico')) ? $select:'';
		$dico_link = $this->Html->url(array('controller' => 'pages', 'action' => 'display', 'dico', 'plugin' => false, 'admin' => false));
		
		$gestion = (($this->request->params['controller']==='users') || ($this->request->params['controller']==='clients')) ? $select:'';
		$gestion_link = $this->Html->url(array('controller' => 'users', 'action' => 'index', 'plugin' => false, 'admin' => false));
		?>
		
		<li class="<?php echo $dashboard; ?>">
			<a href="<?php echo $dashboard_link; ?>">
				<span class="ico gray shadow home"></span>
				<b><?php echo __('Dashboard'); ?></b>
			</a>
		</li>
        
        <li class="<?php echo $dico; ?>">
            <a href="<?php echo $dico_link; ?>">
                <span class="ico gray shadow paragraph_align_left"></span>
                <b><?php echo __('Dictionnaire'); ?></b>
            </a>
        </li>
        
        <li class="<?php echo $gestion; ?>">
            <a href="Javascript:void(0)">
                <span class="ico gray shadow group"></span>
                <b><?php echo __('Gestion'); ?></b>
            </a>
            
            <ul>
            	<li>
            		<a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'index', 'plugin' => false, 'admin' => false)) ?>">
                        Utilisateurs
                    </a>
            	</li>
            	<li>
            		<a href="<?php echo $this->Html->url(array('controller' => 'clients', 'action' => 'index', 'plugin' => 'relation_manager', 'admin' => false)) ?>">
                        Clients
                    </a>
            	</li>
            	<li>
            		<a href="<?php echo $this->Html->url(array('controller' => 'fournisseurs', 'action' => 'index', 'plugin' => 'relation_manager', 'admin' => false)) ?>">
                        Fournisseurs
                    </a>
            	</li>
            </ul>
        </li>
        
		<li class="<?php if (in_array($this->request->params['controller'], array('articles', 'article_familles', 'unites'))) echo 'select'; ?>">
			<a href="<?php echo $this->Html->url(array('controller' => 'articles', 'action' => 'index', 'plugin' => 'article_manager', 'admin' => false)) ?>">
				<span class="ico gray shadow item"></span>
				<b>Articles</b>
			</a>
		</li>
		
		<li class="<?php if (in_array($this->request->params['controller'], array('mouvements', 'depots'))) echo 'select'; ?>">
			<a href="<?php echo $this->Html->url(array('controller' => 'mouvements', 'action' => 'index', 'plugin' => 'article_manager', 'admin' => false)) ?>">
				<span class="ico gray shadow sphere"></span>
				<b>Stocks</b>
			</a>
		</li>
		
		<!--
        <li class="<?php if (in_array($this->request->params['controller'], array('factures', 'taxes', 'paiements', 'statuts'))) echo 'select'; ?>">
            <a href="<?php echo $this->Html->url(array('controller' => 'factures', 'action' => 'index', 'plugin' => 'facture_manager')) ?>">
                <span class="ico gray shadow money_bag"></span>
                <b>Factures</b>
            </a>
        </li>
       -->
       
        <li class="<?php if (in_array($this->request->params['controller'], array('proformas', 'proforma_statuts'))) echo 'select'; ?>">
            <a href="<?php echo $this->Html->url(array('controller' => 'proformas', 'action' => 'index', 'plugin' => 'facture_manager')) ?>">
                <span class="ico gray shadow money_bag"></span>
                <b>Proformas</b>
            </a>
        </li>
                    </ul>
               </div>