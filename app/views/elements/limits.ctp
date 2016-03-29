<?php $limits = $this->requestAction('/limits/getlimits'); ?>
<?php foreach($limits as $limit) : ?>
	<?php echo $html->image('icon-bid-'.$limit.'.gif', array('class' => 'bid-limit-icon', 'alt' => ucfirst($limit), 'title' => ucfirst($limit))); ?>
<?php endforeach; ?>
