<div class="statuts form">
<?php echo $this->Form->create('Statut'); ?>
	<fieldset>
		<legend><?php echo __('Edit Statut'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Statut.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Statut.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Statuts'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Factures'), array('controller' => 'factures', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Facture'), array('controller' => 'factures', 'action' => 'add')); ?> </li>
	</ul>
</div>
