<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(__('Languages', true), '/admin/languages');
$html->addCrumb($language['Language']['name'], '/admin/translations/view/'.$language['Language']['id']);
echo $this->element('admin/crumb');
?>

<div class="translations index">

<h2><?php __('Translations for:'); ?> <?php echo $language['Language']['name']; ?></h2>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Add a new Translation', true), array('action' => 'add', $language['Language']['id'])); ?></li>
	</ul>
</div>

<?php echo $form->create('Translation', array('url' => '/admin/translations/view/'.$language['Language']['id']));?>
	<?php echo $form->input('search', array('label' => 'Search specific phase: ', 'after' => $form->submit(__('Search', true), array('div' => false))));?>
<?php echo $form->end(); ?>

<?php if($paginator->counter() > 0):?>

<p><?php __('To update the translations, edit the translation in the "Msgstr" text box and click on "Save Changes" at the bottom of the page when you are done. The text will be updated on the website instantly.'); ?></p>

<?php echo $this->element('admin/pagination'); ?>

<?php echo $form->create('Translation', array('url' => '/admin/translations/view/'.$language['Language']['id']));?>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('msgid');?></th>
	<th><?php echo $paginator->sort('msgstr');?></th>
	<th><?php echo $paginator->sort('reference');?></th>
</tr>

<?php
$i = 0;
foreach ($translations as $translation):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td><?php echo $translation['Translation']['msgid']; ?></td>
		<td><?php echo $form->input('msgstr.'.$translation['Translation']['id'], array('type' => 'textbox', 'value' => $translation['Translation']['msgstr'], 'label' => false, 'cols' => 65)); ?></td>
		<td><?php echo $translation['Translation']['reference']; ?></td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $form->end(__('Save Changes >>', true));?>

<?php echo $this->element('admin/pagination'); ?>

<?php elseif(!empty($search)) : ?>
	<p>Your search returned no results.  Please try again!</p>
<?php else:?>
	<p>There are no translation in this language.  The default.po file needs to be created and added to the app/locale/<?php echo $language['Language']['code']; ?>/LC_MESSAGES directory.</p>
<?php endif;?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Add a new Translation', true), array('action' => 'add', $language['Language']['id'])); ?></li>
	</ul>
</div>

</div>