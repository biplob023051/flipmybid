<?php
$html->addCrumb(__('General Settings', true), '/admin/settings');
$html->addCrumb('Address Types', '/admin/'.$this->params['controller']);
echo $this->element('admin/crumb');
?>

<div class="user_address_types index">

<h2>Address Types</h2>

<?php if($paginator->counter() > 0):?>

<?php echo $this->element('admin/pagination'); ?>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th class="actions"><?php __('Options');?></th>
</tr>
<?php
$i = 0;
foreach ($types as $type):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $type['UserAddressType']['name']; ?>
		</td>
		<td class="actions">
			<?php if($this->requestAction('/settings/enabled/multi_languages')) : ?>
				<?php echo $html->link(__('Edit', true), array('action'=>'translations', $type['UserAddressType']['id'])); ?>
			<?php else : ?>
				<?php echo $html->link(__('Edit', true), array('action'=>'edit', $type['UserAddressType']['id'])); ?>
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('admin/pagination'); ?>

<?php else:?>
	<p><?php __('There are no address types at the moment.');?></p>
<?php endif;?>
</div>