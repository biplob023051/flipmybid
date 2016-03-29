<div id="content_top"></div>
<div id="content_bg">
<div class="boxed">
	<div class="content">
		<h1><?php __('Pay by Bank Transfer'); ?></h1>

		<?php if($model == 'package') : ?>

			<p><?php echo sprintf(__('You have selected to purchase %s for %s.', true), '<strong>'.$package['Package']['name'].'</strong>', '<strong>'.$number->currency($package['Package']['price'], $appConfigurations['currency']).'</strong>');?></p>

			<?php $bank_details = $this->requestAction('/settings/get/bank_details'); ?>
			<?php if(!empty($bank_details)) : ?>
				<h3><?php __('Bank Account Details'); ?></h3>

				<p><?php echo $bank_details; ?></p>
			<?php endif; ?>

			<p><i><?php echo sprintf(__('When paying please use the reference: %s', true), '<strong>'.$session->read('Auth.User.username').'</strong>');?></i></p>

			<p><?php __('Your bids will be credited within 12 hours of receiving the payment and we will email you to let you know your bids are available.'); ?></p>

		<?php endif; ?>

	</div>
</div>
</div>
<div id="content_bottom"></div>