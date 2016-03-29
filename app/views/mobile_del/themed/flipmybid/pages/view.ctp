<div class="rounded contact">
	<?php if(!empty($page)) : ?>
        <div id="tabs">
            <h2><?php echo $page['Page']['title']; ?></h2>
        </div>
        <div class="c-content">
        <?php echo $page['Page']['content']; ?>
    <?php else: ?>
		<div class="c-content">
    <?php endif;?>


	</div>
</div>