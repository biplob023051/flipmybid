<div class="boxed">
	<div class="content">
		<h1><?php echo $topic['Topic']['name']; ?></h1>

		<p><?php echo nl2br($topic['Topic']['description']); ?></p>

		<p><strong><?php echo $html->link(__('Add a thread in this topic >>', true), array('controller' => 'posts', 'action'=>'add', $topic['Topic']['id'])); ?></strong></p>

		<?php if(!empty($threads)) : ?>
			<?php echo $this->element('pagination'); ?>
			<ul class="news-list">
			<?php foreach ($threads as $thread): ?>
				<?php $count = $this->requestAction('/posts/count/threads/'.$thread['Post']['id']);?>
				<li>
					<h3><?php echo $html->link($thread['Post']['title'].' ('.$count.')', array('controller' => 'posts', 'action'=>'view', $thread['Post']['id'])); ?></h3>
					<p><?php __('Posted by:'); ?> <?php if(!empty($thread['User']['username'])) : ?><?php echo $thread['User']['username']; ?><?php else : ?><em><?php __('Site Admin'); ?></em><?php endif; ?></p>
					<div class="date"><?php __('Last Post'); ?> <?php echo $time->niceShort($thread['Post']['created']); ?></div>
				</li>
			<?php endforeach; ?>
			</ul>
			<?php echo $this->element('pagination'); ?>
		<?php else: ?>
			<p><?php __('There are no threads in this topic at the moment.'); ?></p>
		<?php endif; ?>

		<p><strong><?php echo $html->link(__('Add a thread in this topic >>', true), array('controller' => 'posts', 'action'=>'add', $topic['Topic']['id'])); ?></strong></p>
	</div>
</div>