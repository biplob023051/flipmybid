<?php
$html->addCrumb(__('Manage Auctions', true), '/admin/auctions');
$html->addCrumb(__('Bids Placed', true), '/admin/bids');
echo $this->element('admin/crumb');
?>

<div class="auctions index">

<h2><?php __('Bids Placed');?></h2>

<?php if($paginator->counter() > 0):?>

<?php echo $this->element('admin/pagination'); ?>
<div class="table-responsive">
<table class="table table-condensed table-striped" cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('Auction ID', 'Auction.id');?></th>
	<th><?php echo $paginator->sort('Username', 'User.username');?></th>
	<th><?php echo $paginator->sort('Auction Title', 'Auction.id');?></th>
	<th><?php echo $paginator->sort('Bid Type', 'Bid.description');?></th>
	<th><?php echo $paginator->sort('Date Placed', 'Bid.created');?></th>
	<th class="actions"><?php __('Options');?></th>
</tr>
<?php
$i = 0;
foreach ($bids as $bid):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $bid['Auction']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($bid['User']['username'], array('controller'=> 'users', 'action' => 'edit', $bid['User']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($bid['Auction']['Product']['title'], array('admin' => false, 'controller'=> 'auctions', 'action'=>'view', $bid['Auction']['id']), array('target' => '_blank')); ?>
		</td>
		<td>
			<?php echo $bid['Bid']['description']; ?>
			- <?php __('Autobid');?>
		</td>
		<td>
			<?php echo $time->niceShort($bid['Bid']['created']); ?>
		</td>
		<td>
			<?php echo $html->link(__('View only this Auction', true), array('action' => 'auction', $bid['Auction']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>

<?php echo $this->element('admin/pagination'); ?>

<?php else: ?>
	<p><?php __('No bids have been placed on the site yet.');?></p>
<?php endif; ?>
</div>
