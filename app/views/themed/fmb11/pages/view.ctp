<div class="col-md-12 auctions">
<?php if(!empty($page)) : ?>
<div class="nav nav-tabs nav-justified">
<h2 style="margin: 9px 20px;"><?php echo $page['Page']['title']; ?></h2>
</div>

<div class="auction-content">
<?php echo $page['Page']['content']; ?>
<?php else: ?>
<?php endif;?>
</div>
</div>