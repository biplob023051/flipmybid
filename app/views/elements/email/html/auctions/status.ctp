<p><?php echo sprintf(__('Hi %s', true), $data['Winner']['first_name']);?>,</p>

<p><?php echo sprintf(__('The auction you won at %s titled: %s has been updated.', true), $appConfigurations['name'], $data['Product']['title']);?></p>

<p><?php echo sprintf(__('Your order has been updated to: %s %s', true), $data['Status']['name'], $data['Status']['message']); ?></p>

<?php if(!empty($data['Status']['comment'])) : ?>
	<p><?php echo $data['Status']['comment']; ?></p>
<?php endif; ?>

<p><?php __('Thank You');?><br/>
<?php echo $appConfigurations['name'];?></p>
