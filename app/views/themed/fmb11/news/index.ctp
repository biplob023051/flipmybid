<?php if(!$session->check('Auth.User')):?>
	<?php echo $this->element('register'); ?>
<?php else: ?>
	<?php echo $this->element('tab'); ?>
<?php endif; ?>

<div class="col-md-12 auctions">
<div class="nav nav-tabs nav-justified">
<h2 style="margin: 9px 20px;"><?php __('Latest News');?></h2>
        </div>
<div class="auction-content">		
            <div class="inner news">
				<?php if(!empty($news)) : ?>
                <?php // echo $this->element('pagination'); ?>
                    <!-- <ul class="news-list">-->
                    <?php foreach ($news as $news): ?>
                        <!-- <li>-->
                        	<h2><?php echo $html->link($news['News']['title'], array('action'=>'view', $news['News']['id'])); ?></h2>
                            <div class="date"><?php __('Date & Time Posted:'); ?> <?php echo $time->niceShort($news['News']['created']); ?></div>
                            <p><?php echo $news['News']['brief']; ?> ... <?php echo $html->link('more', array('action'=>'view', $news['News']['id'])); ?></p>						
                        <!-- </li>-->
                    <?php endforeach; ?>
                    <!-- </ul>-->
                    <?php echo $this->element('pagination'); ?>
            
                <?php else: ?>
                    <p><?php __('There is not news at the moment.');?></p>
                <?php endif; ?>
        	</div>
			
</div>
</div>

<?php /*
<?php echo $this->element('banners'); ?>

<div id="content_top"></div>
<div id="content_bg">
<div class="boxed">
	<div class="content">
		<h1><?php __('Latest News');?></h1>
		<?php if(!empty($news)) : ?>

		<?php echo $this->element('pagination'); ?>
		<ul class="news-list">
		<?php foreach ($news as $news): ?>
			<li>
				<div class="date"><?php __('Date & Time Posted:'); ?> <?php echo $time->niceShort($news['News']['created']); ?></div>
				<h3><?php echo $html->link($news['News']['title'], array('action'=>'view', $news['News']['id'])); ?></h3>
				<p><?php echo $news['News']['brief']; ?>...<?php echo $html->link('more', array('action'=>'view', $news['News']['id'])); ?></p>
			</li>
		<?php endforeach; ?>
		</ul>
		<?php echo $this->element('pagination'); ?>

		<?php else: ?>
			<p><?php __('There is not news at the moment.');?></p>
		<?php endif; ?>
	</div>
</div>
</div>
<div id="content_bottom"></div>
*/?>