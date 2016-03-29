<div class="col-md-3 col-sm-12 col-xs-12 g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="col-md-9 col-sm-12 col-xs-12 g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('Win Limits'); ?></h2>
		</div>
		<div class="account">
			<div class="">
				<p><?php __('On some of our auctions we apply win limits, limiting the number of times that you can win and / or lead an auction for a certain number of days.'); ?></p>

				<?php if(!empty($limits[1])) : ?>
					<p><?php __('We have different Win Limits categories.  Each category is listed below and explains how many free slots you have available for bidding.'); ?></p>
				<?php else : ?>
					<p><?php __('The table below gives details on your win limits as well as explains how many free slots you have available for bidding.'); ?></p>
				<?php endif; ?>

				<?php if(!empty($limits)) : ?>
					<?php foreach ($limits as $limit) : ?>
						<?php if(!empty($limits[1])) : ?>
							<h3><?php echo $limit['Limit']['name']; ?></h3>
						<?php endif; ?>

						<p><?php echo sprintf(__('You can win %s auctions within %s days.', true), $limit['Limit']['limit'], $limit['Limit']['days']);?></p>


						<table class="default-table" width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr class="headings">
								<td>&nbsp;</td>
								<td><?php __('Auction'); ?></td>
								<td><?php __('Status'); ?></td>
							</tr>
							<?php $i = 0; ?>
							<?php if(!empty($limit['Leading'])): ?>
								<?php
								foreach ($limit['Leading'] as $auction):
									$class = null;
									if ($i++ % 2 == 0) {
										$class = ' class="altrow"';
									}
								?>
									<tr<?php echo $class;?>>
										<td><?php echo $i; ?></td>
										<td><?php echo $html->link($auction['Product']['title'], array('controller' => 'auctions', 'action' => 'view', $auction['Auction']['id']));?></td>
										<td>
											<?php if(!empty($auction['Auction']['closed'])) : ?>
												<?php __('Won'); ?>
											<?php else : ?>
												<?php __('Leading'); ?>
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif;?>

							<?php
							$n = count($limit['Leading']) + 1;
							while ($n <= $limit['Limit']['limit']) : ?>
							    <?php
							    $class = null;
								if ($i++ % 2 == 0) {
									$class = ' class="altrow"';
								}
							    ?>

							    <tr<?php echo $class;?>>
								    <td><?php echo $i; ?></td>
									<td><?php __('You are free to bid'); ?></td>
									<td>-</td>
								</tr>
								<?php $n ++; ?>
							<?php endwhile; ?>
						</table>
					<?php endforeach; ?>
				<?php else : ?>
					<p><?php __('No win limits have been set yet!'); ?></p>
				<?php endif; ?>

			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>