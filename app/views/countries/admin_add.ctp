<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add');
echo $this->element('admin/crumb');
?>
<h2><?php __('Add a Country');?></h2>
<div class="countries form">
<?php echo $form->create();?>
	<fieldset>
	<?php
		echo $form->input('name', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-3 col-sm-offset-3 col-sm-6 col-md-6')));
		echo $form->input('code', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-3 col-sm-offset-3 col-sm-6 col-md-6', 'style' => 'margin-bottom:10px')));
		echo $form->input('show_first', array('label' => __('Show this country at the top of the country list.', true)));
	?>
	</fieldset>
<?php echo $form->end(__('Add Country', true));?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to countries', true), array('action' => 'index'));?></li>
	</ul>
</div>
