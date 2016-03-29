<p><?php echo sprintf(__('Dear %s', true), $appConfigurations['name']);?>,</p>

<p><?php echo sprintf(__('The following auction titled %s has sold', true), $data['Product']['title']);?></p>

<p><?php echo sprintf(__('The auction was sold to %s for %s', true), $data['User']['username'], $number->currency($data['Auction']['price'], $appConfigurations['currency']));?></p>

<p><?php __('To view the details for this auction please visit the following link:');?></p>

<p>
    <a href="<?php echo $appConfigurations['url'];?>/auction/<?php echo $data['Auction']['id'];?>">
        <?php echo $appConfigurations['url'];?>/auction/<?php echo $data['Auction']['id'];?>
    </a>
</p>