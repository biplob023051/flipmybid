<?php
$html->addCrumb(__('Manage Auctions', true), '/admin/auctions');
$html->addCrumb(__('Products', true), '/admin/products');
echo $this->element('admin/crumb');
?>

<div class="auctions index">

<h2><?php __('Products');?></h2>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Add a Product', true), array('action' => 'add')); ?></li>
		<?php if($this->requestAction('/settings/enabled/reward_points') && $this->requestAction('/settings/get/rewards_store')) : ?>
			<?php if(!empty($rewardsOnly)) : ?>
				<li><?php echo $html->link(__('View All Products', true), array('action' => 'index')); ?></li>
			<?php else : ?>
				<li><?php echo $html->link(__('View Reward Products Only', true), array('action' => 'index', true)); ?></li>
			<?php endif; ?>
		<?php endif; ?>
	</ul>
</div>

<?php if(!empty($products)): ?>

<?php echo $this->element('admin/pagination'); ?>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('Title', 'title');?></th>
	<th><?php echo $paginator->sort('Category', 'Category.name');?></th>
	<th><?php echo $paginator->sort('rrp');?></th>
	<?php if(!empty($rewardsOnly)) : ?>
		<th><?php echo $paginator->sort('reward_points');?></th>
	<?php else : ?>
		<th><?php echo $paginator->sort('start_price');?></th>
	<?php endif; ?>
	<th class="actions"><?php __('Options');?></th>
</tr>
<?php
$i = 0;
foreach ($products as $product):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $product['Product']['title']; ?>
		</td>
		<td>
			<?php echo $html->link($product['Category']['name'], array('admin' => false, 'controller'=> 'categories', 'action'=>'view', $product['Category']['id']), array('target' => '_blank')); ?>
		</td>
		<td>
			<?php if(!empty($product['Product']['rrp'])) : ?>
				<?php echo $number->currency($product['Product']['rrp'], $appConfigurations['currency']); ?>
			<?php else: ?>
				n/a
			<?php endif; ?>
		</td>
		<td>
			<?php if(!empty($rewardsOnly)) : ?>
				<?php echo $product['Product']['reward_points']; ?>
			<?php else : ?>
				<?php echo $number->currency($product['Product']['start_price'], $appConfigurations['currency']); ?>
			<?php endif; ?>
		</td>
		<td class="actions">
			<?php if($this->requestAction('/settings/enabled/multi_languages')) : ?>
				<?php echo $html->link(__('Edit', true), array('action' => 'translations', $product['Product']['id'])); ?>
			<?php else : ?>
				<?php echo $html->link(__('Edit', true), array('action' => 'edit', $product['Product']['id'])); ?>
			<?php endif; ?>
			/ <?php echo $html->link(__('Images', true), array('controller' => 'images', 'action' => 'index', $product['Product']['id'])); ?>
			<?php if(empty($rewardsOnly)) : ?>
				/ <?php echo $html->link(__('Create Auction', true), array('controller' => 'auctions', 'action' => 'add', $product['Product']['id'])); ?>
			<?php endif; ?>
			<?php if(!empty($product['Auction'])) : ?>
					/ <?php echo $html->link(__('Auctions', true), array('action' => 'auctions', $product['Product']['id'])); ?>
			<?php else: ?>
				/ <?php echo $html->link(__('Delete', true), array('action' => 'delete', $product['Product']['id']), null, sprintf(__('Are you sure you want to delete product titled: %s?', true), $product['Product']['title'])); ?>
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('admin/pagination'); ?>

<?php else: ?>
	<p><?php __('There are no products at the moment.');?></p>
<?php endif; ?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Add a Product', true), array('action' => 'add')); ?></li>
		<?php if($this->requestAction('/settings/enabled/reward_points') && $this->requestAction('/settings/get/rewards_store')) : ?>
			<?php if(!empty($rewardsOnly)) : ?>
				<li><?php echo $html->link(__('View All Products', true), array('action' => 'index')); ?></li>
			<?php else : ?>
				<li><?php echo $html->link(__('View Reward Products Only', true), array('action' => 'index', true)); ?></li>
			<?php endif; ?>
		<?php endif; ?>
	</ul>
</div>
