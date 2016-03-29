<div class="auction-item">

    <div class="col-md-3 col-sm-12 col-xs-12 g6">
        <h1>reward details</h1>

        <p class="timer">Price: <?php echo $product['Product']['reward_points']; ?> <?php __('Points'); ?></p>


        <!-- SET THIS -->
        <a href="/rewards/redeem/<?php echo $product['Product']['id']; ?>" class="bidbutton bidbuttonsidebar">Redeem
            Reward</a>

        <?php if (!empty($product['Product']['rrp'])) : ?>
            <p>&nbsp;</p>
            <h2><?php __('Worth up to'); ?>
                : <?php echo $number->currency($product['Product']['rrp'], $appConfigurations['currency']); ?> </h2>
        <?php endif; ?>

    </div>
    <div class="col-md-9 col-sm-12 col-xs-12 g5">
        <div id="auctions" class="rounded">
            <?php echo $this->element('user_submenu'); ?>
            <div class="auction-detail">
                <h1><?php echo $product['Product']['title']; ?></h1>

                <?php if (!empty($product['Product']['Image'])): ?>
                    <ul class="gallery">
                        <?php foreach ($product['Product']['Image'] as $image): ?>
                            <li>
                                <a href="/img/product_images/<?php echo $image['image']; ?>" rel="prettyPhoto[gallery]">
                                    <?php echo $html->image('product_images/max/' . $image['image']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <div class="auction-detail">
                <h2>Reward Overview</h2>
                <?php echo $product['Product']['description']; ?>
            </div>
        </div>
        <!--/ Auctions -->
    </div>
</div>