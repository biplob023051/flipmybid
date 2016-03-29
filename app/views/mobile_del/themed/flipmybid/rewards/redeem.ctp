<div class="rounded contact">
	<div id="tabs">
    	<h2><?php echo sprintf(__('Redeem %s Now', true), $product['Product']['title']);?></h2>
    </div>
    <div class="c-content">
		<p><?php echo sprintf(__('Redeem this reward now for %s reward points.', true), $product['Product']['reward_points']);?>

		<p><?php __('Press the confirm button below to redeem this reward.'); ?></p>

		<?php echo $form->create(null, array('action' => 'redeem/'.$product['Product']['id'])); ?>
		<?php echo $form->input('id', array('value' => $product['Product']['id'])); ?>
		<?php echo $form->submit(__('Redeem Reward >>', true), array('div' => false, 'class' => 'submit')); ?>
		<?php echo $form->end(); ?>

	</div>
</div>