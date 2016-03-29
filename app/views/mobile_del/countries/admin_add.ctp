<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add');
echo $this->element('admin/crumb');
?>

<div class="countries form">
<?php echo $form->create();?>
	<fieldset>
 		<legend><?php __('Add a Country');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('code');
		echo $form->input('show_first', array('label' => __('Show this country at the top of the country list.', true)));
	?>
	</fieldset>
<?php echo $form->end(__('Add Country', true));?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to countries', true), array('action' => 'index'));?></li>
	</ul>
</div>
