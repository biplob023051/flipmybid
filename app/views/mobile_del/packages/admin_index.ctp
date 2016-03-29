<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
echo $this->element('admin/crumb');
?>

<div class="bidPackages index">
<h2><?php __('Packages');?></h2>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Create a new package', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<?php if($paginator->counter() > 0):?>

<?php echo $this->element('admin/pagination'); ?>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('Number of Bids', 'bids');?></th>

	<?php if(Configure::read('App.rewardsPoint')):?>
		<th><?php echo $paginator->sort('Points', 'PackagePoint.points');?></th>
	<?php endif;?>

	<th><?php echo $paginator->sort('price');?></th>
	<th class="actions"><?php __('Options');?></th>
</tr>
<?php
$i = 0;
foreach ($packages as $package):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $package['Package']['name']; ?>
		</td>
		<td>
			<?php echo $package['Package']['bids']; ?>
		</td>

		<?php if(Configure::read('App.rewardsPoint')):?>
		<td>
			<?php echo $package['PackagePoint']['points'];?>
		</td>
		<?php endif;?>

		<td>
			<?php echo $number->currency($package['Package']['price'], $appConfigurations['currency']); ?>
		</td>
		<td class="actions">
			<?php if($this->requestAction('/settings/enabled/multi_languages')) : ?>
				<?php echo $html->link(__('Edit', true), array('action'=>'translations', $package['Package']['id'])); ?>
			<?php else : ?>
				<?php echo $html->link(__('Edit', true), array('action'=>'edit', $package['Package']['id'])); ?>
			<?php endif; ?>
			/ <?php echo $html->link(__('Delete', true), array('action' => 'delete', $package['Package']['id']), null, sprintf(__('Are you sure you want to delete this package named: %s?', true), $package['Package']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('admin/pagination'); ?>

<?php else:?>
	<p><?php __('There are no packages at the moment.');?></p>
<?php endif;?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Create a new bid package', true), array('action' => 'add')); ?></li>
	</ul>
</div>
