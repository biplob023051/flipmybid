<div class="settings index">

<h2><?php __('License Code Required');?></h2>

<?php if(!empty($this->data['Setting']['value'])) : ?>
	<p><strong>Your license key is incorrect.  Please contact <a target="_blank" href="http://www.pennyauctioncode.com">Penny Auction Code</a> to correct this issue!</strong></p>
<?php else : ?>
	<p><strong>Please enter in the license key that you received from Penny Auction Code to continue.  If you did not receive a license key, or if it is not valid please contact <a target="_blank" href="http://www.pennyauctioncode.com">Penny Auction Code</a> to correct this issue!</strong></p>
<?php endif; ?>

<div class="settings form">
<?php echo $form->create('Setting', array('url' => '/admin/settings/license'));?>
	<fieldset>
	<?php
		echo $form->input('value', array('label' => __('Value *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4')));
	?>
	</fieldset>
<?php echo $form->end(__('Update License Key >>', true));?>
</div>

<?php echo $this->element('admin/required'); ?>