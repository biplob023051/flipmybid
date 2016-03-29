<div id="left">
    <?php echo $this->element('menu_user');?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('Confirm Your Details for:');?> <?php echo $reward['Product']['title']; ?></h1>

		<?php if(!empty($reward['Product']['delivery_information'])):?>
			<h3><?php __('Delivery Information');?></h3>
			<p><?php echo $reward['Product']['delivery_information']; ?></p>
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
					<p><a href="/addresses/add/<?php echo $address['Address']['user_address_type_id']; ?>"><?php echo sprintf(__('Add a %s address', true), $name); ?></a></p>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>

		<?php if(!empty($addressRequired)) : ?>
			<h2><?php __('Missing Address information');?></h2>
			<p><?php __('Before purchasing the item please <a href="/addresses">click here to update your address information</a>.');?></p>
		<?php elseif(!empty($reward['Product']['cash']) && empty($reward['User']['paypal'])) : ?>
			<h2><?php __('PayPal Address Required');?></h2>
			<?php echo $form->create('User', array('url' => '/users/paypal/'.$reward['Reward']['id'].'/reward'));?>
			<fieldset>
				<?php echo $form->input('paypal', array('label' => 'Paypal Email address: ')); ?>
			</fieldset>
			<?php echo $form->end(__('Confirm PayPal Address >>', true)); ?>
		<?php else : ?>
			<?php if(!empty($reward['Product']['cash'])) : ?>
				<p><strong><?php __('The cash will be send via Paypal to:'); ?> <?php echo $reward['User']['paypal']; ?> (<a href="/users/paypal/<?php echo $reward['Reward']['id']; ?>/reward"><?php __('change email'); ?></a>)</strong></p>
			<?php endif; ?>

			<h2><?php __('Confirmation'); ?></h2>

			<p><?php __('If you feel there is an error, or if you are unsure about anything please <a href="/contact">contact us before confirming your auction</a>.');?></p>

			<?php echo $form->create(null, array('action' => 'confirm/'.$reward['Reward']['id'])); ?>
			<?php echo $form->hidden('id', array('value' => $reward['Reward']['id'])); ?>
			<?php echo $form->end(__('Confirm Details >>', true)); ?>

		<?php endif; ?>
	</div>
</div>