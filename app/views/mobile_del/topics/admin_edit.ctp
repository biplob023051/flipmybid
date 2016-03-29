<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(__('Forum Topics', true), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/edit/'.$id.'/'.$language);
echo $this->element('admin/crumb');
?>

<div class="topics form">
<?php echo $form->create(null, array('url' => '/admin/topics/edit/'.$id.'/'.$language));?>
	<fieldset>
 		<legend><?php __('Edit a Topic');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $form->end(__('Save Changes', true));?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to topics', true), array('action' => 'index'));?></li>
	</ul>
</div>
