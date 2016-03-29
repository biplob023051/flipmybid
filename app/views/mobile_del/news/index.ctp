<?php echo $this->element('banners'); ?>

<div id="content_top"></div>
<div id="content_bg">
<div class="boxed">
	<div class="content">
		<h1><?php __('Latest News');?></h1>
		<?php if(!empty($news)) : ?>

		<?php echo $this->element('pagination'); ?>
		<ul class="news-list">
		<?php foreach ($news as $news): ?>
			<li>
				<div class="date"><?php __('Date & Time Posted:'); ?> <?php echo $time->niceShort($news['News']['created']); ?></div>
				<h3><?php echo $html->link($news['News']['title'], array('action'=>'view', $news['News']['id'])); ?></h3>
				<p><?php echo $news['News']['brief']; ?>...<?php echo $html->link('more', array('action'=>'view', $news['News']['id'])); ?></p>
			</li>
		<?php endforeach; ?>
		</ul>
		<?php echo $this->element('pagination'); ?>

		<?php else: ?>
			<p><?php __('There is not news at the moment.');?></p>
		<?php endif; ?>
	</div>
</div>
</div>
<div id="content_bottom"></div>
