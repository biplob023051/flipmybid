<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);

echo $this->element('admin/crumb');
?>

<div class="memberships index">

<h2><?php __('Memberships');?></h2>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Create a new membership level', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<?php if(!empty($memberships)):?>

<?php echo $this->element('admin/pagination'); ?>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('rank');?></th>
	<th><?php echo $paginator->sort('default');?></th>
	<th class="actions"><?php __('Options');?></th>
</tr>
<?php
$i = 0;
foreach ($memberships as $membership):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td><?php echo $membership['Membership']['name']; ?></td>
		<td><?php echo $membership['Membership']['rank']; ?></td>
		<td><?php if(!empty($membership['Membership']['rank'])) : ?><?php __('Yes'); ?><?php else : ?><?php __('No'); ?><?php endif; ?></td>
		<td class="actions">
			<?php if($this->requestAction('/settings/enabled/multi_languages')) : ?>
				<?php echo $html->link(__('Edit', true), array('action'=>'translations', $membership['Membership']['id'])); ?>
			<?php else : ?>
				<?php echo $html->link(__('Edit', true), array('action'=>'edit', $membership['Membership']['id'])); ?>
			<?php endif; ?>
			/ <?php echo $html->link(__('Delete', true), array('action'=>'delete', $membership['Membership']['id']), null, sprintf(__('Are you sure you want to delete the membership named: %s?', true), $membership['Membership']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('admin/pagination'); ?>

<?php else:?>
	<p><?php __('There are no memberships at the moment.');?>
<?php endif;?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Create a new membership level', true), array('action' => 'add')); ?></li>
	</ul>
</div>