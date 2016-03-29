<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(__('Auction Statuses', true), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/edit/'.$id.'/'.$language);
echo $this->element('admin/crumb');
?>

<?php echo $form->create(null, array('url' => '/admin/statuses/edit/'.$id.'/'.$language));?>
	<fieldset>
 		<legend><?php __('Edit a Status');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('message', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
	?>
	</fieldset>
<?php echo $form->end(__('Save Changes', true));?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to statuses', true), array('action' => 'index'));?></li>
	</ul>
</div>
