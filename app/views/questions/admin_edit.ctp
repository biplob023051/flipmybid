<?php
$html->addCrumb(__('Manage News', true), '/admin/news');
$html->addCrumb('Sections', '/admin/sections');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller'].'/'.$section['Section']['id']);
$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/add/'.$id.'/'.$language);
echo $this->element('admin/crumb');
?>
<h2><?php echo __('Edit a Question') ?></h2>
<div class="questions form">
<?php echo $form->create(null, array('url' => '/admin/'.$this->params['controller'].'/edit/'.$id.'/'.$language));?>
	<fieldset>
	<?php
		echo $form->input('question', array('label' => 'Question *', 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
	?>
<div class="clearfix"></div>
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
