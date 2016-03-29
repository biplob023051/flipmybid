<?php
$html->addCrumb(__('Settings'), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Edit'), '/admin/'.$this->params['controller'].'/edit/'.$this->data['Department']['id']);
echo $this->element('admin/crumb');
?>
<h2><?php __('Add a Department');?></h2>
<div class="news form">
<?php echo $form->create('Department');?>
	<fieldset>
	<?php
		echo $form->input('id');
		echo $form->input('name', array('label' => 'Name *', 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('email', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
	?>
	</fieldset>
<?php echo $form->end(__('Save Changes', true));?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Department.id')), null, sprintf(__('Are you sure you want to delete this department?', true))); ?></li>
		<li><?php echo $html->link(__('<< Back to departments', true), array('action' => 'index'));?></li>
	</ul>
</div>
