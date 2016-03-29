<?php $news = $this->requestAction('/news/getlatest');?>

<?php if(!empty($news)):?>
	<div class="title bold">
        <?php echo $html->link($news['News']['title'], array('controller' => 'news', 'action' => 'view', $news['News']['id']));?>
    </div>
    <p><?php echo $news['News']['brief'];?></p>
    <div class="meta">Posted <?php echo $time->niceShort($news['News']['created']); ?></div>
<?php else:?>
	<p><?php __('There is no news at the moment.');?></p>
<?php endif;?>
