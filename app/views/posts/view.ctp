<div class="boxed">
	<div class="content">
		<h1><?php echo $thread['Post']['title']; ?></h1>

		<?php if(!empty($thread['Post']['auction_id'])) : ?>
			<p><?php __('This thread relates to the auction:'); ?> <a target="_blank" href="/auction/<?php echo $thread['Auction']['id']; ?>"><?php echo $thread['Auction']['Product']['title']; ?></a>.</p>
		<?php endif; ?>

		<p><strong><?php echo $html->link(__('Post a reply >>', true), array('controller' => 'posts', 'action'=>'reply', $thread['Post']['id'])); ?></strong></p>

		<?php if(!empty($posts)) : ?>
			<?php echo $this->element('pagination'); ?>
			<ul class="news-list">
			<?php foreach ($posts as $post): ?>
				<li>
					<p><?php echo nl2br($post['Post']['content']); ?></p>
					<p><strong><?php __('Posted by:'); ?> <?php if(!empty($post['User']['username'])) : ?><?php echo $post['User']['username']; ?><?php else : ?><em><?php __('Site Admin'); ?></em><?php endif; ?></strong></p>
					<div class="date"><?php __('Date & Time Posted'); ?> <?php echo $time->niceShort($post['Post']['created']); ?></div>
				</li>
			<?php endforeach; ?>
			</ul>
			<?php echo $this->element('pagination'); ?>
		<?php else: ?>
			<p><?php __('There are no posts in this thread at the moment.'); ?></p>
		<?php endif; ?>

		<p><strong><?php echo $html->link('Post a reply >>', array('controller' => 'posts', 'action'=>'reply', $thread['Post']['id'])); ?></strong></p>
	</div>
</div>