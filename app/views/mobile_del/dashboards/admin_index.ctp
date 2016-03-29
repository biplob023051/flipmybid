<?php
$html->addCrumb(__('Dashboard', true), '/admin');
echo $this->element('admin/crumb');
?>

<h1><?php __('Online Users / Visitors');?></h1>
<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?php __('Server Load');?></th>
		<th><?php __('Users');?></th>
		<th><?php __('Visitors');?></th>
		<th><?php __('Total');?></th>
	</tr>

	<tr>
		<td><?php echo $serverLoad; ?></td>
		<td><?php echo $onlineUsers; ?></td>
		<td><?php echo $onlineVisitors; ?></td>
		<td><strong><?php echo $onlineUsers + $onlineVisitors; ?></strong></td>
	</tr>
</table>


<h1><?php __('Bid Purchases');?></h1>

<ul class="admin-cat-menus">
		<li>
			<p><?php __('Today:');?> <?php echo $number->currency($dailyIncome, $appConfigurations['currency']); ?></p>
			<p><?php __('This Time Yesterday:');?> <?php echo $number->currency($thisTimeYesterdayIncome, $appConfigurations['currency']); ?></p>
			<p><?php __('Yesterday:');?> <?php echo $number->currency($yesterdayIncome, $appConfigurations['currency']); ?></p>
		</li>
		<li>
			<p><?php __('Last 7 days:');?> <?php echo $number->currency($weeklyIncome, $appConfigurations['currency']); ?></p>
			<p><?php __('Previous 7 days:');?> <?php echo $number->currency($lastweekIncome, $appConfigurations['currency']); ?></p>
			<p><?php __('Outstanding Bids:');?> <?php echo $outstandingBids; ?></p>
		</li>
		<li>
			<p><?php __('This Month:');?> <?php echo $number->currency($monthlyIncome, $appConfigurations['currency']); ?></p>
			<p><?php __('Last Month:');?> <?php echo $number->currency($lastmonthIncome, $appConfigurations['currency']); ?></p>
		</li>
	</ul>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('View package purchases', true), array('controller' => 'accounts', 'action' => 'index')); ?></li>
		<li><?php echo $html->link(__('Online Users', true), array('controller' => 'users', 'action' => 'online')); ?></li>
	</ul>
</div>