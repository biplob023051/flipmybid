<div id="left">
    <?php echo $this->element('menu_user');?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('Confirm Your Details for:');?> <?php echo $auction['Product']['title']; ?></h1>

		<?php if(!empty($auction['Product']['delivery_information'])):?>
			<h3><?php __('Delivery Information');?></h3>
			<p><?php echo $auction['Product']['delivery_information']; ?></p>
		<?php endif;?>

		<p><?php __('Please confirm your address details below and ensure the details are correct before purchasing this item');?>:</p>

		<?php if(!empty($address)) : ?>
			<?php foreach($address as $name => $address) : ?>
				<h2><?php echo $name; ?> <?php __('Address'); ?></h2>
				<?php if(!empty($address['Address']['id'])) : ?>
					<table class="table" cellpadding="0" cellspacing="0">
					<tr>
						<th><?php __('Name');?></th>
						<th><?php __('Address');?></th>
						<th><?php __('Suburb / Town');?></th>
						<th><?php __('City / State / County');?></th>
						<th><?php __('Postcode');?></th>
						<th><?php __('Country');?></th>
						<th><?php __('Phone Number');?></th>
						<th class="actions"><?php __('Options');?></th>
					</tr>

					<tr>
						<td><?php echo $address['Address']['name']; ?></td>
						<td><?php echo $address['Address']['address_1']; ?><?php if(!empty($address['Address']['address_2'])) : ?>, <?php echo $address['Address']['address_2']; ?><?php endif; ?></td>
						<td><?php if(!empty($address['Address']['suburb'])) : ?><?php echo $address['Address']['suburb']; ?><?php else: ?><?php __('n/a'); ?><?php endif; ?></td>
						<td><?php echo $address['Address']['city']; ?></td>
						<td><?php echo $address['Address']['postcode']; ?></td>
						<td><?php echo $address['Country']['name']; ?></td>
						<td><?php if(!empty($address['Address']['phone'])) : ?><?php echo $address['Address']['phone']; ?><?php else: ?><?php __('n/a'); ?><?php endif; ?></td>
						<td><a href="/addresses/edit/<?php echo $address['Address']['user_address_type_id']; ?>"><?php __('Edit'); ?></a></td>
					</tr>
					</table>
				<?php else: ?>
					<p><a href="/addresses/add/<?php echo $address['Address']['user_address_type_id']; ?>"><?php echo sprintf(__('Add a <strong>%s</strong> Address.', true), $name);?></a></p>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>

		<?php if(!empty($addressRequired)) : ?>
			<h2><?php __('Missing Address information');?></h2>
			<p><?php __('Before purchasing the item please <a href="/addresses">click here to update your address information</a>.');?></p>
		<?php elseif(!empty($auction['Product']['cash']) && empty($auction['Winner']['paypal'])) : ?>
			<h2><?php __('PayPal Address Required');?></h2>
			<?php echo $form->create('User', array('url' => '/users/paypal/'.$auction['Auction']['id']));?>
			<fieldset>
				<?php echo $form->input('paypal', array('label' => 'Paypal Email address: ')); ?>
			</fieldset>
			<?php echo $form->end(__('Confirm PayPal Address >>', true)); ?>
		<?php else : ?>
			<?php if(!empty($auction['Product']['cash'])) : ?>
				<p><strong><?php __('The cash will be send via Paypal to:'); ?> <?php echo $auction['Winner']['paypal']; ?> (<a href="/users/paypal/<?php echo $auction['Auction']['id']; ?>"><?php __('change email'); ?></a>)</strong></p>
			<?php endif; ?>

			<p><?php __('If you feel there is an error, or if you are unsure about anything please <a href="/contact">contact us before confirming your auction</a>.');?></p>

			<?php if(!empty($auction['Product']['win_points']) && $this->requestAction('/settings/enabled/reward_points') && $this->requestAction('/settings/get/win_points')) : ?>
				<div class="account-info">
					<p class="info"><?php echo sprintf(__('Congratulations! By winning this auction you have won a bonus %s Reward Points!', true), '<strong>'.$auction['Product']['win_points'].'</strong>');?></p>
				</div>
			<?php endif; ?>

			<h2><?php __('Final Confirmation'); ?></h2>

			<?php if($this->requestAction('settings/enabled/reward_points') && $this->requestAction('settings/get/redeemable_won_auctions')) : ?>
				<p><?php echo sprintf(__('You have <strong>%s</strong> reward points.', true), $credits);?></p>

				<?php if($credits > 0) : ?>
					<?php $points = $this->requestAction('settings/get/redeemable_won_auctions'); ?>
					<?php if($points == 1) : ?>
						<p><?php echo sprintf(__('<strong>%s</strong> point will be used on this auction.', true), $points);?></p>
					<?php else : ?>
						<p><?php echo sprintf(__('<strong>%s</strong> points will be used on this auction.', true), $points);?></p>
					<?php endif; ?>

					<p>
						<?php __('Price:'); ?> <?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?><br />
						<?php __('Credits:'); ?> <strong><?php echo $number->currency(-1 * $auction['Auction']['price'], $appConfigurations['currency']); ?></strong>
					</p>
				<?php else : ?>
					<p><?php echo sprintf(__('<strong>%s</strong> credits will be used on this auction.', true), 0);?></p>
					<p>
						<?php __('Price:'); ?> <?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?><br />
						<?php __('Credits:'); ?> <strong><?php echo $number->currency(0, $appConfigurations['currency']); ?></strong>
					</p>
				<?php endif; ?>
			<?php endif; ?>

			<p>
				<?php __('Shipping:'); ?> <?php echo $number->currency($auction['Product']['delivery_cost'], $appConfigurations['currency']); ?><br />
				<strong><?php __('Total Due:'); ?> <?php echo $number->currency($total, $appConfigurations['currency']); ?></strong>
			</p>

			<?php if(!empty($auction['Product']['bids'])) : ?>
				<p><?php __('After payment your bids will be credited instantly to your account.'); ?></p>
			<?php elseif($auction['Product']['cash']) : ?>
				<p><?php __('After payment and we will notify you when the cash is sent.'); ?></p>
			<?php else : ?>
				<p><?php __('After payment we will notify you when the product has been shipped.'); ?></p>
			<?php endif; ?>

			<?php if($total > 0) : ?>
				<?php if($this->requestAction('/settings/get/demo_gateway')) : ?>
					<p><strong><?php echo $html->link(__('Purchase (demo mode) >>', true), array('controller' => 'payment_gateways', 'action' => 'demo', 'auction', $auction['Auction']['id'])); ?></strong></p>
				<?php endif; ?>

				<?php if($this->requestAction('/settings/get/paypal')) : ?>
					<p><strong><?php echo $html->link(__('PayPal >>', true), array('controller' => 'payment_gateways', 'action' => 'paypal', 'auction', $auction['Auction']['id'])); ?></strong></p>
				<?php endif; ?>

				<?php if($this->requestAction('/settings/get/dalpay')) : ?>
					<p><strong><?php echo $html->link(__('Credit Card >>', true), array('controller' => 'payment_gateways', 'action' => 'dalpay', 'auction', $auction['Auction']['id'])); ?></strong></p>
				<?php endif; ?>
			<?php elseif($this->requestAction('settings/enabled/reward_points')) : ?>
				<p><strong><?php echo $html->link(__('Confirm Details >>', true), array('controller' => 'payment_gateways', 'action' => 'credits', $auction['Auction']['id'])); ?></strong></p>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</div>