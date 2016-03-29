<div class="boxed">
	<div class="content">
		<h1><?php __('Forum'); ?></h1>

		<p><?php __('The forum allows users to interact and discuss various topics and auctions.  Click on a topic below to view the available threads.'); ?></p>

		<?php if(!empty($topics)) : ?>
			<?php echo $this->element('pagination'); ?>
			<ul class="news-list">
			<?php foreach ($topics as $topic): ?>
				<?php $count = $this->requestAction('/posts/count/topics/'.$topic['Topic']['id']);?>
				<li>
					<h3><?php echo $html->link($topic['Topic']['name'].' ('.$count.')', array('action'=>'view', $topic['Topic']['id'])); ?></h3>
					<p><?php echo nl2br($topic['Topic']['description']); ?></p>
				</li>
			<?php endforeach; ?>
			</ul>
			<?php echo $this->element('pagination'); ?>
		<?php else: ?>
			<p><?php __('There are no forum topics at the moment.'); ?></p>
		<?php endif; ?>
	</div>
</div>
