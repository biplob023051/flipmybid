<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(__('Modules', true), '/admin/modules');
echo $this->element('admin/crumb');
?>

<div class="modules index">

<h2><?php __('Modules');?></h2>

<?php echo $this->element('admin/pagination'); ?>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('active');?></th>
	<th class="actions"><?php __('Options');?></th>
</tr>
<?php
$i = 0;
foreach ($modules as $module):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>

			<?php if(!empty($module['Module']['description'])) : ?>
				<a alt="<?php echo addslashes($module['Module']['description']); ?>" title="<?php echo addslashes($module['Module']['description']); ?>"><?php echo Inflector::humanize($module['Module']['name']); ?></a>
			<?php else : ?>
				<?php echo Inflector::humanize($module['Module']['name']); ?>
			<?php endif; ?>
		</td>
		<td>
			<?php if(!empty($module['Module']['show_active'])) : ?>
				<?php if(!empty($module['Module']['active'])) : ?><?php __('Yes'); ?><?php else : ?><?php __('No'); ?><?php endif; ?>
			<?php else : ?>
				<?php __('Yes'); ?>
			<?php endif; ?>
		</td>
		<td class="actions">
			<?php if(!empty($module['Module']['show_active'])) : ?>
				<?php if(!empty($module['Module']['active'])) : ?>
					<?php echo $html->link(__('Disable', true), array('action' => 'disable', $module['Module']['id']), null, sprintf(__('Are you sure you want to disable the module: %s?', true), Inflector::humanize($module['Module']['name']))); ?>
					<?php if($this->requestAction('/settings/count/'.$module['Module']['id']) > 0) : ?>
						/ <?php echo $html->link(__('Edit Settings', true), array('controller' => 'settings', 'action'=>'module', $module['Module']['id'])); ?>
					<?php endif; ?>
				<?php else : ?>
					<?php echo $html->link(__('Enable', true), array('action' => 'enable', $module['Module']['id']), null, sprintf(__('Are you sure you want to enable the module: %s?', true), Inflector::humanize($module['Module']['name']))); ?>
				<?php endif; ?>
			<?php else : ?>
				<?php echo $html->link(__('Edit Settings', true), array('controller' => 'settings', 'action'=>'module', $module['Module']['id'])); ?>

			<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<?php echo $this->element('admin/pagination'); ?>
