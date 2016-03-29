<?php echo sprintf(__('Hi %s', true), $data['Winner']['first_name']);?>,

<?php echo sprintf(__('The auction you won at %s titled: %s has been updated.', true), $appConfigurations['name'], $data['Product']['title']);?>

<?php echo sprintf(__('Your order has been updated to: %s %s', true), $data['Status']['name'], $data['Status']['message']); ?>

<?php if(!empty($data['Status']['comment'])) : ?>
	<?php echo $data['Status']['comment']; ?>
<?php endif; ?>

<?php __('Thank You');?>
<?php echo $appConfigurations['name'];?>
