<div class="col-md-12 auctions">
<div class="nav nav-tabs nav-justified">
<!-- <h2 style="margin: 9px 20px;"><?php // __('Account History');?></h2> # for desktop version # -->
<h2 style="margin: 9px 20px;"><?php __('Bid Purchase History');?></h2>
		</div>
		<div class="auction-content">
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