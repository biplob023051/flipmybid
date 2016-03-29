<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add/');
echo $this->element('admin/crumb');
?>

<div class="coupons form">
<?php echo $form->create('Coupon');?>
	<fieldset>
 		<legend><?php __('Add Coupon');?></legend>
	<?php
		echo $form->input('code');
		// Show only if reward points is on
		if(Configure::read('App.rewardsPoint')) {
			$label = __('Saving/Reward Points', true);
		}else{
			$label = __('Saving', true);
		}
		echo $form->input('saving', array('label' => $label));
		echo $form->input('coupon_type_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< List Coupons', true), array('action'=>'index'));?></li>
	</ul>
</div>
