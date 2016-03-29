<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/edit/'.$this->data['Coupon']['id']);
echo $this->element('admin/crumb');
?>
<h2><?php __('Edit Coupon');?></h2>
<div class="coupons form">
<?php echo $form->create('Coupon');?>
	<fieldset>
	<?php
		echo $form->input('id');
		echo $form->input('code', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		// Show only if reward points is on
		if(Configure::read('App.rewardsPoint')) {
			$label = __('Saving/Reward Points', true);
		}else{
			$label = __('Saving', true);
		}
		echo $form->input('saving', array('label' => $label, 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('coupon_type_id', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< List Coupons', true), array('action'=>'index'));?></li>
	</ul>
</div>
