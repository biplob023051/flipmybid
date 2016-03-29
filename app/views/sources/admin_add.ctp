<div class="sources form">
<?php echo $form->create('Source');?>
	<fieldset>
 		<legend><?php __('Add Source');?></legend>
	<?php
		echo $form->input('name', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4', 'style' => 'margin-bottom:10px;')));
		echo $form->input('extra');
	?>
	</fieldset>
<?php echo $form->end(__('Submit', true));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to Sources', true), array('action'=>'index'));?></li>
	</ul>
</div>
