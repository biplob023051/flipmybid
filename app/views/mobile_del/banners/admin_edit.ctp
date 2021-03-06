<?php
$html->addCrumb(__('Manage Content', true), '/admin/pages');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Edit', true), '/admin/banners/edit/'.$this->data['Banner']['id']);
echo $this->element('admin/crumb');
?>

<div class="categories form">
<?php echo $form->create('Banner');?>
	<fieldset>
 		<legend><?php __('Edit Banner');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('description', array('label' => __('Description *', true)));
		echo $form->input('code', array('label' => __('Banner Code *', true)));
		echo $form->input('order');
		echo $form->input('url');
		echo $form->input('banner_location_id', array('type' => 'select', 'options' => $banner_locations));
	?>

	</fieldset>
<?php echo $form->end(__('Save Changes', true));?>
</div>

<?php echo $this->element('admin/required'); ?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to banners', true), array('action' => 'index'));?></li>
	</ul>
</div>
