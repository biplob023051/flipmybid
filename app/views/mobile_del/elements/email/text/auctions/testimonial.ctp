<?php echo sprintf(__('Hi %s,', true), $data['User']['first_name']);?>

<?php echo sprintf(__('This is just a quick email to let you know that your testimonial has been approved for the auction %s.', true), $data['Auction']['Product']['title'].' ('.$appConfigurations['url'].'/auction/'.$data['Auction']['id'].')'); ?>

<?php $freebids = $this->requestAction('/settings/get/testimonial_free_bids'); ?>
<?php if($freebids > 0) : ?>
<?php echo sprintf(__('Your account has been credited with %s free bid(s) which are available for you to use.', true), $freebids);?>
<?php endif; ?>

<?php echo $appConfigurations['name'];?>