


	<div class="pure-u-1 pure-u-md-1-4 logo">
	<h1><a href="/">flip <span id="my">my</span> <span id="bid">bid</span></a></h1>
	</div>
	
	

<div id="container" class="pure-g">

    <!--The Hamburger Button in the Header-->
    <header>
        <div id="hamburger">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </header>

    <!--The mobile navigation Markup hidden via css-->
<nav>
<ul>
<li><a href="/auctions">Live Auctions</a></li>
<li><a href="/page/howitworks">How It Works</a></li>
<li><a href="/help">Help</a></li>
<li><a href="/rewards">Rewards</a></li>
</ul>
</nav>

    <!--The Layer that will be layed over the content
    so that the content is unclickable while menu is shown-->
    <div id="contentLayer"></div>

    <!--The content of the site-->
    <div id="content"></div>


</div>




	<div class="pure-u-1 pure-u-md-3-4 topnav">
	<div class="pure-menu pure-menu-horizontal">
		<ul class="pure-menu-list">
			<li class="pure-menu-item"><a href="/auctions" class="pure-menu-link">Live Auctions</a></li>
			<?php $pages = $this->requestAction('/pages/getpages/top');?>
				<?php if(!empty($pages)):?>
					<?php foreach($pages as $page):?>
						<li<?php if(!empty($this->params['url']['url']) && $this->params['url']['url'] == 'page/'.$page['Page']['slug']) : ?> class="menuactive"<?php endif; ?> class="pure-menu-item">
						<?php echo $html->link($page['Page']['name'], array('controller' => 'pages', 'action'=>'view', $page['Page']['slug']),array('class'=>'pure-menu-link', 'escape'=>false)); ?></li>
					<?php endforeach;?>
				<?php endif;?>
			<li class="pure-menu-item"><a href="/help" class="pure-menu-link">Help</a></li>
			<li class="pure-menu-item"><a href="/rewards" class="pure-menu-link">Rewards</a></li>
			
			<?php if($session->check('Auth.User')):?>
			   <li<?php if(!empty($this->params['controller']) && $this->params['controller'] == 'users' && $this->params['action'] == 'index') : ?> class="menuactive"<?php endif; ?> class="pure-menu-item pure-menu-has-children pure-menu-allow-hover">
					<a href="/users" id="menuLink1" class="pure-menu-link"><?php echo $session->read('Auth.User.username'); ?></a>
					<ul class="pure-menu-children">
						<li class="pure-menu-item"><a href="/users" class="pure-menu-link">My Account</a></li>
						<li class="pure-menu-item"><a href="/users/edit" class="pure-menu-link">Edit Profile</a></li>
						<li class="pure-menu-item"><a href="/referrals" class="pure-menu-link">Earn Credits</a></li>
						<li class="pure-menu-item"><a href="/users/logout" class="pure-menu-link">Sign Out</a></li>
					</ul>
				</li>			
				<?php else : ?>
				<li<?php if(!empty($this->params['controller']) && $this->params['controller'] == 'users' && $this->params['action'] == 'register') : ?> class="menuactive"<?php endif; ?> class="pure-menu-item"><a href="/users/register" class="pure-menu-link">Register</a></li>
						
				<li<?php if(!empty($this->params['controller']) && $this->params['controller'] == 'users' && $this->params['action'] == 'login') : ?> class="menuactive"<?php endif; ?> id="user" class="pure-menu-item pure-menu-has-children pure-menu-allow-hover">
				<a href="/users/login" id="a-user menuLink1" class="pure-menu-link">Login</a>
				
				
				
				<ul class="pure-menu-children">
				<form class="pure-form pure-form-aligned">
				<fieldset>




				</fieldset>
				</form>
				</ul>
				
				
				
				<?php endif; ?>	
		</ul>
		
	</div>
	</div>



