<?php echo $this->element('banners'); ?>

<div id="news" class="news-view boxed">
	<div class="content">
		<h1><?php echo $news['News']['title']; ?></h1>
		<div class="date"><?php echo $time->niceShort($news['News']['created']); ?></div>
		<?php echo $news['News']['content']; ?>

		<?php if($this->requestAction('/settings/get/news_comments')) : ?>
			<hr size="1">

			<h2><?php __('Comments'); ?></h2>

			<?php if(!empty($comments)) : ?>
				<?php foreach($comments as $comment): ?>
					<h3><?php echo $comment['User']['username']; ?> <?php __('on'); ?> <?php echo $time->niceShort($comment['Comment']['created']); ?></h3>
					<p><?php echo nl2br($comment['Comment']['comment']); ?></p>
					<hr size="1">
				<?php endforeach; ?>
			<?php else : ?>
				<p><?php __('No comments have been submitted yet.'); ?></p>
			<?php endif; ?>

			<?php if($session->check('Auth.User')):?>
				<?php if(time() < strtotime($news['News']['created']) + (86400 * 7)) : ?>
					<h2><?php __('Submit your own comment'); ?></h2>

					<?php
					$freebids = $this->requestAction('/settings/get/comments_free_bids');

					if($freebids == 1) : ?>
						<p><?php echo sprintf(__('Submit a comment on this article and you may be credited with <strong>%s</strong> free bid.', true), $freebids); ?></p>
					<?php elseif($freebids > 0) : ?>
						<p><?php echo sprintf(__('Submit a comment on this article and you may be credited with <strong>%s</strong> free bids.', true), $freebids); ?></p>
					<?php endif; ?>

					<?php echo $form->create('Comment', array('url' => 'view/'.$news['News']['id'])); ?>

					<fieldset>
						<legend></legend>

						<?php
						echo $form->input('comment', array('label' => __('Comment', true)));
						echo $form->end(__('Submit Comment >>', true));
						?>
					</fieldset>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>

		<p><?php echo $html->link(__('<< Back to the latest news', true), array('action'=>'index')); ?></p>
	</div>
</div>
