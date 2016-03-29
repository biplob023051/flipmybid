<div class="g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('Confirm Your Payment Details for:');?> <?php echo $auction['Product']['title']; ?></h2>
		</div>
		<div class="account">
			<div class="">
				<?php echo $form->create('User', array('url' => '/auctions/payment/'.$auction['Auction']['id'])); ?>
				<?php echo $form->input('Auction.payment_method', array('type' => 'hidden')); ?>

				<?php if($this->data['Auction']['payment_method'] == 'Paypal') : ?>
					<h2><?php __('Please Confirm your PayPal Address');?></h2>
					<fieldset>
						<?php echo $form->input('paypal', array('label' => 'Paypal Email')); ?>
					</fieldset>
				<?php elseif($this->data['Auction']['payment_method'] == 'Amazon Voucher') : ?>
					<h2><?php __('Please Confirm your Amazon Voucher Email Address');?></h2>
					<fieldset>
						<?php echo $form->input('amazon', array('label' => 'Email Address')); ?>
					</fieldset>
				<?php elseif($this->data['Auction']['payment_method'] == 'Bank Transfer') : ?>
					<h2><?php __('Please Confirm your Bank Account Details');?></h2>
					<fieldset>
						<?php echo $form->input('bank_transfer', array('label' => 'Account Details')); ?>
					</fieldset>
				<?php elseif($this->data['Auction']['payment_method'] == 'Bid Credits') : ?>
					<h2><?php __('Confirm Bids');?></h2>
					<fieldset>
						<?php $bidValue = $this->requestAction('/settings/get/bid_value'); ?>
						<p><strong><?php __('Accept:'); ?> <?php echo round($total * -100 * $bidValue); ?> <?php __('Bid Credit(s)'); ?></strong></p>
						<?php echo $form->input('bids', array('type' => 'hidden', 'value' => true)); ?>
					</fieldset>
				<?php endif; ?>

				<?php echo $form->submit(__('Confirm', true), array('div' => false, 'class' => 'submit')); ?>
				<?php echo $form->end(); ?>

				<p><?php echo $html->link(__('<< Back to the auction details', true), array('action' => 'pay', $auction['Auction']['id'])); ?></p>
			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>