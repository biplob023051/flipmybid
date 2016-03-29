<?php if($session->check('Auth.User')):?>
<div id="toppanelsmall">
	<div id="panelsmall">
			<div class="left">
				<!-- Admin Bar -->
	<img src="/img/admin_pac.png" width="150px" height="13px" />
    <a target="_blank" href="/admin"><img src="/img/admin_quick.png" width="120px" height="13px" /></a>
    <a target="_blank" href="/admin/products/add"><img src="/img/admin_add_prods.png" width="120px" height="13px" /></a>
    <a target="_blank" href="/admin/products"><img src="/img/admin_add_aucs.png" width="120px" height="13px" /></a>
    <a target="_blank" href="/admin/auctions/won"><img src="/img/admin_won_aucs.png" width="120px" height="13px" /></a>
    <a target="_blank" href="/admin/auctions/live"><img src="/img/admin_live_aucs.png" width="120px" height="13px" /></a>
    <a target="_blank" href="/admin/users"><img src="/img/admin_manage_users.png" width="120px" height="13px" /></a>
    <a target="_blank" href="/admin/settings"><img src="/img/admin_settings.png" width="120px" height="13px" /></a>
			</div>
    </div>

	<!-- The tab on top -->
	<div class="tab">
		<ul class="login">
			<li class="left">&nbsp;</li>
			<li><?php __('Hello'); ?> <span style="text-transform:capitalize;"><a href="/users/"><?php echo $session->read('Auth.User.username'); ?></a></span><?php __('!'); ?></li>
			<li class="sep">|</li>
            <li class="sep"><?php $balance = $this->requestAction('/bids/balance/'.$session->read('Auth.User.id')); ?>
		<strong><span class="<?php if($balance > 0) : ?>white<?php else : ?>red<?php endif; ?>"><a href="/packages"><?php echo $balance; ?></a></span> <?php __('Bids'); ?></strong></li>
            <?php if($this->requestAction('/settings/enabled/reward_points')) : ?>
            <li class="sep">|</li>
            <li class="sep">
			<?php $rewardPoints = $this->requestAction('/users/points/'.$session->read('Auth.User.id')); ?>
			<strong><?php echo $rewardPoints; ?></a> <?php __('Reward Points'); ?></strong>
			</li>
		<?php endif; ?>

		<?php if($this->requestAction('/settings/enabled/memberships') && $this->requestAction('/settings/get/automatic_memberships')) : ?>
			<li class="sep">|</li>
            <li class="sep">
				<?php $membership = $this->requestAction('/memberships/level'); ?>
				<strong><?php echo $membership['Membership']['name']; ?></a> <?php __('Member'); ?></strong>
			</li>
		<?php endif; ?>

        <li class="sep">|</li>
        <li class="sep"><a href="/users/logout"><?php __('Logout'); ?></a></li>
        <!-- Admin Bar Toggle -->
			<?php if($session->read('Auth.User.admin') == 1): ?>
            <li id="toggle">
				<a id="open" class="open" href="#"><?php __('Quick Admin'); ?></a>
				<a id="close" style="display: none;" class="close" href="#"><?php __('Close Panel'); ?></a>
			</li>
			<?php elseif($session->read('Auth.User.translator') == 1): ?>
				<a href="/languages"><?php __('Translations Section'); ?></a>
			<?php endif; ?>
			<li class="right">&nbsp;</li>
		</ul>
	</div> <!-- / top -->

</div> <!--panel -->

<?php else:?>
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">
			<div class="left">
				<center><h1><?php __('Welcome to'); ?> <?php echo $appConfigurations['name']; ?></h1>
				<img src="/img/slide_ad.png" width="220px" height="220px" /></center>
			</div>
			<div class="left">
				<!-- Login Form -->
				<?php echo $form->create('User', array('action' => 'login', 'class' => 'clearfix'));?>
					<h1><?php __('Member Login'); ?></h1>
					<label class="grey" for="log"><?php __('Username:'); ?></label>
					<?php echo $form->input('username', array('id' => 'loginUsername', 'error' => false, 'value' => '', 'div' => false, 'label' => false, 'class' => 'field', 'value' => __('', true)));?>
					<label class="grey" for="pwd"><?php __('Password:'); ?></label>
					<?php echo $form->input('password', array('id' => 'loginPassword', 'error' => false, 'value' => '', 'div' => false, 'label' => false, 'class' => 'field', 'type' => 'password', 'value' => __('', true)));?>
	            	<label><input name="data[User][remember_me]" id="rememberme" type="checkbox" checked="checked" value="forever" /> &nbsp;<?php __('Remember me'); ?></label>
        			<div class="clear"></div>
					<input type="submit" name="submit" value="Login" class="bt_login" />
					<?php if($this->requestAction('/settings/enabled/facebook_login') && $this->requestAction('/settings/get/facebook_app_id')) : ?>
						<?php __('OR'); ?> <a href="/users/facebook"><?php echo $html->image('facebook-icon.gif'); ?></a>
					<?php endif; ?>
					<a class="lost-pwd" href="/users/reset"><?php __('Lost your password?'); ?></a>
				</form>
			</div>
			<div class="left right">
				<h1><?php __('Not a member yet? Sign Up!'); ?></h1>
				<a href="/users/register"><?php __('Click Here to Register!'); ?></a>
			</div>
		</div>
</div> <!-- /login -->

	<!-- The tab on top -->
	<div class="tab">
		<ul class="login">
			<li class="left">&nbsp;</li>
			<li><?php __('Hello Guest!'); ?></li>
			<li class="sep">|</li>
			<li id="toggle">
				<a id="open" class="open" href="#"><?php __('Log In | Register'); ?></a>
				<a id="close" style="display: none;" class="close" href="#"><?php __('Close Panel'); ?></a>
			</li>
			<li class="right">&nbsp;</li>
		</ul>
	</div> <!-- / top -->

</div> <!--panel -->
<?php endif;?>