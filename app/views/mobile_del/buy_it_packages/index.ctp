<?php if(!$session->check('Auth.User')):?>
	<?php echo $this->element('register'); ?>
<?php else: ?>
	<?php echo $this->element('tab'); ?>
<?php endif; ?>

<div class="g5">
    <div id="auctions" class="rounded">
        <div id="tabs">
            <h2><?php __('Latest News');?></h2>
        </div>
    </div>
</div>