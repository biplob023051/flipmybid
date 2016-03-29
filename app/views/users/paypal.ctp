<div id="left">
    <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('PayPal Email Address');?></h1>
		<?php echo $form->create('User', array('url' => '/users/paypal/'.$id.'/'.$method));?>
		<fieldset>
			<?php
				echo $form->input('paypal', array('label' => 'PayPal Email Address *'));
				echo $form->end('Save Changes');
			?>
		</fieldset>
	</div>
</div>
