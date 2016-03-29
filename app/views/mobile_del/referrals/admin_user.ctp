<?php
$html->addCrumb(__('Manage Users', true), '/admin/users');
$html->addCrumb(__('Users', true), '/admin/users');
$html->addCrumb($user['User']['username'], '/admin/users/view/'.$user['User']['id']);
$html->addCrumb(__('Referrals', true), '/admin/referrals/user/'.$user['User']['id']);
echo $this->element('admin/crumb');
?>

<h2><?php __('User Referrals');?></h2>

<?php if(!empty($referrals)) : ?>
	<?php echo $this->element('pagination'); ?>

	<table class="results" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo $paginator->sort('User.username');?></th>
			<th><?php echo $paginator->sort('User.first_name');?></th>
			<th><?php echo $paginator->sort('User.last_name');?></th>
			<th><?php echo $paginator->sort('Date Joined', 'Referral.created');?></th>
			<th><?php echo $paginator->sort('Verified', 'User.verified');?></th>
			<th><?php echo $paginator->sort('Purchased', 'Referral.purchased');?></th>
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
				<?php echo $referral['User']['username']; ?>
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
	<p><?php __('This user has not referred any members yet.');?></p>
<?php endif;?>

<div class="actions">
	<ul>
		<?php echo $this->element('admin/user_links', array('id' => $user['User']['id'])); ?>
	</ul>
</div>
