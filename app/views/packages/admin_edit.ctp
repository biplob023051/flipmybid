<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/edit/'.$id.'/'.$language);
echo $this->element('admin/crumb');
?>

<div class="bidPackages form">
<?php echo $form->create(null, array('url' => '/admin/'.$this->params['controller'].'/edit/'.$id.'/'.$language));?>
	<fieldset>
 		<legend><?php __('Edit a Package');?></legend>
	<?php
		echo $form->input('name', array('label' => __('Name *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));

		if(empty($language)) {
			echo $form->input('bids', array('label' => __('Number of Bids *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
			echo $form->input('price', array('label' => __('Price *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4', 'style' => 'margin-bottom:10px;')));
			echo $form->input('special', array('label' => __('This is a special price', true)));

			if($this->requestAction('settings/enabled/reward_points')) {
				echo $form->input('points', array('label' => __('Reward Points', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
			}
		}
	?>
	</fieldset>
<?php echo $form->end(__('Save Changes', true));?>
</div>

<?php echo $this->element('admin/required'); ?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to packages', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('Delete package', true), array('action' => 'delete', $form->value('id')), null, sprintf(__('Are you sure you want to delete this package?', true))); ?></li>
	</ul>
</div>
