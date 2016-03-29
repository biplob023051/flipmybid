<?php // echo $html->image('menuarrowup.png',array('class'=>'hiddenpic'));?>
<?php // echo $html->image('menuarrowup2.png',array('class'=>'hiddenpic'));?>

<div class="row ea">
<div class="container">
<nav class="navbar navbar-default navbar-static-top" role="navigation">
<div class="navbar-header">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		 <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
	</button>
	<span class="navbar-brand">
	<a href="/"><span class="flip">Flip</span> <span class="my">My</span> <span class="bid">Bid</span></a>
	</span>
</div>
<div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1">


<?php if($session->check('Auth.User')):?>
<ul class="nav navbar-nav navbar-right m-none">
		<li<?php if($this->params['controller'] == 'auctions' && $this->params['action'] == 'index') : ?> class="active"<?php endif; ?>><a href="/auctions">Live Auctions</a></li>
		<?php $pages = $this->requestAction('/pages/getpages/top');?>
		<?php if(!empty($pages)):?>
		<?php foreach($pages as $page):?>
		<li<?php if(!empty($this->params['url']['url']) && $this->params['url']['url'] == 'page/'.$page['Page']['slug']) : ?> class="active"<?php endif; ?>><?php echo $html->link($page['Page']['name'], array('controller' => 'pages', 'action'=>'view', $page['Page']['slug'])); ?></li>
		<?php endforeach;?>
		<?php endif;?>
		<?php if($this->requestAction('/settings/enabled/help_section')) : ?>
		<li<?php if(!empty($this->params['controller']) && ($this->params['controller'] == 'sections' || $this->params['controller'] == 'questions')) : ?> class="active"<?php endif; ?>><a href="/help">Help</a></li>
		<?php endif; ?>
		<?php if($this->requestAction('/settings/enabled/reward_points')) : ?>
		<li<?php if(!empty($this->params['controller']) && $this->params['controller'] == 'rewards') : ?> class="active"<?php endif; ?>><?php echo $html->link(__('Rewards', true), array('controller' => 'rewards', 'action' => 'index'));?></li>
		<?php endif; ?>
		<li<?php if(!empty($this->params['controller']) && $this->params['controller'] == 'users' && $this->params['action'] == 'index') : ?> class="active"<?php endif; ?> id="user">
		<a href="/users" id="a-user"><?php echo $session->read('Auth.User.username'); ?></a>
		<ul class="user-down">
			<li><a href="/users">My Account</a></li>
			<li><a href="/users/edit">Edit Profile</a></li>
			<li><a href="/referrals">Earn Credits</a></li>
			<li><a href="/users/logout">Sign Out</a></li>
		</ul>
		</li>
</ul>
<ul class="nav navbar-nav navbar-right d-none">
	<div class="userbox" style="padding: 10px 15px;color:#fff;">
	<div class="row text-center">
		<div class="row">
			<div class="col-xs-12" style="margin-bottom:15px"><?php echo $session->read('Auth.User.first_name'); ?> <?php echo $session->read('Auth.User.last_name'); ?> <small>(<?php echo $session->read('Auth.User.username'); ?>)</small></div>
		</div>
		<div class="row">
			<div class="col-xs-3"><a href="/" style="color:#fff;padding:10px 0;"><span class="glyphicon glyphicon-home" aria-hidden="true" style="font-size:20px;"></span><p style="font-size:13px;">Home</p></a></div>
			<div class="col-xs-3"><a href="/users" style="color:#fff;padding:10px 0;"><span class="glyphicon glyphicon-user" aria-hidden="true" style="font-size:20px;"></span><p style="font-size:13px;">My Account</p></a></div>
			<div class="col-xs-3"><a href="/rewards" style="color:#fff;padding:10px 0;"><span class="glyphicon glyphicon-gift" aria-hidden="true" style="font-size:20px;"></span><p style="font-size:13px;">Rewards</p></a></div>
			<div class="col-xs-3"><a href="/users/logout" style="color:#fff;padding:10px 0;"><span class="glyphicon glyphicon-log-out" aria-hidden="true" style="font-size:20px;"></span><p style="font-size:13px;">Sign Out</p></a></div>
		</div>
		<div class="row">
			<div class="col-xs-6"><div class="chart" data-percent="10"><span><?php echo $this->requestAction('/users/bids'); ?></span><small><?php if($bidBalance <= 1):?>credit<?php else:?>credits<?php endif;?></small></div></div>
			<div class="col-xs-6">
			<?php
				if(!empty($user['Membership']['name']))
				{
					echo "<p id='openrankdialog'>" . ucfirst(strtolower($user['Membership']['name'])) . "</p>";
					echo "<div id='rankdialog' title='" . ucfirst(strtolower($user['Membership']['name'])) . " Rank Explained' style='display: none;'>" . $user['Membership']['description'] . "</div>";
				}
				else
				{
					echo "<p>No membership rank set.</p>";
				}
			?>
			</div>
		</div>	
		<div class="row">
			<div class="col-xs-12 bid-btn"><a href="/packages" style="color:#fff;">Purchase Bids</a></div>
		</div>			
		</div>
	</div>	
		<!-- <li><a href="/users/edit">Edit Profile</a></li> -->
		<li><a href="/referrals">Earn Credits</a></li>
		<li<?php if($this->params['controller'] == 'auctions' && $this->params['action'] == 'index') : ?> class="active"<?php endif; ?>><a href="/auctions">Live Auctions</a></li>
		<?php $pages = $this->requestAction('/pages/getpages/top');?>
		<?php if(!empty($pages)):?>
		<?php foreach($pages as $page):?>
		<li<?php if(!empty($this->params['url']['url']) && $this->params['url']['url'] == 'page/'.$page['Page']['slug']) : ?> class="active"<?php endif; ?>><?php echo $html->link($page['Page']['name'], array('controller' => 'pages', 'action'=>'view', $page['Page']['slug'])); ?></li>
		<?php endforeach;?>
		<?php endif;?>
		<?php if($this->requestAction('/settings/enabled/help_section')) : ?>
		<li<?php if(!empty($this->params['controller']) && ($this->params['controller'] == 'sections' || $this->params['controller'] == 'questions')) : ?> class="active"<?php endif; ?>><a href="/help">Help</a></li>
		<?php endif; ?>
		<?php if($this->requestAction('/settings/enabled/reward_points')) : ?>
		<li<?php if(!empty($this->params['controller']) && $this->params['controller'] == 'rewards') : ?> class="active"<?php endif; ?>><?php echo $html->link(__('Rewards', true), array('controller' => 'rewards', 'action' => 'index'));?></li>
		<?php endif; ?>

</ul>
<?php else : ?>
<ul class="nav navbar-nav navbar-right">
				<li<?php if($this->params['controller'] == 'auctions' && $this->params['action'] == 'index') : ?> class="menuactive"<?php endif; ?>><a href="/auctions">Live Auctions</a></li>
				<?php $pages = $this->requestAction('/pages/getpages/top');?>
				<?php if(!empty($pages)):?>
					<?php foreach($pages as $page):?>
						<li<?php if(!empty($this->params['url']['url']) && $this->params['url']['url'] == 'page/'.$page['Page']['slug']) : ?> class="menuactive"<?php endif; ?>><?php echo $html->link($page['Page']['name'], array('controller' => 'pages', 'action'=>'view', $page['Page']['slug'])); ?></li>
					<?php endforeach;?>
				<?php endif;?>

				<?php if($this->requestAction('/settings/enabled/help_section')) : ?>
					<li<?php if(!empty($this->params['controller']) && ($this->params['controller'] == 'sections' || $this->params['controller'] == 'questions')) : ?> class="menuactive"<?php endif; ?>><a href="/help">Help</a></li>
				<?php endif; ?>

				<?php if($this->requestAction('/settings/enabled/reward_points')) : ?>
					<li<?php if(!empty($this->params['controller']) && $this->params['controller'] == 'rewards') : ?> class="menuactive"<?php endif; ?>><?php echo $html->link(__('Rewards', true), array('controller' => 'rewards', 'action' => 'index'));?></li>
				<?php endif; ?>
					<li<?php if(!empty($this->params['controller']) && $this->params['controller'] == 'users' && $this->params['action'] == 'register') : ?> class="menuactive"<?php endif; ?>><a href="/users/register">Register</a></li>
					<li<?php if(!empty($this->params['controller']) && $this->params['controller'] == 'users' && $this->params['action'] == 'login') : ?> class="menuactive"<?php endif; ?> id="user">
                    	<a href="#" id="a-user">Login</a>
                        <?php echo $form->create('User', array('action' => 'login'));?>
                            <ul class="user-down m-none">
                                <li><?php echo $form->input('username', array('id' => 'loginUsername', 'error' => false, 'div' => false, 'label' => 'Username:', 'class' => 'textbox', 'value' => __('username', true), 'onclick'=>'this.value=\'\''));?></li>
                                <li><?php echo $form->input('password', array('id' => 'loginPassword', 'error' => false, 'div' => false, 'label' => 'Password:', 'class' => 'textbox password', 'value' => __('password', true),'onclick'=>'this.value=\'\''));?></li>							
                                <!--<li><label>&nbsp;</label><?php echo $form->submit('Login',array('div'=>false, 'class'=>'submit'));?></li>-->
                                <li style="height: 30px !important;"><label>&nbsp;</label><?php echo $form->submit('Login',array('div'=>false, 'class'=>'submit-fb-login'));?></li>
								<!--<li style="text-align:center !important;">Or <div style="margin: 0 auto;"><fb:login-button scope="public_profile,email" size="large" onlogin="fbLogin();">Log-in</fb:login-button></div></li>
								<li style="text-align:center !important;">Or<div style="margin: 0 auto; margin-top: 5px; margin-bottom: 10px;"><a href="http://www.flipmybid.com/users/facebook" class="facebook-btn">Sign in</a></div></li>-->
                            </ul>
                            <ul class="user-down d-none">
                                <li><?php echo $form->input('username', array('id' => 'loginUsername', 'error' => false, 'div' => false, 'label' => '', 'class' => 'textbox', 'value' => __('Username', true), 'onclick'=>'this.value=\'\''));?></li>
                                <li><?php echo $form->input('password', array('id' => 'loginPassword', 'error' => false, 'div' => false, 'label' => '', 'class' => 'textbox password', 'value' => __('Password', true),'onclick'=>'this.value=\'\''));?></li>
                                <!--<li><label>&nbsp;</label><?php echo $form->submit('Login',array('div'=>false, 'class'=>'submit'));?></li>-->
                                <li style="height: 30px !important;"><?php echo $form->submit('Login',array('div'=>false, 'class'=>'submit-fb-login btn btn-default'));?></li>
								<!--<li style="text-align:center !important;">Or <div style="margin: 0 auto;"><fb:login-button scope="public_profile,email" size="large" onlogin="fbLogin();">Log-in</fb:login-button></div></li>
								<li style="text-align:center !important;">Or<div style="margin: 0 auto; margin-top: 5px; margin-bottom: 10px;"><a href="http://www.flipmybid.com/users/facebook" class="facebook-btn">Sign in</a></div></li>-->
                            </ul>							
                        <?php echo $form->end(); ?>
                    </li>
</ul>
<?php endif; ?>
</div>
</nav>
</div>
</div>