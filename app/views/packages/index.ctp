<div id="left">
    <?php echo $this->element('menu_user');?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('Packages');?></h1>

		<p><?php __('You need to purchase a bid package to be able to bid on our auctions.  The different packages are listed below.  Simply click on the "Purchase" link to be transferred to our payment processer. Bids are credited to your account instantly.');?></p>

		<?php $freebids = $this->requestAction('/settings/get/free_bid_packages_bids'); ?>
		<?php  if(!empty($freebids)) : ?>
			<?php $purchasedBefore = $this->requestAction('/accounts/check/'.$session->read('Auth.User.id')); ?>
			<?php if($purchasedBefore == false) : ?>
				<p><strong><?php echo sprintf(__('Receive %s free bids on the first package that you purchase!', true), $freebids);?></strong></p>
			<?php endif; ?>
		<?php endif; ?>

		<?php if(!empty($packages)) : ?>

			<?php if($this->requestAction('/settings/enabled/coupons')) : ?>
				<?php if($coupon = Cache::read('coupon_user_'.$session->read('Auth.User.id'))):?>
					<?php echo sprintf(__('Coupon code applied : %s', true), $coupon['Coupon']['code']);?>
					(<?php echo $html->link(__('Remove Coupon', true), array('action' => 'removecoupon'));?>)
				<?php else:?>
					<p><?php __('If you have a coupon or discount code enter it in below to receive a discount.  If you don\'t have a code select your package below to purchase your bids.');?></p>
					<fieldset>
						<legend></legend>
						<?php echo $form->create('Package', array('action' => 'applycoupon'));?>
						<?php echo $form->input('Coupon.code', array('label' => __('Coupon Code:', true)));?>
						<?php echo $form->end(__('Apply Coupon', true));?>
					</fieldset>
				<?php endif;?>
			<?php endif;?>

		<table width="100%" class="table" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo $paginator->sort('name');?></th>
			<th><?php echo $paginator->sort('Number of Bids', 'bids');?></th>
			<th><?php echo $paginator->sort('price');?></th>
			<th><?php echo $paginator->sort('Individual Bid Cost', 'price');?></th>
			<?php if($this->requestAction('/settings/enabled/reward_points')) : ?>
				<th><?php echo $paginator->sort('Reward Points', 'points');?></th>
			<?php endif; ?>
			<th class="actions"><?php __('Pay Now'); ?></th>
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
						<?php echo $html->link(__('PayPal', true), array('controller' => 'payment_gateways', 'action' => 'paypal', 'package', $package['Package']['id'])); ?>
						<?php $bar = true; ?>
					<?php endif; ?>

					<?php if($this->requestAction('/settings/get/dalpay')) : ?>
						<?php if(!empty($bar)) : ?>	| <?php endif; ?>
						<?php echo $html->link(__('Credit Card', true), array('controller' => 'payment_gateways', 'action' => 'dalpay', 'package', $package['Package']['id'])); ?>
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

		<?php else:?>
			<p><?php __('There are no packages at the moment.');?></p>
		<?php endif;?>
	</div>
</div>