<div id="left">
    <?php echo $this->element('menu_user');?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('My Addresses');?></h1>
		<?php if(!empty($address)) : ?>
			<?php foreach($address as $name => $address) : ?>
				<h2><?php __('Address'); ?> <?php echo $name; ?></h2>
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
        <div class="clear"></div>
	</div>
</div>
