<?php
$html->addCrumb(__('Manage Content', true), '/admin/pages');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add');
echo $this->element('admin/crumb');
?>

<h2><?php __('Add a Page');?></h2>

<div class="pages form">
<?php echo $form->create('Page');?>
	<fieldset>
	<?php
		echo $form->input('name', array('label' => __('Page Name *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('title', array('label' => __('Meta Title *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
	?>
<div class="clearfix"></div>
	<label for="PageContent"><?php __('Content *');?></label>
	<?php echo $fck->input('Page.content'); ?>

	<?php
		echo $form->input('meta_description', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('meta_keywords', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4', 'style' => 'margin-bottom:10px;')));
		echo $form->input('top_show', array('label' => __('Show this page in the top menu?', true)));
		echo $form->input('bottom_show', array('label' => __('Show this page in the bottom menu?', true)));
	?>

	</fieldset>
<?php echo $form->end(__('Add Page', true));?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to pages', true), array('action' => 'index'));?></li>
	</ul>
</div>
