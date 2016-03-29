<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
echo $this->element('admin/crumb');
?>

<div class="settings index">

<h2><?php __('Settings');?></h2>

<?php echo $this->element('admin/pagination'); ?>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th><?php echo $paginator->sort('value');?></th>
	<th class="actions"><?php __('Options');?></th>
</tr>
<?php
$i = 0;
foreach ($settings as $setting):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo Inflector::humanize($setting['Setting']['name']); ?>
		</td>
		<td>
			<?php echo $setting['Setting']['description']; ?>
		</td>
		<td>
			<?php if(!empty($setting['Setting']['options'])) {
				if($setting['Setting']['value'] == '1') {
					__('Yes');
				} elseif($setting['Setting']['value'] == '0') {
					__('No');
				} else {
					echo $setting['Setting']['value'];
				}
			} else {
				echo $setting['Setting']['value'];
			} ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $setting['Setting']['id'])); ?>
			<?php if(!empty($setting['Setting']['value']) && (!empty($setting['Setting']['options']) || empty($setting['Setting']['options']))) : ?>
				<?php if($this->requestAction('/settings/count/'.$setting['Setting']['id'].'/advanced') > 0) : ?>
					/ <?php echo $html->link(__('Advanced Settings', true), array('controller' => 'settings', 'action'=>'advanced', $setting['Setting']['id'])); ?>
				<?php endif; ?>
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<?php echo $this->element('admin/pagination'); ?>