<p><?php echo sprintf(__('Hi %s,', true), $data['User']['first_name']);?></p>

<p><?php echo sprintf(__('This is just a quick email to let you know that your comment has been approved for the article %s.', true), '<a href="'.$appConfigurations['url'].'/news/view/'.$data['News']['id'].'">'.$data['News']['title'].'</a>'); ?></p>

<?php $freebids = $this->requestAction('/settings/get/comments_free_bids'); ?>
<?php if($freebids > 0) : ?>
<?php if(!empty($data['Comment']['bids'])) : ?>
	<p><?php echo sprintf(__('Your account has been credited with %s free bid(s) which are available for you to use.', true), $freebids);?></p>
<?php else : ?>
	<p><?php __('We do credit free bids for some comments but unfortunately we haven\'t credited you with bids this time.'); ?></p>
<?php endif; ?>
<?php endif; ?>

<p><?php echo $appConfigurations['name'];?></p>
