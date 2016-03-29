<?php
$html->addCrumb(__('Manage Users', true), '/admin/users');
$html->addCrumb(__('Auto Bidders', true), '/admin/'.$this->params['controller'].'/autobidders');
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/autobidder_add');
echo $this->element('admin/crumb');
?>

<?php echo $form->create('User', array('url' => '/admin/users/autobidder_add'));?>
	<fieldset>
 		<legend><?php __('Add an Auto bidder');?></legend>
	<?php
		echo $form->input('username', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4', 'style' => 'margin-bottom:10px;')));
		echo $form->input('active');
	?>
	</fieldset>
<?php echo $form->end(__('Add Autobidder', true));?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to auto bidders', true), array('action' => 'autobidders')); ?> </li>
	</ul>
</div>
