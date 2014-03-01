<div class="factureArticles form">
<?php echo $this->Form->create('FactureArticle'); ?>
	<fieldset>
		<legend><?php echo __('Add Facture Article'); ?></legend>
	<?php
		echo $this->Form->input('facture_id');
		echo $this->Form->input('article_id');
		echo $this->Form->input('designation');
		echo $this->Form->input('quantite');
		echo $this->Form->input('remise');
		echo $this->Form->input('prix_vente');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Facture Articles'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Factures'), array('controller' => 'factures', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Facture'), array('controller' => 'factures', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Articles'), array('controller' => 'articles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Article'), array('controller' => 'articles', 'action' => 'add')); ?> </li>
	</ul>
</div>
