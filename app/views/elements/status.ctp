<?php if($session->check('Auth.User')):?>
    <div class="user-status">
		<strong><span class="white"><a href="/users"><?php echo $session->read('Auth.User.username'); ?></a></span></strong> |
		<?php $balance = $this->requestAction('/bids/balance/'.$session->read('Auth.User.id')); ?>
		<strong><span class="<?php if($balance > 0) : ?>white<?php else : ?>red<?php endif; ?>"><a href="/packages"><?php echo $balance; ?></a></span> <?php __('Bids'); ?></strong> |

		<?php if($this->requestAction('/settings/enabled/reward_points')) : ?>
			<?php $rewardPoints = $this->requestAction('/users/points/'.$session->read('Auth.User.id')); ?>
			<strong><?php echo $rewardPoints; ?></a> <?php __('Reward Points'); ?></strong> |
		<?php endif; ?>

		<strong><?php echo $html->link(__('Purchase Bids', true), array('controller' => 'packages', 'action'=>'index')); ?></strong>
		<br /><br />
		<strong><span class="white"><a href="/users"><?php __('My Account'); ?></a></span></strong> |
		<?php $watchlistCount = $this->requestAction('/watchlists/count');?>
		<?php if($watchlistCount > 0) : ?>
			<a href="/watchlists"><?php __('My Watchlist'); ?> (<strong><?php echo $watchlistCount; ?></strong>)</a>
		<?php else: ?>
			<a href="/watchlists"><?php __('My Watchlist'); ?> (<?php echo $watchlistCount; ?>)</a>
		<?php endif; ?>
		| <a href="/users/logout"><?php __('Logout'); ?></a></strong>
	</div>

<?php else:?>
<div id="login">
	<?php echo $form->create('User', array('action' => 'login'));?>
		<div class="a_username"><?php echo $form->input('username', array('id' => 'loginUsername', 'error' => false, 'div' => false, 'label' => false, 'class' => 'textbox', 'value' => __('username', true)));?></div>
		<div class="a_password"><?php echo $form->input('password', array('id' => 'loginPassword', 'error' => false, 'div' => false, 'label' => false, 'class' => 'textbox password', 'value' => __('password', true)));?></div>
		<div class="form-item submit">
			<?php echo $form->submit('login_submit_bg.png', array('div' => false, 'label' => false));?>
			<?php echo $form->hidden('url', array('value' => '/'.$this->params['url']['url']));?>
		</div>
</div>
	<?php echo $form->end();?>

	<script type="text/javascript">
	$(document).ready(function(){
		$('#loginUsername').blur(function(){
			if ($('#loginUsername').val() == ''){
				$('#loginUsername').val('username');
			}
		});

		$('#loginUsername').focus(function(){
			if ($('#loginUsername').val() == 'username'){
				$('#loginUsername').val('');
			}
		});

		$('#loginPassword').blur(function(){
			if ($('#loginPassword').val() == ''){
				$('#loginPassword').val('password');
			}
		});

		$('#loginPassword').focus(function(){
			if ($('#loginPassword').val() == 'password'){
				$('#loginPassword').val('');
			}
		});
	});
	</script>
<?php endif;?>