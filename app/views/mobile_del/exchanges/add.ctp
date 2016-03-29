<div class="boxed">
	<div class="content">
	<h1><?php __('Buy'); ?> <a href="/auction/<?php echo $auction['Auction']['id'] ?>"><?php echo $auction['Product']['title']; ?></a> Now</h1>

	<p><?php __('Buy this product now for:'); ?> <strong><?php echo $number->currency($exchange, $appConfigurations['currency']); ?></strong>

	<p><?php __('Press the confirm button below to purchase this product.'); ?></p>

	<?php echo $form->create(null, array('url' => '/exchanges/add/'.$auction['Auction']['id'])); ?>
	<?php echo $form->input('id', array('value' => $auction['Auction']['id'])); ?>
	<?php echo $form->end(__('Buy Now >>', true)); ?>
	</div>
</div>