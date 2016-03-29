<script>

	$(function(){

		$('#a-user').click(function(e){
			e.preventDefault();

			if($('.user-down').css('display') == 'none')
				$('#user').attr('class','active');
			else
				$('#user').attr('class','');

			$('.user-down').slideToggle();
		});
	});

</script>


<?php echo $html->image('menuarrowup.png',array('class'=>'hiddenpic'));?>
<?php echo $html->image('menuarrowup2.png',array('class'=>'hiddenpic'));?>

<div id="header">
	<div id="header-inner">
		<h1><a href="/">flip <span id="my">my</span> <span id="bid">bid</span></a></h1>
		<div id="navigation">
			<ul>
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

				<?php if($session->check('Auth.User')):?>
					<li<?php if(!empty($this->params['controller']) && $this->params['controller'] == 'users' && $this->params['action'] == 'index') : ?> class="menuactive"<?php endif; ?> id="user">
                    	<div>
                            <a href="/users" id="a-user"><?php echo $session->read('Auth.User.username'); ?></a>
                            <ul class="user-down">
                                <li><a href="/users">My Account</a></li>
                                <li><a href="/users/edit">Edit Profile</a></li>
                                <li><a href="/referrals">Earn Credits</a></li>
                                <li><a href="/users/logout">Sign Out</a></li>
                            </ul>
                            <div class="clearfix"></div>
                         </div>
                    </li>
				<?php else : ?>
					<li<?php if(!empty($this->params['controller']) && $this->params['controller'] == 'users' && $this->params['action'] == 'register') : ?> class="menuactive"<?php endif; ?>><a href="/users/register">Register</a></li>
					<li<?php if(!empty($this->params['controller']) && $this->params['controller'] == 'users' && $this->params['action'] == 'login') : ?> class="menuactive"<?php endif; ?> id="user">
                    	<a href="/users/login" id="a-user">Login</a>
                        <?php echo $form->create('User', array('action' => 'login'));?>
                            <ul class="user-down">
                                <li><?php echo $form->input('username', array('id' => 'loginUsername', 'error' => false, 'div' => false, 'label' => 'Username:', 'class' => 'textbox', 'value' => __('username', true), 'onclick'=>'this.value=\'\''));?></li>
                                <li><?php echo $form->input('password', array('id' => 'loginPassword', 'error' => false, 'div' => false, 'label' => 'Password:', 'class' => 'textbox password', 'value' => __('password', true),'onclick'=>'this.value=\'\''));?></li>
                                <li><label>&nbsp;</label><?php echo $form->submit('Login',array('div'=>false, 'class'=>'submit-fb-login'));?></li>
								<li style="text-align:center !important;">Or <div style="margin: 0 auto;"><fb:login-button scope="public_profile,email" size="large" onlogin="fbLogin();">Log-in</fb:login-button></div></li>
                            </ul>
                        <?php echo $form->end(); ?>
                    </li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</div>