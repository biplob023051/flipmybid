<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/edit/'.$id.'/'.$language);
echo $this->element('admin/crumb');
?>

<div class="countries form">
<?php echo $form->create(null, array('url' => '/admin/'.$this->params['controller'].'/edit/'.$id.'/'.$language));?>
	<fieldset>
 		<legend><?php __('Edit a Gender');?></legend>
	<?php
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end(__('Save Changes', true));?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to genders', true), array('action' => 'index'));?></li>
	</ul>
</div>
