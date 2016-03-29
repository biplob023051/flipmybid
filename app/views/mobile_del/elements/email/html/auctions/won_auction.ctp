<p><?php echo sprintf(__('Hi %s', true), $data['User']['first_name']);?>,</p>

<p><?php echo sprintf(__('Congratulations!  You have successfully won an auction listed at %s titled: %s', true), $appConfigurations['name'], $data['Product']['title']);?></p>

<p><?php __('To confirm your details and complete the won auction process please click on the following link');?></p>

<p>
    <a href="<?php echo $appConfigurations['url'];?>/auctions/pay/<?php echo $data['Auction']['id'];?>">
        <?php echo $appConfigurations['url'];?>/auctions/pay/<?php echo $data['Auction']['id'];?>
    </a>
</p>

<p><?php __('Thank You');?><br/>
<?php echo $appConfigurations['name'];?></p>
