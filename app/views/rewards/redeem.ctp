<div class="boxed">
	<div class="content">
	<h1><?php echo sprintf(__('Redeem %s Now', true), $product['Product']['title']);?></h1>

	<p><?php echo sprintf(__('Redeem this reward now for %s reward points.', true), $product['Product']['reward_points']);?>

	<p><?php __('Press the confirm button below to redeem this reward.'); ?></p>

	<?php echo $form->create(null, array('action' => 'redeem/'.$product['Product']['id'])); ?>
	<?php echo $form->input('id', array('value' => $product['Product']['id'])); ?>
	<?php echo $form->end(__('Redeem Reward >>', true)); ?>
	</div>
</div>