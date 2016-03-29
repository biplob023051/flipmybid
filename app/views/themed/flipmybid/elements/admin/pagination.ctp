<!-- Start Results Bar -->
<?php
	$paginator->options(array('url'=>Router::getParam('pass')));
?>
<div class="paging">
	<div class="totalresults">
		<strong><?php echo $paginator->counter(array('format' => 'Showing %start% - %end%</strong> (%count%)')); ?></strong>
		<nav>
			<ul class="pagination pagination-md">
				<li><?php echo $paginator->first('««', null, null, array('class' => 'start disabled')); ?></li>
				<li><?php echo $this->Paginator->prev('«', array(), null, array('class' => 'prev disabled')); ?></li>
				<?php
				echo $this->Paginator->numbers(array(
						'modulus' => 5,
						'first' => 5,
						'last' => 5,
						'separator' => '</li><li>',
						'before' => '<li>',
						'after' => '</li>'
				));
				?>
				<li><?php echo $this->Paginator->next('»', array(), null, array('class' => 'next disabled')); ?></li>
				<li><?php echo $paginator->last('»»', null, null, array('class' => 'end disabled')); ?></li>
			</ul>
		</nav>
	</div>
</div>
<!-- End Results Bar -->