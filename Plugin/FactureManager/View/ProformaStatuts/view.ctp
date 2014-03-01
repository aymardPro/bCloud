<div class="statuts view">
<h2><?php echo __('Statut'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($statut['Statut']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($statut['Statut']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($statut['Statut']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($statut['Statut']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Statut'), array('action' => 'edit', $statut['Statut']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Statut'), array('action' => 'delete', $statut['Statut']['id']), null, __('Are you sure you want to delete # %s?', $statut['Statut']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Statuts'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Statut'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Factures'), array('controller' => 'factures', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Facture'), array('controller' => 'factures', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Factures'); ?></h3>
	<?php if (!empty($statut['Facture'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Client Id'); ?></th>
		<th><?php echo __('Reference'); ?></th>
		<th><?php echo __('Date'); ?></th>
		<th><?php echo __('Statut Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Paiement Id'); ?></th>
		<th><?php echo __('Garantie'); ?></th>
		<th><?php echo __('Remise'); ?></th>
		<th><?php echo __('Tva Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($statut['Facture'] as $facture): ?>
		<tr>
			<td><?php echo $facture['id']; ?></td>
			<td><?php echo $facture['user_id']; ?></td>
			<td><?php echo $facture['client_id']; ?></td>
			<td><?php echo $facture['reference']; ?></td>
			<td><?php echo $facture['date']; ?></td>
			<td><?php echo $facture['statut_id']; ?></td>
			<td><?php echo $facture['name']; ?></td>
			<td><?php echo $facture['paiement_id']; ?></td>
			<td><?php echo $facture['garantie']; ?></td>
			<td><?php echo $facture['remise']; ?></td>
			<td><?php echo $facture['tva_id']; ?></td>
			<td><?php echo $facture['created']; ?></td>
			<td><?php echo $facture['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'factures', 'action' => 'view', $facture['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'factures', 'action' => 'edit', $facture['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'factures', 'action' => 'delete', $facture['id']), null, __('Are you sure you want to delete # %s?', $facture['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Facture'), array('controller' => 'factures', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
