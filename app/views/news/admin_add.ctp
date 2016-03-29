<?php
$html->addCrumb(__('Manage News', true), '/admin/news');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add');
echo $this->element('admin/crumb');
?>

<div class="news form">
<?php echo $form->create('News');?>
	<fieldset>
 		<legend><?php __('Add a News Article');?></legend>
	<?php
		echo $form->input('title', array('label' => 'Title *', 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('brief', array('label' => 'Brief *', 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		?>
		<div class="clearfix"></div>
		<label for="NewsContent"><?php __('Content *');?></label>
		<?php echo $fck->input('News.content'); ?>
		<?php
		echo $form->input('meta_description', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('meta_keywords', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
	?>
	</fieldset>
<?php echo $form->end(__('Add Article', true));?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to news articles', true), array('action' => 'index'));?></li>
	</ul>
</div>
