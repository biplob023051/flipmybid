<?php
$html->addCrumb(__('Free Auctions', true), '/auctions/free');
echo $this->element('crumb_auction');
?>

<h1><?php __('Free Auctions'); ?></h1>

<?php if(!empty($auctions)) : ?>
	<?php echo $this->element('pagination'); ?>
	<?php echo $this->element('auctions'); ?>
	<?php echo $this->element('pagination'); ?>
<?php else: ?>
	<p><?php __('There are no free auctions at the moment.');?></p>
<?php endif; ?>