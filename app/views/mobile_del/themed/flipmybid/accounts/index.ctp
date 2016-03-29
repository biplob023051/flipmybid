<div class="g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('Account History');?></h2>
		</div>
		<div class="account">
			<div class="">
				<?php if(!empty($accounts)): ?>
					<div class="paging-auct">
						<?php echo $this->element('pagination'); ?>
                    </div>

					<table class="default-table" width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr class="headings">
							<td><?php echo $paginator->sort('Date', 'created');?></td>
							<td><?php echo $paginator->sort('Description', 'Account.name');?></td>
							<td><?php echo $paginator->sort('Amount', 'Auction.price');?></td>
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

					<div class="paging-auct">
						<?php echo $this->element('pagination'); ?>
                    </div>

				<?php else:?>
					<p><?php __('You have no account transations at the moment.');?></p>
				<?php endif;?>

			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>