<div id="content_top_auc"><?php echo $landing['Landing']['title']; ?></div>

<div id="content_bg_auc">
<div id="auction-details" class="boxed">
	<ul class="auction-details">
		<li class="auction-item">
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

					<div class="left-data">
						<div class="timer-stat">
							<div class="b-closed"><?php echo $html->image('b-closed.png');?></div>
					</div>

					<?php if($landing['Landing']['closed_price'] > 0) : ?>
						<div class="price">
							<span class="bid-price">
								<?php __('Sold for'); ?>
								<?php echo $number->currency($landing['Landing']['closed_price'], $appConfigurations['currency']); ?>
							</span>
						</div>
					<?php endif; ?>

<!-- END Bid / Time Box -->
<!-- Watchlist -->

					</div> <!-- leftdata -->
<!-- END Watchlist -->

<!-- Savings -->
					<div class="middle-data">
					<div class="count-saving">
						<h3 class="heading"><?php __('Savings:');?></h3>
						<?php if($product['Product']['rrp'] > 0) : ?>
							<label><?php __('Worth up to');?></label> : <?php echo $number->currency($product['Product']['rrp'], $appConfigurations['currency']); ?> <br />
						<?php endif; ?>
					</div>

				</div>

				</div> <!-- data -->
				<div style="clear: both"></div>
				</div> <!-- .bg-wrap -->

			</div>
		</li>
	</ul>
</div>
</div><!-- content_bg -->

<?php if(!empty($landing['Landing']['content'])) : ?>
	<div id="content_top_auc"><?php __('Description');?></div>
	<div id="content_bg_auc">
		<?php echo $landing['Landing']['content'];?>
	</div>
	<div id="content_bottom"></div>
<?php else : ?>
	<div id="content_top_auc"><?php __('Product Description');?></div>
	<div id="content_bg_auc">
		<?php echo $product['Product']['description'];?>
	</div>
	<div id="content_bottom"></div>
<?php endif; ?>

<?php
if(!empty($landing['Landing']['show_auctions'])) {
	echo $this->element('ending_soon');
	echo $this->element('timeout');
}
?>