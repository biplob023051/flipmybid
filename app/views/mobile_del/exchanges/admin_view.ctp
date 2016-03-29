<?php
$html->addCrumb('Bid Exchanges', '/admin/exchanges');
$html->addCrumb('View Winner', '/admin/exchanges/view/'.$exchange['Exchange']['id']);
echo $this->element('admin/crumb');
?>

<h2><?php __('Bid Exchange:'); ?> <?php echo $html->link($exchange['Auction']['Product']['title'], array('admin' => false, 'controller' => 'auctions', 'action' => 'view', $exchange['Auction']['id']), array('target' => '_blank')); ?></h2>

<?php if(!empty($exchange['Auction']['Product']['delivery_information'])):?>
	<h3><?php __('Delivery Information');?></h3>
	<p><?php echo $exchange['Auction']['Product']['delivery_information']; ?></p>
<?php endif;?>

<h2><?php __('Winner\'s Address Details'); ?></h2>

<?php if(!empty($address)) : ?>
	<?php foreach($address as $name => $address) : ?>
		<h2><?php echo $name; ?> Address</h2>
		<?php if(!empty($address)) : ?>
			<table class="results" cellpadding="0" cellspacing="0">
			<tr>
				<th><?php __('Name');?></th>
				<th><?php __('Address');?></th>
				<th><?php __('Suburb / Town');?></th>
				<th><?php __('City / State / County');?></th>
				<th><?php __('Postcode');?></th>
				<th><?php __('Country');?></th>
				<th><?php __('Phone Number');?></th>
			</tr>

			<tr>
				<td><?php echo $address['Address']['name']; ?></td>
				<td><?php echo $address['Address']['address_1']; ?><?php if(!empty($address['Address']['address_2'])) : ?>, <?php echo $address['Address']['address_2']; ?><?php endif; ?></td>
				<td><?php if(!empty($address['Address']['suburb'])) : ?><?php echo $address['Address']['suburb']; ?><?php else: ?>n/a<?php endif; ?></td>
				<td><?php echo $address['Address']['city']; ?></td>
				<td><?php echo $address['Address']['postcode']; ?></td>
				<td><?php echo $address['Country']['name']; ?></td>
				<td><?php if(!empty($address['Address']['phone'])) : ?><?php echo $address['Address']['phone']; ?><?php else: ?>n/a<?php endif; ?></td>
			</tr>
			</table>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>

<h2>Users Details</h2>

<p>Username: <?php echo $user['User']['username']; ?></p>

<?php if(!empty($exchange['Auction']['Product']['cash'])) : ?>
	<p><strong>PayPal Email Address: <?php echo $user['User']['paypal']; ?></strong></p>
<?php endif; ?>

<p><?php echo $html->link(__('Click here to view', true), array('controller' => 'users', 'action' => 'edit', $user['User']['id'])); ?> and / or edit the users account information.</p>

<h2><?php __('Update Status'); ?></h2>

<dl class="editForm">
	<?php echo $form->create(null, array('url' => '/admin/exchanges/view/'.$exchange['Exchange']['id'])); ?>
	<?php echo $form->hidden('id', array('value' => $exchange['Exchange']['id'])); ?>

	<dt><label><?php __('Update Status');?>:</label></dt>
	<dd><?php echo $form->select('status_id', $statuses, $selectedStatus, array('empty' => false)); ?></dd>

	<dt><label><?php __('Inform customer');?>:</label></dt>
	<dd><?php echo $form->checkbox('inform', array('div' => false, 'label' => false, 'error' => false, 'checked' => 'checked')); ?> Send an email to the customer to inform them that the status has changed?</dd>

	<dt><label><?php __('Comment to Customer');?>:</label></dt>
	<dd><?php echo $form->textarea('comment', array('div' => false, 'label' => false, 'error' => false, 'rows' => 8, 'cols' => 80)); ?><br />
	<?php __('(This will be added to the default email which is sent to the customer.)');?></dd>

	<dt></dt>
	<dd><?php echo $form->end(__('Update Status', true)); ?></dd>
</dl>