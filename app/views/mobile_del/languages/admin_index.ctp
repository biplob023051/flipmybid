<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
echo $this->element('admin/crumb');
?>

<div class="languages index">

<h2><?php __('Languages');?></h2>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Add a Language', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<?php if($paginator->counter() > 0):?>

<?php echo $this->element('admin/pagination'); ?>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('default');?></th>
	<th class="actions"><?php __('Options');?></th>
</tr>
<?php
$i = 0;
foreach ($languages as $language):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $language['Language']['name']; ?>
		</td>
		<td>
			<?php if(!empty($language['Language']['default'])) : ?><?php __('Yes'); ?><?php else : ?><?php __('No'); ?><?php endif; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $language['Language']['id'])); ?>
			/ <?php echo $html->link(__('Translate Site Text', true), array('controller' => 'translations', 'action'=>'view', $language['Language']['id'])); ?>
			/ <?php echo $html->link(__('Delete', true), array('action' => 'delete', $language['Language']['id']), null, sprintf(__('Are you sure you want to delete the language: %s? Do not delete a language unless you are sure of what you are doing!', true), $language['Language']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('admin/pagination'); ?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Add a Language', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<?php else:?>
	<p><?php __('There are no languages at the moment');?></p>
<?php endif;?>
</div>
