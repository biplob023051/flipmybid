<div class="g7 col-md-3 col-sm-12 col-xs-12">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="g5 col-md-9 col-sm-12 col-xs-12">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('Confirm Your Details for:');?> <?php echo $auction['Product']['title']; ?></h2>
		</div>
		<div class="account">
			<div class="inner alt">
				<?php if(!empty($auction['Product']['delivery_information'])):?>
					<h3><?php __('Delivery Information');?></h3>
					<p><?php echo $auction['Product']['delivery_information']; ?></p>
				<?php endif;?>

				<p><?php __('Please confirm your address details below and ensure the details are correct before purchasing this item');?>:</p>

				<?php if(!empty($address)) : ?>
					<?php foreach($address as $name => $address) : ?>
						<h2><?php echo $name; ?> <?php __('Address'); ?></h2>
						<?php if(!empty($address['Address']['id'])) : ?>
							<table class="default-table" width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr class="headings">
								<td><?php __('Name');?></td>
								<td><?php __('Address');?></td>
								<td><?php __('Town');?></td>
								<td><?php __('County');?></td>
								<td><?php __('Postcode');?></td>
								<td><?php __('Country');?></td>
								<td><?php __('Phone Number');?></td>
								<td class="actions"><?php __('Options');?></td>
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
				<?php elseif($total < 0 && empty($auction['Auction']['payment']) && (!empty($auction['Product']['cash']) || (!empty($auction['Auction']['reverse']) && !empty($auction['Auction']['price_past_zero'])))) : ?>
					<h2><?php __('Select a Method to Receive your Payment');?></h2>

					<p><?php __('You are owed:'); ?> <?php echo $number->currency($total * -1, $appConfigurations['currency']); ?></p>

					<?php echo $form->create('Auction', array('url' => '/auctions/payment/'.$auction['Auction']['id']));?>
					<fieldset>
						<?php
							$options = array();
							if($this->requestAction('/settings/get/paypal')) {
								$options[__('Paypal', true)] = ' '.__('Paypal', true);
							}
							if($this->requestAction('/settings/get/amazon')) {
								$options[__('Amazon Voucher', true)] = ' '.__('Amazon Voucher', true);
							}
							if($this->requestAction('/settings/get/bank_transfer')) {
								$options[__('Bank Transfer', true)] = ' '.__('Bank Transfer', true);
							}
							if($this->requestAction('/settings/get/bids')) {
								$options[__('Bid Credits', true)] = ' '.__('Bid Credits', true);
							}

							echo $form->input('payment_method', array('type' => 'radio', 'style' => 'margin-left:20px;', 'label' => false, 'legend' => false, 'options' => $options, 'separator' => '<br />'));
							echo $form->submit(__('Confirm', true), array('div' => false, 'class' => 'submit'));
						?>
					</fieldset>
					<?php echo $form->end(); ?>
				<?php else : ?>
					<?php if(!empty($auction['Auction']['payment'])) : ?>
						<?php if($auction['Auction']['payment'] == 'Paypal') : ?>
							<p><strong><?php __('The cash will be sent via Paypal to:'); ?> <?php echo $auction['Winner']['paypal']; ?> (<a href="/auctions/cancel_payment/<?php echo $auction['Auction']['id']; ?>"><?php __('change'); ?></a>)</strong></p>
						<?php elseif($auction['Auction']['payment'] == 'Amazon Voucher') : ?>
							<p><strong><?php __('The Amazon Voucher will be sent to:'); ?> <?php echo $auction['Winner']['amazon']; ?> (<a href="/auctions/cancel_payment/<?php echo $auction['Auction']['id']; ?>"><?php __('change'); ?></a>)</strong></p>
						<?php elseif($auction['Auction']['payment'] == 'Bank Transfer') : ?>
							<p><strong><?php __('A payment will be made to your bank account:'); ?> <?php echo $auction['Winner']['bank_transfer']; ?> (<a href="/auctions/cancel_payment/<?php echo $auction['Auction']['id']; ?>"><?php __('change'); ?></a>)</strong></p>
						<?php elseif($auction['Auction']['payment'] == 'Bid Credits') : ?>
							<?php $bidValue = $this->requestAction('/settings/get/bid_value'); ?>
							<p><strong><?php __('You will receive:'); ?> <?php echo round($total * -100 * $bidValue); ?> <?php __('Bid Credit(s)'); ?> (<a href="/auctions/cancel_payment/<?php echo $auction['Auction']['id']; ?>"><?php __('change'); ?></a>)</strong></p>
						<?php endif; ?>


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
						<?php if($total < 0) : ?>
							<strong><?php __('Value Owed:'); ?> <?php echo $number->currency($total * -1, $appConfigurations['currency']); ?></strong>
						<?php else : ?>
							<strong><?php __('Total Due:'); ?> <?php echo $number->currency($total, $appConfigurations['currency']); ?></strong>
						<?php endif; ?>
					</p>

					<?php if($total > 0) : ?>
						<?php if(!empty($auction['Product']['bids'])) : ?>
							<p><?php __('After payment your bids will be credited instantly to your account.'); ?></p>
						<?php elseif($auction['Product']['cash']) : ?>
							<p><?php __('After payment and we will notify you when the cash is sent.'); ?></p>
						<?php else : ?>
							<p><?php __('After payment we will notify you when the product has been shipped.'); ?></p>
						<?php endif; ?>
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
	</div>
	<!--/ Auctions -->
</div>