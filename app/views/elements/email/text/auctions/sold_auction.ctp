<?php echo sprintf(__('Dear %s', true), $appConfigurations['name']);?>,

<?php echo sprintf(__('The following auction titled %s has sold', true), $data['Product']['title']);?>

<?php echo sprintf(__('The auction was sold to %s for %s', true), $data['User']['username'], $number->currency($data['Auction']['price'], $appConfigurations['currency']));?>

<?php __('To view the details for this auction please visit the following link:');?>

<?php echo $appConfigurations['url'];?>/auction/<?php echo $data['Auction']['id'];?>