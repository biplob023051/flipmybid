<?php echo sprintf(__('Dear %s', true), $appConfigurations['name']);?>,

<?php echo sprintf(__('The following reward titled %s has been redeemed', true), $data['Product']['title']);?>

<?php echo sprintf(__('The product was redeemed by %s for %d reward points.', true), $data['User']['username'], $data['Product']['reward_points']);?>