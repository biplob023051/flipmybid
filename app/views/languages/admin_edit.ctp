<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/edit/'.$id);
echo $this->element('admin/crumb');
?>

<div class="languages form">
<?php echo $form->create(null, array('url' => '/admin/'.$this->params['controller'].'/edit/'.$id));?>
	<fieldset>
 		<legend><?php __('Edit a Language');?></legend>
	<?php
		echo $form->input('name', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('code', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('theme', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4', 'style' => 'margin-bottom:10px;')));
		echo $form->input('default');
	?>
	</fieldset>
<?php echo $form->end(__('Save Changes', true));?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to languages', true), array('action' => 'index'));?></li>
	</ul>
</div>
