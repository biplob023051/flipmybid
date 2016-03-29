<div class="col-md-12 auctions">
<div class="nav nav-tabs nav-justified">
<h2 style="margin: 9px 20px;">Packages</h2>
		</div>
		<div class="account">
			<div class="inner alt">
				<p><?php __('You need bid credits to be able to bid on our auctions. The different bid credit packages are listed below. Simply click on the "Purchase" link to be transferred to our secure payment processer. Bids are credited to your account instantly.');?></p>

		<?php $freebids = $this->requestAction('/settings/get/free_bid_packages_bids'); ?>
		<?php  if(!empty($freebids)) : ?>
			<?php $purchasedBefore = $this->requestAction('/accounts/check/'.$session->read('Auth.User.id')); ?>
			<?php if($purchasedBefore == false) : ?>
				<p><strong><?php echo sprintf(__('Receive %s free bids on the first package that you purchase!', true), $freebids);?></strong></p>
			<?php endif; ?>
		<?php endif; ?>

		<?php if(!empty($packages)) : ?>
		<table class="default-table" width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr class="headings">
			<td><?php __('Name');?></td>
			<td><?php __('Number of Bid Credits');?></td>
			<td><?php __('Price');?></td>
			<td><?php __('Individual Bid Cost');?></td>
			<?php if($this->requestAction('/settings/enabled/reward_points')) : ?>
				<td><?php __('Reward Points');?></td>
			<?php endif; ?>
			<td class="actions"><?php __('Buy Now'); ?></td>
		</tr>

		<?php
		foreach ($packages as $package): ?>
			<tr<?php if(!empty($package['Package']['special'])) : ?> class="special"<?php endif; ?>>
				<td>
					<?php echo $package['Package']['name']; ?>
				</td>
				<td>
					<?php echo round($package['Package']['bids'], 0); ?>
				</td>
				<td>
					<?php echo $number->currency($package['Package']['price'], $appConfigurations['currency']); ?>
				</td>
				<td>
					<?php echo $number->currency($package['Package']['price'] / $package['Package']['bids'], $appConfigurations['currency']); ?>
				</td>
				<?php if($this->requestAction('/settings/enabled/reward_points')) : ?>
					<td><?php echo $package['Package']['points']; ?></td>
				<?php endif; ?>
				<td class="actions">
					<?php if($this->requestAction('/settings/get/demo_gateway')) : ?>
						<?php echo $html->link(__('Purchase (demo mode)', true), array('controller' => 'payment_gateways', 'action' => 'demo', 'package', $package['Package']['id'])); ?>
						<?php $bar = true; ?>
					<?php endif; ?>

					<?php if($this->requestAction('/settings/get/paypal')) : ?>
						<?php if(!empty($bar)) : ?>	| <?php endif; ?>
						<?php /*echo $html->link(__('PayPal', true), array('controller' => 'payment_gateways', 'action' => 'paypal', 'package', $package['Package']['id']));*/ ?>
						<?php echo $this->Html->image('/img/btn_buynow_pp_142x27.png', array('url' => array('controller' => 'payment_gateways', 'action' => 'paypal', 'package', $package['Package']['id']))); ?>
						<?php $bar = true; ?>
					<?php endif; ?>

					<?php if($this->requestAction('/settings/get/dalpay')) : ?>
						<?php /*if(!empty($bar)) : ?>	| <?php endif; */?>
						<?php echo $html->link(__('Purchase with Dalpay', true), array('controller' => 'payment_gateways', 'action' => 'dalpay', 'package', $package['Package']['id'])); ?>
					<?php endif;?>

					<?php if($this->requestAction('/settings/get/bank_transfer')) : ?>
						<?php if(!empty($bar)) : ?>	| <?php endif; ?>
						<?php echo $html->link(__('Bank Transfer', true), array('controller' => 'payment_gateways', 'action' => 'bank', 'package', $package['Package']['id'])); ?>
						<?php $bar = true; ?>
					<?php endif; ?>

				</td>
			</tr>
			<?php $bar = 0; ?>
		<?php endforeach; ?>
		</table>

		<?php if($this->requestAction('/settings/enabled/coupons')) : ?>
				<?php if($coupon = Cache::read('coupon_user_'.$session->read('Auth.User.id'))):?>
					<?php echo sprintf(__('Coupon code applied : %s', true), $coupon['Coupon']['code']);?>
					(<?php echo $html->link(__('Remove Coupon', true), array('action' => 'removecoupon'));?>)
				<?php else:?>
					<p><?php __('If you have a coupon or discount code enter it in below to receive a discount.  If you don\'t have a code select your package above to purchase your bids.');?></p>

						<?php echo $form->create('Package', array('action' => 'applycoupon'));?>
						<p><?php echo $form->input('Coupon.code', array('label' => __('Coupon Code:', true), 'div' => false));?></p>

						<p>
						<label>&nbsp;</label>
						<?php
							echo $form->submit(__('Apply Coupon', true), array('class' => 'submit', 'div' => false));
							echo $form->end();
						?>
						</p>
				<?php endif;?>
			<?php endif;?>

		<?php else:?>
			<p><?php __('There are no packages at the moment.');?></p>
		<?php endif;?>

			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>