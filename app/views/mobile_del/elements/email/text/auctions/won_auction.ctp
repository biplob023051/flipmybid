<?php echo sprintf(__('Hi %s', true), $data['User']['first_name']);?>,

<?php echo sprintf(__('Congratulations!  You have successfully won an auction listed at %s titled: %s', true), $appConfigurations['name'], $data['Product']['title']);?>

<?php __('To confirm your details and complete the won auction process please click on the following link:');?>
<?php echo $appConfigurations['url'];?>/auctions/pay/<?php echo $data['Auction']['id'];?>


<?php __('Thank You');?>
<?php echo $appConfigurations['name'];?>
