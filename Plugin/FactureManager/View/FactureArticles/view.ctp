<div class="factureArticles view">
<h2><?php echo __('Facture Article'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($factureArticle['FactureArticle']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Facture'); ?></dt>
		<dd>
			<?php echo $this->Html->link($factureArticle['Facture']['name'], array('controller' => 'factures', 'action' => 'view', $factureArticle['Facture']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Article'); ?></dt>
		<dd>
			<?php echo $this->Html->link($factureArticle['Article']['name'], array('controller' => 'articles', 'action' => 'view', $factureArticle['Article']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Designation'); ?></dt>
		<dd>
			<?php echo h($factureArticle['FactureArticle']['designation']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Quantite'); ?></dt>
		<dd>
			<?php echo h($factureArticle['FactureArticle']['quantite']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Remise'); ?></dt>
		<dd>
			<?php echo h($factureArticle['FactureArticle']['remise']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Prix Vente'); ?></dt>
		<dd>
			<?php echo h($factureArticle['FactureArticle']['prix_vente']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($factureArticle['FactureArticle']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($factureArticle['FactureArticle']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Facture Article'), array('action' => 'edit', $factureArticle['FactureArticle']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Facture Article'), array('action' => 'delete', $factureArticle['FactureArticle']['id']), null, __('Are you sure you want to delete # %s?', $factureArticle['FactureArticle']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Facture Articles'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Facture Article'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Factures'), array('controller' => 'factures', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Facture'), array('controller' => 'factures', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Articles'), array('controller' => 'articles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Article'), array('controller' => 'articles', 'action' => 'add')); ?> </li>
	</ul>
</div>
