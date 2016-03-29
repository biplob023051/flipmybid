<?php
$html->addCrumb(__('Manage Users', true), '/admin/users');
$html->addCrumb(__('Users', true), '/admin/users');
$html->addCrumb($user['User']['username'], '/admin/users/view/'.$user['User']['id']);
$html->addCrumb(__('Win Limits', true), '/admin/limits/user/'.$user['User']['id']);
echo $this->element('admin/crumb');
?>

<div class="limits index">
	<h2><?php __('Win Limits');?></h2>

		<?php if(!empty($limits[1])) : ?>
			<p><?php __('Each category is listed below and explains how many free slots the user has available for bidding.'); ?></p>
		<?php else : ?>
			<p><?php __('The table below gives details on the users win limits as well as explains how many free slots they have available for bidding.'); ?></p>
		<?php endif; ?>

		<?php if(!empty($limits)) : ?>
			<?php foreach ($limits as $limit) : ?>
				<?php if(!empty($limits[1])) : ?>
					<h3><?php echo $limit['Limit']['name']; ?></h3>
				<?php endif; ?>

				<?php echo sprintf(__('They can win %s auctions within %s days.', true), $limit['Limit']['limit'], $limit['Limit']['days']);?>


				<table width="100%" class="results" cellpadding="0" cellspacing="0">
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
							<td><?php __('This user is free to bid'); ?></td>
							<td>-</td>
						</tr>
						<?php $n ++; ?>
					<?php endwhile; ?>
				</table>
			<?php endforeach; ?>
		<?php else : ?>
			<p><?php __('No win limits have been set yet!'); ?></p>
		<?php endif; ?>

	<div class="actions">
		<ul>
			<?php echo $this->element('admin/user_links', array('id' => $user['User']['id'])); ?>
		</ul>
	</div>
</div>