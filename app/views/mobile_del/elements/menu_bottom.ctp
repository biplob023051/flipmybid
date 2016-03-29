<?php if($this->requestAction('/settings/enabled/help_section')) : ?>
	<?php echo $html->link(__('Help', true), '/help'); ?> |
<?php endif; ?>
<?php $pages = $this->requestAction('/pages/getpages/bottom');?>
<?php if(!empty($pages)):?>
	<?php foreach($pages as $page):?>
		<?php echo $html->link($page['Page']['name'], array('controller' => 'pages', 'action'=>'view', $page['Page']['slug'])); ?> |
	<?php endforeach;?>
<?php endif;?>
<?php echo $html->link(__('Contact', true), array('controller' => 'contact', 'action'=>'index')); ?> |
<?php if($session->check('Auth.User')):?>
	<?php echo $html->link(__('Logout', true), array('controller' => 'users', 'action'=> 'logout')); ?>
<?php endif; ?>
