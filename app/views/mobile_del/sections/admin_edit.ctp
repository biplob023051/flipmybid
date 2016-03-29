<?php
$html->addCrumb(__('Manage Content', true), '/admin/pages');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/edit/'.$id);
echo $this->element('admin/crumb');
?>

<div class="news form">
<?php echo $form->create(null, array('url' => '/admin/'.$this->params['controller'].'/edit/'.$id.'/'.$language));?>
	<fieldset>
 		<legend>Edit a Section</legend>
	<?php
		echo $form->input('name', array('label' => 'Name *'));
	?>
	</fieldset>
<?php echo $form->end('Save Changes');?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link('<< Back to sections', array('action' => 'index'));?></li>
	</ul>
</div>
