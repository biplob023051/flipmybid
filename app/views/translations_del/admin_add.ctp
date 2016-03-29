<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(__('Languages', true), '/admin/languages');
$html->addCrumb(__('Translations', true), '/admin/translations/view/'.$language['Language']['id']);
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add/'.$language['Language']['id']);
echo $this->element('admin/crumb');
?>

<div class="languages form">
<?php echo $form->create(null, array('url' => '/admin/translations/add/'.$language['Language']['id']));?>
	<fieldset>
 		<legend><?php __('Add a Translation');?></legend>

 		<p>
 		 	<?php __('Use this form to add a translation that doesn\'t exist in the default.po file.'); ?>
 		 	<?php __('When adding a translation refer to'); ?> <a target="_blank" href="http://book.cakephp.org/view/1228/Internationalization-Localization"><?php __('Cake PHP\'s Internationalization documentation.'); ?></a>
			<?php __('If you need further assistance please <a target="_blank" href="http://www.pennyauctioncode.com">contact us</a>.'); ?>
 		</p>
	<?php
		echo $form->input('msgid');
		echo $form->input('msgstr');
		echo $form->input('reference');
	?>
	</fieldset>
<?php echo $form->end(__('Add a Translation', true));?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to translations', true), array('action' => 'view', $language['Language']['id']));?></li>
	</ul>
</div>
