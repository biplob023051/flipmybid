<h1><?php __('Rewards Store'); ?></h1>

<p><?php __('The rewards store allows you to redeem your reward points for prizes!'); ?></p>

<?php
if($session->check('Auth.User')) :
	$points = $this->requestAction('/users/points/'.$session->read('Auth.User.id')); ?>
	<p><?php echo sprintf(__('You currently have <strong>%d</strong> reward points.', true), $points); ?></p>
<?php endif; ?>

<?php if(!empty($products)) : ?>
	<div class="paging-auct">
		<?php echo $this->element('pagination'); ?>
	</div>

	<div id="auctions">
		<ul class="horizontal-auctions">
			<?php foreach($products as $product):?>
			<li class="auction-item">
				<div class="content">
					<h3><?php echo $html->link($text->truncate($product['Product']['title'], 35), array('controller' => 'rewards', 'action' => 'view', $product['Product']['id']));?></h3>
					<div class="wrapper" style="float: none;">
						<div class="thumb">
							<a href="/rewards/view/<?php echo $product['Product']['id']; ?>">
							<?php if(!empty($product['Image'][0]['image'])):?>
								<?php echo $html->image('product_images/thumbs/'.$product['Image'][0]['image'], array('alt' => $product['Product']['title'], 'title' => $product['Product']['title'])); ?>
							<?php else:?>
								<?php echo $html->image('product_images/thumbs/no-image.gif');?>
							<?php endif;?>
							</a>
						</div>
						<div class="info">
							<div class="price">
								<span class="bid-price">
									<?php echo $product['Product']['reward_points']; ?> <?php __('Points'); ?>
								</span>
							</div>
						</div>

						<div>
							<?php echo $html->link($html->image('bid_now.png'), array('action' => 'view', $product['Product']['id']), array('escape' => false));?>
						</div>
					</div>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>

	<div class="paging-auct">
		<?php echo $this->element('pagination'); ?>
	</div>
<?php else: ?>
	<p><?php __('There are no products for sale at the moment.');?></p>
<?php endif; ?>