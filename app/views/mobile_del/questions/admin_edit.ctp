<?php
$html->addCrumb(__('Manage News', true), '/admin/news');
$html->addCrumb('Sections', '/admin/sections');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller'].'/'.$section['Section']['id']);
$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/add/'.$id.'/'.$language);
echo $this->element('admin/crumb');
?>

<div class="questions form">
<?php echo $form->create(null, array('url' => '/admin/'.$this->params['controller'].'/edit/'.$id.'/'.$language));?>
	<fieldset>
 		<legend>Edit a Question</legend>
	<?php
		echo $form->input('question', array('label' => 'Question *'));
	?>

	<label for="PageContent"><?php __('Answer *');?></label>
	<?php echo $fck->input('Question.answer'); ?>

	</fieldset>
<?php echo $form->end('Save Changes');?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link('<< Back to questions', array('action' => 'view', $section['Section']['id']));?></li>
	</ul>
</div>
