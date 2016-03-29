<?php
$html->addCrumb(Inflector::humanize('Users'), '/admin/users');
$html->addCrumb($user['User']['username'], '/admin/users/view/'.$user['User']['id']);
$html->addCrumb(__('Bids', true), '/admin/bids/user/'.$user['User']['id']);
$html->addCrumb(__('Add Package', true), '/admin/payment_gateways/add/'.$user['User']['id']);
echo $this->element('admin/crumb');
?>

<p>
Only use this option when a payment did not go through successfully.
</p>

<?php echo $form->create('Package', array('url' => '/admin/payment_gateways/add/'.$user['User']['id']));?>
	<fieldset>
 		<legend><?php __('Add a Bid Package');?></legend>
	<?php
		echo $form->input('package_id', array('label' => __('Bid Package', true), 'empty' => 'Select Package'));
	?>
	</fieldset>
<?php echo $form->end(__('Add Package', true));?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to the users bids', true), array('controller' => 'bids', 'action' => 'user', $user['User']['id'])); ?> </li>
	</ul>
</div>