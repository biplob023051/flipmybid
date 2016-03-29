<?php
$html->addCrumb('Manage Auctions', '/admin/auctions');
if(!empty($extraCrumb)) :
	$html->addCrumb($extraCrumb['title'], '/admin/auctions/'.$extraCrumb['url']);
endif;
echo $this->element('admin/crumb');
?>

<div class="auctions index">

<h2><?php __('Auctions');?></h2>

<?php if(!empty($statuses)):?>
	View by status :
	<?php echo $form->create('Auction', array('action' => 'won'));?>
	<?php echo $form->input('status_id', array('id' => 'selectStatus', 'selected' => $selected, 'options' => $statuses, 'label' => false));?>
	<?php echo $form->end();?>
<?php endif;?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Manage your Products', true), array('controller' => 'products', 'action' => 'index')); ?></li>
	</ul>
</div>

<?php if($paginator->counter() > 0):?>

<?php echo $this->element('admin/pagination'); ?>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('ID', 'Auction.id');?></th>
	<th><?php echo $paginator->sort('Title', 'Product.title');?></th>
	<th><?php echo $paginator->sort('Category', 'Category.name');?></th>
	<th><?php echo $paginator->sort('Winner', 'Winner.username');?></th>
	<th><?php echo $paginator->sort('end_time');?></th>
	<th><?php echo $paginator->sort('Final Price', 'price');?></th>
	<th><?php echo $paginator->sort('RRP', 'rrp');?></th>
	<th><?php echo $paginator->sort('Status', 'Status.name');?></th>
	<th class="actions"><?php __('Options');?></th>
</tr>
<?php
$i = 0;
$totalDue = 0;
foreach ($auctions as $auction):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $auction['Auction']['id']; ?>
		</td>
		<td>
			<?php echo $auction['Product']['title']; ?>
		</td>
		<td>
			<?php echo $html->link($auction['Product']['Category']['name'], array('controller'=> 'categories', 'action'=>'edit', $auction['Product']['Category']['id']), array('target' => '_blank')); ?>
		</td>

		<td>
			<?php echo $html->link($auction['Winner']['username'], array('controller'=> 'users', 'action'=>'view', $auction['Winner']['id'])); ?>
		</td>

		<td>
			<?php echo $time->nice($auction['Auction']['end_time']); ?>
		</td>
		<td>
			<?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?>
		</td>
		<td><?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?></td>
		<?php $totalDue = $totalDue + $auction['Product']['rrp']; ?>
		<td>
			<?php if(!empty($auction['Status']['name'])) : ?>
				<?php echo $auction['Status']['name']; ?>
			<?php elseif(!empty($auction['Auction']['closed'])): ?>
				<?php if(!empty($auction['Winner']['autobidder'])) : ?>
					Shipped & Completed
				<?php else : ?>
					Closed
				<?php endif; ?>
			<?php elseif($auction['Auction']['end_time'] > time()): ?>
				Coming Soon
			<?php else : ?>
				Live
			<?php endif; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('admin' => false, 'action' => 'view', $auction['Auction']['id']), array('target' => '_blank')); ?>
			<?php if(!empty($auction['Winner']['id']) && !empty($auction['Auction']['closed'])) : ?>
				<?php if($auction['Winner']['autobidder'] == 0) : ?>
					/ <?php echo $html->link(__('View Winner', true), array('action' => 'winner', $auction['Auction']['id'])); ?>
				<?php endif; ?>
			<?php endif; ?>
			<?php if($this->requestAction('/settings/enabled/testing_mode')) : ?>
				/ <?php echo $html->link(__('Stats', true), array('action' => 'stats', $auction['Auction']['id'])); ?>
			<?php endif; ?>

				/ <?php echo $html->link(__('Bids Placed', true), array('controller' => 'bids', 'action' => 'auction', $auction['Auction']['id'])); ?>
				/ <?php echo $html->link(__('Refund Bids', true), array('action' => 'refund', $auction['Auction']['id']), null, sprintf(__('Are you sure you want to refund ALL the bids for this auction titled: %s?  This will delete ALL the bids on the auction to date and will delete the auction.', true), $auction['Product']['title'])); ?>

			/ <?php echo $html->link(__('Delete', true), array('action' => 'delete', $auction['Auction']['id']), null, sprintf(__('Are you sure you want to delete auction titled: %s?', true), $auction['Product']['title'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<p>Total Due: <?php echo $number->currency($totalDue, $appConfigurations['currency']); ?></p>

<?php echo $this->element('admin/pagination'); ?>

<?php else: ?>
	<p><?php __('There are no auctions at the moment.');?></p>
<?php endif; ?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Manage your Products', true), array('controller' => 'products', 'action' => 'index')); ?></li>
	</ul>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		if($('#selectStatus').length){
			$('#selectStatus').change(function(){
				location.href = '/admin/auctions/won/' + $('#selectStatus').val();
			});
		}
	});
</script>