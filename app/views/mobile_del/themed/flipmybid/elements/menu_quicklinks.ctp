<?php if($session->check('Auth.User')):?>
	<h4 class="heading"><?php echo $html->link('Change password', array('controller' => 'users', 'action' => 'changepassword')); ?></h4>
	<h4 class="heading"><?php echo $html->link('Change address', array('controller' => 'addresses', 'action' => 'index')); ?></h4>
	<h4 class="heading"><?php echo $html->link('Confirm won auction', array('controller' => 'auctions', 'action' => 'won')); ?></h4>
	<h4 class="heading"><?php echo $html->link('Purchase Bids', array('controller' => 'packages', 'action' => 'index')); ?></h4>
<?php else : ?>
	<h4 class="heading"><?php echo $html->link('Lost Password', array('controller' => 'users', 'action' => 'reset')); ?></h4>
	<h4 class="heading"><?php echo $html->link('How it works', array('controller' => 'page', 'action' => 'how-it-works')); ?></h4>
	<h4 class="heading"><?php echo $html->link('Register', array('controller' => 'users', 'action' => 'register')); ?></h4>
<?php endif; ?>

<h4 class="heading"><?php echo $html->link('Email us', array('controller' => 'pages', 'action' => 'contact')); ?></h4>
