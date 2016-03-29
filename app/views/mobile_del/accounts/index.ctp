<div id="left">
    <?php echo $this->element('menu_user');?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('Account History');?></h1>
		<p>

		<?php if(!empty($accounts)): ?>
			<?php echo $this->element('pagination'); ?>

			<table width="100%" class="table" cellpadding="0" cellspacing="0">
				<thead>
					<th><?php echo $paginator->sort('Date', 'created');?></th>
					<th><?php echo $paginator->sort('Description', 'Account.name');?></th>
					<th><?php echo $paginator->sort('Amount', 'Auction.price');?></th>
				</thead>
			<?php
			$i = 0;
			foreach ($accounts as $account):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
				<tr<?php echo $class;?>>
					<td>
						<?php echo $time->niceShort($account['Account']['created']); ?>
					</td>
					<td>
						<?php echo $account['Account']['name']; ?>
						<?php if($account['Account']['bids']) : ?>
							- <?php echo sprintf(__('%d Bids Purchased', true), $account['Account']['bids']); ?>
						<?php endif; ?>
					</td>
					<td>
						<?php echo $number->currency($account['Account']['price'], $appConfigurations['currency']); ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</table>

			<?php echo $this->element('pagination'); ?>

		<?php else:?>
			<p><?php __('You have no account transations at the moment.');?></p>
		<?php endif;?>

		<div class="clear"></div>
	</div>
</div>