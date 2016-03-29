<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/edit/'.$id.'/'.$language);
echo $this->element('admin/crumb');
?>

<div class="countries form">
<?php echo $form->create(null, array('url' => '/admin/countries/edit/'.$id.'/'.$language));?>
	<fieldset>
 		<legend><?php __('Edit a Country');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('code');
		echo $form->input('show_first', array('label' => __('Show this country at the top of the country list.', true)));
	?>
	</fieldset>
<?php echo $form->end(__('Save Changes', true));?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to countries', true), array('action' => 'index'));?></li>
	</ul>
</div>
