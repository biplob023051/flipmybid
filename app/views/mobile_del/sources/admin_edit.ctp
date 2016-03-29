<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
echo $this->element('admin/crumb');
?>

<div class="sources form">
<?php echo $form->create('Source', array('url' => '/admin/sources/edit/'.$id.'/'.$language));?>
	<fieldset>
 		<legend><?php __('Edit Source');?></legend>
	<?php
		echo $form->input('name');
		if(empty($language)) {
			echo $form->input('extra');
		}
	?>
	</fieldset>
<?php echo $form->end(__('Submit', true));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to sources', true), array('action'=>'index'));?></li>
	</ul>
</div>
