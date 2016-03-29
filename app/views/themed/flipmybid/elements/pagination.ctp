<!-- Start Results Bar -->
<?php
	$paginator->options(array('url'=>Router::getParam('pass')));
?>
<div class="paging">
	<div class="totalresults">
		<strong><?php echo $paginator->counter(array('format' => 'Showing %start% - %end%</strong> (%count%)')); ?></strong>
	</div>
	<div class="pagenumber">
		<ul>
			<?php if($paginator->hasPrev()) : ?>
				<li><?php echo $paginator->first('<< Start ', null, null, array('class' => 'disabled')); ?></li>
				<li><?php echo $paginator->prev('<< Prev ', null, null, array('class' => 'disabled')); ?></li>
			<?php endif; ?>

			<?php if (is_string($paginator->numbers())): ?>
				<?php echo $paginator->numbers(array('separator' => '</li><li>', 'before' => '<li>', 'after' => '</li>'));?>
			<?php endif; ?>

			<?php if($paginator->hasNext()): ?>
				<li><?php echo $paginator->next(' Next >>', null, null, array('class' => 'disabled')); ?></li>
				<li><?php echo $paginator->last(' End >>', null, null, array('class' => 'disabled')); ?></li>
			<?php endif; ?>
		</ul>
	</div>
</div>

<div class="clearfix"></div>
<!-- End Results Bar -->