<?php if (!$session->check('Auth.User')): ?>
    <?php echo $this->element('register'); ?>
<?php else: ?>
    <?php echo $this->element('tab'); ?>
<?php endif; ?>

    <div class="col-md-9 col-sm-12 col-xs-12 g5">
        <div id="auctions" class="rounded">
            <div id="tabs">
                <h2><?php __('Testimonials'); ?></h2>
            </div>
            <div class="news testimonials">
                <?php if (!empty($testimonials)) : ?>
                    <?php echo $this->element('pagination'); ?>

                    <?php foreach ($testimonials as $testimonial): ?>
                        <div class="testimonial-item">
                            <div class="testimonial-frame">
                                <?php if (!empty($testimonial['Testimonial']['image'])) : ?>
                                    <img
                                        src="/img/product_images/max/<?php echo $testimonial['Testimonial']['image']; ?>">
                                <?php endif; ?>
                            </div>
                            <div class="testimonial-content">
                                <?php echo $html->image('fresh-q-start.jpg', array('class' => 'q-start')); ?>
                                <p class="testimonial-text"><?php echo $testimonial['Testimonial']['testimonial']; ?><?php echo $html->image('fresh-q-end.jpg', array('class' => 'q-end')); ?></p>

                                <div class="clearfix"></div>
                                <p class="testimonial-buddy">
                                    <?php echo $testimonial['User']['username']; ?> <br/>
                                    <span>Text text</span>
                                </p>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    <?php endforeach; ?>

                    <?php echo $this->element('pagination'); ?>
                <?php else: ?>
                    <p><?php __('There are no testimonials at the moment.'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>


<?php /*<?php echo $this->element('banners'); ?>

<div id="content_top"></div>
<div id="content_bg">
<div class="boxed">
	<div class="content">
		<h1><?php __('Testimonials'); ?></h1>

		<?php if(!empty($testimonials)) : ?>
			<?php echo $this->element('pagination'); ?>

			<?php foreach ($testimonials as $testimonial): ?>
				<h3><?php echo $testimonial['User']['username']; ?> - <?php echo $testimonial['Testimonial']['location']; ?></strong></h3>
				<p>
					<h5><?php echo $html->link($testimonial['Auction']['Product']['title'], array('controller' => 'auctions', 'action' => 'view', $testimonial['Auction']['id']));?> <?php __('- Closed on:'); ?> <?php echo $time->niceShort($testimonial['Auction']['end_time']); ?></h5>
					<?php if(!empty($testimonial['Testimonial']['image'])) : ?>
						<img class="alignleft" src="/img/product_images/max/<?php echo $testimonial['Testimonial']['image']; ?>">
					<?php endif; ?>

					<?php echo $testimonial['Testimonial']['testimonial']; ?>

					<?php if(!empty($testimonial['Testimonial']['video'])) : ?>
						<br /><?php echo $testimonial['Testimonial']['video']; ?>
					<?php endif; ?>

					<hr size="1">
				</p>
			<?php endforeach; ?>

			<?php echo $this->element('pagination'); ?>
		<?php else: ?>
			<p><?php __('There are no testimonials at the moment.');?></p>
		<?php endif; ?>
		</div>
	</div>
</div>
<div id="content_bottom"></div>*/ ?>