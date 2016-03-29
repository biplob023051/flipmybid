<?php
$html->addCrumb(Inflector::humanize('Users'), '/admin/users');
$html->addCrumb($user['User']['username'], '/admin/users/view/'.$user['User']['id']);
$html->addCrumb(__('Bids', true), '/admin/bids/user/'.$user['User']['id']);
$html->addCrumb(__('Add Package', true), '/admin/payment_gateways/add/'.$user['User']['id']);
echo $this->element('admin/crumb');
?>
<h2><?php __('Add a Bid Package');?></h2>
<div class="col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
<p>
Only use this option when a payment did not go through successfully.
</p>
	</div>

<?php echo $form->create('Package', array('url' => '/admin/payment_gateways/add/'.$user['User']['id']));?>
	<fieldset>
	<?php
		echo $form->input('package_id', array('label' => __('Bid Package', true), 'empty' => 'Select Package', 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
	?>
	</fieldset>
<?php echo $form->end(__('Add Package', true));?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to the users bids', true), array('controller' => 'bids', 'action' => 'user', $user['User']['id'])); ?> </li>
	</ul>
</div>