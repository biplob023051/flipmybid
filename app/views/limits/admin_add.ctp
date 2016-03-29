<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(__('Win Limits', true), '/admin/limits');
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add');
echo $this->element('admin/crumb');
?>

<div class="limits form">
<?php echo $form->create();?>
	<fieldset>
 		<legend><?php __('Add a Win Limit');?></legend>
	<?php
		echo $form->input('name', array('label' => __('Name *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('limit', array('label' => __('Limit * (max no. of auctions)', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('days', array('label' => __('Days * (number of days)', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
	?>
	</fieldset>
<?php echo $form->end(__('Add Limit', true));?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to win limits', true), array('action' => 'index'));?></li>
	</ul>
</div>
