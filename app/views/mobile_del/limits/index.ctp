<div id="left">
    <?php echo $this->element('menu_user');?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('Win Limits'); ?></h1>

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

				<?php echo sprintf(__('You can win %s auctions within %s days.', true), $limit['Limit']['limit'], $limit['Limit']['days']);?>


				<table width="100%" class="table" cellpadding="0" cellspacing="0">
					<tr>
						<th>&nbsp;</th>
						<th><?php __('Auction'); ?></th>
						<th><?php __('Status'); ?></th>
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