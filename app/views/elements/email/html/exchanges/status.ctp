<p><?php echo sprintf(__('Hi %s', true), $data['User']['first_name']);?>,</p>

<p><?php echo sprintf(__('The product you exchanged at %s titled: %s has been updated.', true), $appConfigurations['name'], $data['Auction']['Product']['title']);?></p>

<p><?php echo sprintf(__('Your order has been updated to: %s %s', true), $data['Status']['name'], $data['Status']['message']); ?></p>

<?php if(!empty($data['Status']['comment'])) : ?>
	<p><?php echo $data['Status']['comment']; ?></p>
<?php endif; ?>

<p><?php __('Thank You');?><br/>
<?php echo $appConfigurations['name'];?></p>