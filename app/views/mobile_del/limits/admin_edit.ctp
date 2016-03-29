<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(__('Win Limits', true), '/admin/limits');
$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/edit/'.$id.'/'.$language);
echo $this->element('admin/crumb');
?>

<div class="limits form">
<?php echo $form->create(null, array('url' => '/admin/limits/edit/'.$id.'/'.$language));?>
	<fieldset>
 		<legend><?php __('Edit a Win Limit');?></legend>
	<?php
		echo $form->input('name', array('label' => __('Name *', true)));
		if(empty($language)) {
			echo $form->input('limit', array('label' => __('Limit * (max no. of auctions)', true)));
			echo $form->input('days', array('label' => __('Days * (number of days)', true)));
		}
	?>
	</fieldset>
<?php echo $form->end(__('Save Changes', true));?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to win limits', true), array('action' => 'index'));?></li>
	</ul>
</div>
