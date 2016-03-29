<div id="auctions">
	<ul class="horizontal-auctions">
		<?php foreach($products as $product):?>
		<li class="auction-item">
			<div class="content">
				<h3><?php echo $html->link($text->truncate($product['Product']['title'], 35), array('controller' => 'products', 'action' => 'url', $product['Product']['id']));?></h3>
				<div class="wrapper" style="float: none;">
					<div class="thumb">
						<a href="/products/url/<?php echo $product['Product']['id']; ?>">
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
								<?php echo $number->currency($product['Product']['exchange'], $appConfigurations['currency']); ?>
							</span>
						</div>
					</div>
				</div>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</div>