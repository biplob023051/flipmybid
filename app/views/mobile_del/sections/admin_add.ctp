<?php
$html->addCrumb(__('Manage News', true), '/admin/news');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add');
echo $this->element('admin/crumb');
?>

<div class="news form">
<?php echo $form->create();?>
	<fieldset>
 		<legend>Add a Section</legend>
	<?php
		echo $form->input('name', array('label' => 'Name *'));
	?>
	</fieldset>
<?php echo $form->end('Add Section');?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link('<< Back to sections', array('action' => 'index'));?></li>
	</ul>
</div>
