<div class="col-md-12 auctions">
<div class="nav nav-tabs nav-justified">
<h2 style="margin: 9px 20px;"><?php __('Rewards Store'); ?></h2>
</div>
<div class="auction-content">
<p class="reward-info"><?php __('The rewards store allows you to redeem your reward points for prizes!'); ?></p>

<?php
if($session->check('Auth.User')) :
	$points = $this->requestAction('/users/points/'.$session->read('Auth.User.id')); ?>
	<p class="reward-info"><?php echo sprintf(__('You currently have <strong>%d</strong> reward points.', true), $points); ?></p>
<?php endif; ?>

<?php if(!empty($products)) : ?>
	<div class="paging-auct">
		<?php echo $this->element('pagination'); ?>
	</div>
			<?php foreach($products as $product):?>
				<div class="listing rounded auction-item">
					<h3><?php echo $html->link($text->truncate($product['Product']['title'], 35), array('controller' => 'rewards', 'action' => 'view', $product['Product']['id']));?></h3>
                    <a href="/rewards/view/<?php echo $product['Product']['id']; ?>">
                    <?php if(!empty($product['Image'][0]['image'])):?>
                        <?php echo $html->image('product_images/thumbs/'.$product['Image'][0]['image'], array('alt' => $product['Product']['title'], 'title' => $product['Product']['title'])); ?>
                    <?php else:?>
                        <?php echo $html->image('product_images/thumbs/no-image.gif');?>
                    <?php endif;?>
                    </a>
					<p><?php echo $product['Product']['reward_points']; ?> <?php __('Points'); ?></p>
                    
                    <!-- SET THIS -->
					<a href="/bid.php?id=<?php echo $product['Product']['id']; ?>" class="bidbutton bid-button-link" title="<?php echo $product['Product']['id']; ?>">Bid Now</a>
			</div>
			<?php endforeach; ?>

	<div class="paging-auct">
		<?php echo $this->element('pagination'); ?>
	</div>
<?php else: ?>
	<p class="reward-info"><?php __('There are no products for sale at the moment.');?></p>
<?php endif; ?>
</div>
</div>