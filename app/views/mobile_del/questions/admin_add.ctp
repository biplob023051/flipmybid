<?php
$html->addCrumb(__('Manage News', true), '/admin/news');
$html->addCrumb(__('Sections', true), '/admin/sections');
$html->addCrumb($section['Section']['name'], '/admin/'.$this->params['controller'].'/view/'.$section['Section']['id']);
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add/'.$section['Section']['id']);
echo $this->element('admin/crumb');
?>

<div class="questions form">
<?php echo $form->create(null, array('url' => '/admin/questions/add/'.$section['Section']['id']));?>
	<fieldset>
 		<legend>Add a Question for the section: <?php echo $section['Section']['name']; ?></legend>
	<?php
		echo $form->input('question', array('label' => 'Question *'));
	?>

	<label for="PageContent"><?php __('Answer *');?></label>
	<?php echo $fck->input('Question.answer'); ?>

	</fieldset>
<?php echo $form->end('Add Question');?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link('<< Back to questions', array('action' => 'view', $section['Section']['id']));?></li>
	</ul>
</div>
