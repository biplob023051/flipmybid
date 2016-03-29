<div class="col-md-3 col-sm-12 col-xs-12 g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="col-md-9 col-sm-12 col-xs-12 g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('Buy It Products'); ?></h2>
		</div>
		<div class="account">
			<div class="">
				<?php if(!empty($buyitproducts)): ?>
					<div class="paging-auct">
						<?php //echo $this->element('pagination'); ?>
                    </div>

					<table class="default-table" width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr class="headings">
							<!--<td valign="top"><?php //echo $paginator->sort('Name', 'name');?></td>
							<td valign="top"><?php //echo $paginator->sort('Price', 'price');?></td>
							<td valign="top"><?php //echo $paginator->sort('Date', 'created');?></td>-->
							<td valign="top">Name</td>
							<td valign="top">Price</td>
							<td valign="top">Date</td>
						</tr>
					<?php
					$i = 0;
					foreach ($buyitproducts as $buyIt):
						$class = null;
						if ($i++ % 2 == 0) {
							$class = ' class="altrow"';
						}
					?>
						<tr<?php echo $class;?>>
							<td>
								<a href="/auction/<?php echo $buyIt['BuyItPackage']['auction_id']; ?>"><?php echo $buyIt['BuyItPackage']['name']; ?></a>
							</td>
							<td>
								<?php echo $number->currency($buyIt['BuyItPackage']['price'], $appConfigurations['currency']); ?>
							</td>
							<td>
								<?php echo $time->niceShort($buyIt['BuyItPackage']['created']); ?>
							</td>
						</tr>
					<?php endforeach; ?>
			  </table>

					<div class="paging-auct">
						<?php //echo $this->element('pagination'); ?>
                    </div>

				<?php else:?>
					<p><?php __('You have not purchased any products yet.');?></p>
				<?php endif;?>

			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>