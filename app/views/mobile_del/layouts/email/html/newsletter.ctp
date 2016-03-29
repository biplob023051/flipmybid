<p><center><a href="<?php echo $appConfigurations['url'];?>"><img src="<?php echo $appConfigurations['url'];?>/img/logo.png" border="0"></a></center></p>

<?php echo $content_for_layout;?>

<hr>

<p>This email has been sent to you because you subscribed to our newsletter at <?php echo $appConfigurations['name'];?>. To unsubscribe from our newsletter please <a href="<?php echo $appConfigurations['url'];?>/newsletters/unsubscribe/<?php echo $data['to'];?>">click here.</a></p>