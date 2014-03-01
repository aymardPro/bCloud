<div class="factureArticles index">
	<h2><?php echo __('Facture Articles'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('facture_id'); ?></th>
			<th><?php echo $this->Paginator->sort('article_id'); ?></th>
			<th><?php echo $this->Paginator->sort('designation'); ?></th>
			<th><?php echo $this->Paginator->sort('quantite'); ?></th>
			<th><?php echo $this->Paginator->sort('remise'); ?></th>
			<th><?php echo $this->Paginator->sort('prix_vente'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($factureArticles as $factureArticle): ?>
	<tr>
		<td><?php echo h($factureArticle['FactureArticle']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($factureArticle['Facture']['name'], array('controller' => 'factures', 'action' => 'view', $factureArticle['Facture']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($factureArticle['Article']['name'], array('controller' => 'articles', 'action' => 'view', $factureArticle['Article']['id'])); ?>
		</td>
		<td><?php echo h($factureArticle['FactureArticle']['designation']); ?>&nbsp;</td>
		<td><?php echo h($factureArticle['FactureArticle']['quantite']); ?>&nbsp;</td>
		<td><?php echo h($factureArticle['FactureArticle']['remise']); ?>&nbsp;</td>
		<td><?php echo h($factureArticle['FactureArticle']['prix_vente']); ?>&nbsp;</td>
		<td><?php echo h($factureArticle['FactureArticle']['created']); ?>&nbsp;</td>
		<td><?php echo h($factureArticle['FactureArticle']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $factureArticle['FactureArticle']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $factureArticle['FactureArticle']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $factureArticle['FactureArticle']['id']), null, __('Are you sure you want to delete # %s?', $factureArticle['FactureArticle']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Facture Article'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Factures'), array('controller' => 'factures', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Facture'), array('controller' => 'factures', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Articles'), array('controller' => 'articles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Article'), array('controller' => 'articles', 'action' => 'add')); ?> </li>
	</ul>
</div>
