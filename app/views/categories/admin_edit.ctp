<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Edit', true), '/admin/categories/edit/'.$id.'/'.$language);
echo $this->element('admin/crumb');
?>
<h2><?php __('Edit Category');?></h2>
<div class="categories form">
<?php echo $form->create('Category', array('type' => 'file', 'url' => '/admin/categories/edit/'.$id.'/'.$language));?>
	<fieldset>

	<?php if(empty($language)) : ?>
		<label for="CategoryParentId"><?php __('Parent Category');?></label>
	<?php echo $form->select('parent_id', $parentCategories, null, array('empty' => __('No Parent (top level)', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4'))); ?>
	<?php endif; ?>

	<?php
		echo $form->input('name', array('label' => __('Name *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('meta_description', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-3 col-sm-offset-3 col-sm-6 col-md-6')));
		echo $form->input('meta_keywords', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-3 col-sm-offset-3 col-sm-6 col-md-6')));
	?>

	<?php if(!empty($this->data['Category']['image']) && (!is_array($this->data['Category']['image']))) : ?>
			<div class="clearfix"></div>
	<label><?php __('Current Image');?>:</label>
	<div><?php echo $html->image('category_images/max/'.$this->data['Category']['image']); ?></div>
	<label>&nbsp;</label>
	<?php echo $form->checkbox('image_delete', array('value' => $this->data['Category']['id'])); ?> Delete this image?
	<?php endif; ?>

	<?php if(empty($language)) {
		echo $form->input('image', array('type' => 'file','class' => 'form-control', 'div' => array('class' => 'col-md-offset-3 col-sm-offset-3 col-sm-6 col-md-6')));
	} ?>

	</fieldset>
<?php echo $form->end(__('Save Changes', true));?>
</div>

<?php echo $this->element('admin/required'); ?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to categories', true), array('action'=>'index'));?></li>
		<?php if(!empty($this->data['ChildCategory'])) : ?>
         		<li><?php echo $html->link(__('View Child Categories', true), array('action' => 'index', $form->value('Category.id'))); ?></li>
        <?php elseif(empty($this->data['Auction'])) : ?>
				<li><?php echo $html->link(__('Delete category', true), array('action' => 'delete', $form->value('Category.id')), null, sprintf(__('Are you sure you want to delete this category?', true))); ?></li>
		<?php endif; ?>
	</ul>
</div>
