<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(__('Forum Topics', true), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add');
echo $this->element('admin/crumb');
?>

<div class="topics form">
<?php echo $form->create();?>
	<fieldset>
 		<legend><?php __('Add a Topic');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $form->end(__('Add Topic', true));?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to topics', true), array('action' => 'index'));?></li>
	</ul>
</div>
