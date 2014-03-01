<div class="row-fluid tb-foot">
	<div class="span4">
		<div class="dataTables_info">
			<?php echo $this->Paginator->counter('Affichage {:start} à {:end}, Total {:count}, Page {:page}/{:pages}') ?>
		</div>
	</div>
	
	<div class="span8">
		<div class="dataTables_paginate paging_bootstrap pagination">
			<ul>
				<?php
					echo $this->Paginator->prev(
						'← Préc',
						array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'prev disabled')
					);
					echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentClass' => 'active', 'currentTag' => 'a'));
					echo $this->Paginator->next(
						'Suiv →',
						array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'next disabled')
					);
				?>
			</ul>
		</div>
	</div>
</div>