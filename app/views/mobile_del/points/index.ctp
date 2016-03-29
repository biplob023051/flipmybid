<div id="left">
    <?php echo $this->element('menu_user');?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('My Reward Points');?></h1>
		<?php if(!empty($points)): ?>
			<?php echo $this->element('pagination'); ?>

			<table width="100%" class="table" cellpadding="0" cellspacing="0">
				<tr>
			<th><?php echo $paginator->sort(__('Date', true), 'Point.created');?></th>
				<th><?php echo $paginator->sort(__('Description', true), 'description');?></th>
				<th><?php echo $paginator->sort(__('Debit', true), 'debit');?></th>
				<th><?php echo $paginator->sort(__('Credit', true), 'credit');?></th>
			</tr>

			<tr>
				<td colspan="3"><strong><?php __('Current Balance');?></strong></td>
				<td><strong><?php echo $balance; ?></strong></td>
			</tr>
			<?php
			$i = 0;
			foreach ($points as $point):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
				<tr<?php echo $class;?>>
					<td>
						<?php echo $time->niceShort($point['Point']['created']); ?>
					</td>
					<td>
						<?php echo $point['Point']['description']; ?>
					</td>
					<td>
						<?php if($point['Point']['debit'] > 0) : ?><?php echo $point['Point']['debit']; ?><?php else: ?>&nbsp;<?php endif; ?>
					</td>
					<td>
						<?php if($point['Point']['credit'] > 0) : ?><?php echo $point['Point']['credit']; ?><?php else: ?>&nbsp;<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</table>

			<?php echo $this->element('pagination'); ?>

		<?php else:?>
			<p><?php __('You have no reward points at the moment.');?></p>
		<?php endif;?>
	</div>
</div>
