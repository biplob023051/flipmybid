<div id="right_bar">
	<div class="banners">
	<?php $banners = $this->requestAction('/banners/get/2'); ?>
	<?php if(!empty($banners)) : ?>
		<?php foreach ($banners as $banner) : ?>
			<?php if(!empty($banner['Banner']['url'])) : ?>
            	<a target="_blank" href="<?php echo $banner['Banner']['url']; ?>"><?php echo $banner['Banner']['code']; ?></a>
			<?php else : ?>
				<img src="/img/product_images/<?php echo $banner['Banner']['image']; ?>" />
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
	</div>
</div>

<div id="content_top_auc"><?php echo $product['Product']['title']; ?></div>

<div id="content_bg_auc">
<div id="auction-details" class="boxed">
	<ul class="auction-details">
		<li>
			<div class="content">
				<div class="bg-wrap">
<!-- Product Images -->
				<div class="thumb">
					<?php if(!empty($product['Image'][0]['image'])):?>
						<?php echo $html->image('product_images/max/'.$product['Image'][0]['image'], array('class'=>'productImageMax'));?>
					<?php else:?>
						<?php echo $html->image('product_images/max/no-image.gif');?>
					<?php endif; ?>

					<div class="product-thumbs">
						<?php if(!empty($product['Image']) && count($product['Image']) > 1):?>
							<?php foreach($product['Image'] as $image):?>
								<span><?php echo $html->link($html->image('product_images/thumbs/'.$image['image']), '/img/product_images/max/'.$image['image'], array('class' => 'productImageThumb', 'escape' => false));?></span>
							<?php endforeach;?>
						<?php endif;?>
					</div>
				</div>
<!-- END Product Images -->
<!-- Bid / Time Box -->
				<div class="data">
				<div class="info">
					<div class="price">
						<span class="bid-price">
							<?php echo $product['Product']['reward_points']; ?> <?php __('Points'); ?>
						</span>
					</div>

					<div class="bid-now">
     				    <?php if($session->check('Auth.User')):?>
				 		    <?php echo $html->link($html->image('bid_now.png'), array('action' => 'redeem', $product['Product']['id']), array('escape' => false));?>
						<?php else:?>
							<?php echo $html->link($html->image('b-login.gif'), array('controller' => 'users', 'action' => 'login'), array('escape' => false));?>
						<?php endif; ?>

					</div>
<!-- END Bid / Time Box -->

					</div> <!-- leftdata -->
<!-- END Watchlist -->

<!-- Savings -->
					<div class="middle-data">
					<div class="count-saving">
						<?php if(!empty($product['Product']['rrp'])) : ?>
							<label><?php __('Worth up to');?></label> : <?php echo $number->currency($product['Product']['rrp'], $appConfigurations['currency']); ?> <br />
						<?php endif; ?>
					</div>

				</div>
<!-- END Savings -->




				</div> <!-- data -->
				<div style="clear: both"></div>
				</div> <!-- .bg-wrap -->

			</div>
		</li>
	</ul>
</div>
</div><!-- content_bg -->

<div id="content_top_auc"><?php __('Product Description');?></div>
<div id="content_bg_auc">
<?php echo $product['Product']['description'];?></div>

<?php if(!empty($product['Product']['delivery_information'])) : ?>
	<div id="content_top_auc"><?php __('Delivery Information');?></div>
	<div id="content_bg_auc"> <?php echo nl2br($product['Product']['delivery_information']); ?></div>
<?php endif; ?>

<div id="content_bottom"></div>