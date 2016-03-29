<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(__('Win Limits', true), '/admin/limits');
echo $this->element('admin/crumb');
?>

<div class="limits index">

<h2><?php __('Win Limits');?></h2>

<p><?php __('Win limits allow you to limit the number of auctions that users can win within a certain number of days.'); ?></p>

<p><?php __('If you enter in only one win limit then this will act as your site wide win limits. You might call this "Standard". When creating an auction you can then select this from the Win Limit dropdown for it to be applied.'); ?></p>

<p><?php __('Alternatively you might create mulitple win limit options. For example "Standard Auctions", "Free Bid Auctions". You can then select the win limit category that best applies when creating an auction.'); ?></p>

<p><?php __('Win Limits can still be optional. For them to apply to an auction you need to select a category from the Win Limits dropdown.'); ?></p>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Add a new win limit', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<?php if($paginator->counter() > 0): ?>

<?php echo $this->element('admin/pagination'); ?>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('limit');?></th>
	<th><?php echo $paginator->sort('days');?></th>
	<th class="actions"><?php __('Options');?></th>
</tr>
<?php
$i = 0;
foreach ($limits as $limit):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td><?php echo $limit['Limit']['name']; ?></td>
		<td><?php echo $limit['Limit']['limit']; ?></td>
		<td><?php echo $limit['Limit']['days']; ?></td>
		<td class="actions">
			<?php if($this->requestAction('/settings/enabled/multi_languages')) : ?>
				<?php echo $html->link(__('Edit', true), array('action'=>'translations', $limit['Limit']['id'])); ?>
			<?php else : ?>
				<?php echo $html->link(__('Edit', true), array('action'=>'edit', $limit['Limit']['id'])); ?>
			<?php endif; ?>
			/ <?php echo $html->link(__('Delete', true), array('action'=>'delete', $limit['Limit']['id']), null, sprintf(__('Are you sure you want to delete the win limit named: %s?', true), $limit['Limit']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('admin/pagination'); ?>

<?php else:?>
	<p><?php __('There are no win limits at the moment.');?></p>
<?php endif;?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Add a new win limit', true), array('action' => 'add')); ?></li>
	</ul>
</div>