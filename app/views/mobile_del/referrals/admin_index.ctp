<?php
$html->addCrumb(__('Manage Users', true), '/admin/users');
$html->addCrumb(__('Users', true), '/admin/users');
$html->addCrumb(__('Referrals', true), '/admin/referrals/user/'.$user['User']['id']);
echo $this->element('admin/crumb');
?>

<h2><?php __('Referrals');?></h2>

<?php if(!empty($referrals)) : ?>
	<?php echo $this->element('pagination'); ?>

	<table class="results" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo $paginator->sort(__('Username', true), 'User.username');?></th>
			<th><?php echo $paginator->sort(__('First Name', true), 'User.first_name');?></th>
			<th><?php echo $paginator->sort(__('Last Name', true), 'User.last_name');?></th>
			<th><?php echo $paginator->sort(__('Date Joined', true), 'Referral.created');?></th>
			<th><?php echo $paginator->sort(__('Referred by', true), 'Referral.username');?></th>
			<th><?php echo $paginator->sort(__('Verified', true), 'User.verified');?></th>
			<th><?php echo $paginator->sort(__('Purchased', true), 'Referral.purchased');?></th>
		</tr>
		<?php
		$i = 0;
		foreach ($referrals as $referral):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td>
				<?php echo $html->link($referral['User']['username'], array('controller' => 'users', 'action' => 'view', $referral['User']['id'])); ?>
			</td>
			<td>
				<?php echo $referral['User']['first_name']; ?>
			</td>
			<td>
				<?php echo $referral['User']['last_name']; ?>
			</td>
			<td>
				<?php echo $time->niceShort($referral['Referral']['created']); ?>
			</td>
			<td>
				<?php echo $html->link($referral['Referrer']['username'], array('controller' => 'users', 'action' => 'view', $referral['Referrer']['id'])); ?>
			</td>
			<td>
				<?php if($referral['Referral']['verified'] == 1) : ?><?php __('Yes'); ?><?php else: ?><?php __('No'); ?><?php endif; ?>
			</td>
			<td>
				<?php if($referral['Referral']['purchased'] == 1) : ?><?php __('Yes'); ?><?php else: ?><?php __('No'); ?><?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>

	<?php echo $this->element('pagination'); ?>

<?php else:?>
	<p><?php __('There are no referrals yet.');?></p>
<?php endif;?>
