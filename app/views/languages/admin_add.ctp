<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add');
echo $this->element('admin/crumb');
?>
<h2><?php __('Add a Language');?></h2>
<div class="languages form">
<?php echo $form->create();?>
	<fieldset>
 		<p>
 		 	<?php __('When adding a language refer to'); ?> <a target="_blank" href="http://book.cakephp.org/view/1228/Internationalization-Localization"><?php __('Cake PHP\'s Internationalization documentation.'); ?></a>
			<?php __('If you need further assistance please <a target="_blank" href="http://www.pennyauctioncode.com">contact us</a>.'); ?>
 		</p>
	<?php
		echo $form->input('name', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('code', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('theme', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4', 'style' => 'margin-bottom:10px;')));
		echo $form->input('default');
	?>
	</fieldset>
<?php echo $form->end(__('Add a Language', true));?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to languages', true), array('action' => 'index'));?></li>
	</ul>
</div>
