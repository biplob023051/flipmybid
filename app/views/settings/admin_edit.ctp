<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
if(!empty($setting['Module']['name'])) {
	$html->addCrumb(Inflector::humanize($setting['Module']['name']), '/admin/settings/module/'.$setting['Setting']['module_id']);
}
if(!empty($setting['Parent']['name'])) {
	$html->addCrumb(Inflector::humanize($setting['Parent']['name']), '/admin/settings/advanced/'.$setting['Setting']['setting_id']);
}

$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/edit/'.$setting['Setting']['id']);

echo $this->element('admin/crumb');
?>
<h2><?php echo sprintf(__('Edit the %s setting', true), Inflector::humanize($setting['Setting']['name']));?></h2>
<div class="settings form">
<?php echo $form->create('Setting');?>
	<fieldset>
		<div class="col-md-4 col-sm-4 col-sm-offset-4 col-md-offset-4">
 		<?php if(!empty($setting['Setting']['description'])) : ?>
 			<?php echo nl2br($setting['Setting']['description']); ?>
 		<?php endif; ?>
		</div>
		<div class="clearfix"></div>
	<?php
		echo $form->input('id');

		if(!empty($options)) {
			echo $form->input('value', array('label' => __('Value *', true), 'options' => $options, 'empty' => __('Select', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		} else {
			echo $form->input('value', array('label' => __('Value *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		}
	?>
	</fieldset>
<?php echo $form->end(__('Save Changes', true));?>
</div>

<?php echo $this->element('admin/required'); ?>

<div class="actions">
	<ul>
		<li>
		<?php
		if(!empty($setting['Setting']['setting_id'])) {
			echo $html->link(__('<< Back to settings', true), array('action'=>'advanced', $setting['Setting']['setting_id']));
		} elseif(!empty($setting['Setting']['module_id'])) {
			echo $html->link(__('<< Back to settings', true), array('action'=>'module', $setting['Setting']['module_id']));
		} else {
			echo $html->link(__('<< Back to settings', true), array('action'=>'index'));
		}
		?>
		</li>
	</ul>
</div>
