<?php
$html->addCrumb('Manage Users', '/admin/users');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb('View', '/admin/'.$this->params['controller'].'/view/'.$user['User']['id']);
echo $this->element('admin/crumb');
?>

<h2><?php echo $user['User']['first_name']; ?> <?php echo $user['User']['last_name']; ?> (aka <?php echo $user['User']['username']; ?>)</h2>

<dl><?php $i = 0; $class = ' class="altrow"';?>
	<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Date of Birth'); ?></dt>
	<dd<?php if ($i++ % 2 == 0) echo $class;?>>
		<?php echo $time->format('d F Y', $user['User']['date_of_birth']); ?>
	</dd>

	<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Gender'); ?></dt>
	<dd<?php if ($i++ % 2 == 0) echo $class;?>>
		<?php echo $user['Gender']['name']; ?>
	</dd>

	<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active'); ?></dt>
	<dd<?php if ($i++ % 2 == 0) echo $class;?>>
		<?php if($user['User']['active'] == 1) : ?>Yes<?php else: ?>No<?php endif; ?>
	</dd>

	<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Newsletter'); ?></dt>
	<dd<?php if ($i++ % 2 == 0) echo $class;?>>
		<?php if($user['User']['newsletter'] == 1) : ?>Yes<?php else: ?>No<?php endif; ?>
	</dd>

	<?php if(!empty($referral)) : ?>
	<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Referred by'); ?></dt>
	<dd<?php if ($i++ % 2 == 0) echo $class;?>>
		<?php echo $html->link($referral['Referrer']['username'], array('action' => 'view', $referral['Referrer']['id'])); ?>
	</dd>
	<?php endif; ?>

</dl>

<h2><?php __('User\'s Address Details'); ?></h2>

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
<?php $delete = 1; ?>
<div class="actions">
	<ul>
		<?php echo $this->element('admin/user_links', array('id' => $user['User']['id'])); ?>
	</ul>
</div>
