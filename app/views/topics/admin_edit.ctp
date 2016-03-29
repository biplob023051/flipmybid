<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(__('Forum Topics', true), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/edit/'.$id.'/'.$language);
echo $this->element('admin/crumb');
?>
<h2><?php __('Edit a Topic');?></h2>
<div class="topics form">
<?php echo $form->create(null, array('url' => '/admin/topics/edit/'.$id.'/'.$language));?>
	<fieldset>
	<?php
		echo $form->input('name', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('description', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
	?>
	</fieldset>
<?php echo $form->end(__('Save Changes', true));?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to topics', true), array('action' => 'index'));?></li>
	</ul>
</div>
