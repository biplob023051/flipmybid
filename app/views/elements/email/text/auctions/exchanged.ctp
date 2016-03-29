<?php echo sprintf(__('Dear %s', true), $appConfigurations['name']);?>,

<?php echo sprintf(__('The following auction titled %s has been bought on buy now', true), $data['Auction']['Product']['title']);?>

The product was bought by: <?php echo $data['User']['username']; ?>.