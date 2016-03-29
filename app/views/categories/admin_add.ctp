<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add');
echo $this->element('admin/crumb');
?>

<div class="categories form">

<?php echo $form->create('Category', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php __('Add Category');?></legend>

	<?php
		echo $form->input('parent_id', array('label' => __('Parent Category', true), 'type' => 'select', 'options' => $parentCategories, 'empty' => __('No Parent (top level)', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('name', array('label' => __('Name *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('meta_description', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-3 col-sm-offset-3 col-sm-6 col-md-6')));
		echo $form->input('meta_keywords', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-3 col-sm-offset-3 col-sm-6 col-md-6')));
	?>
	<?php echo $form->input('image', array('type' => 'file','class' => 'form-control', 'div' => array('class' => 'col-md-offset-3 col-sm-offset-3 col-sm-6 col-md-6')));?>
	</fieldset>
<?php echo $form->end(__('Add Category >>', true));?>
</div>

<?php echo $this->element('admin/required'); ?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to categories', true), array('action' => 'index'));?></li>
	</ul>
</div>
