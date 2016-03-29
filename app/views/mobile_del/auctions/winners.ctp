<?php
$html->addCrumb(__('Winners', true), '/auctions/winners');
echo $this->element('crumb_auction');
?>

<h1><?php __('Won Auctions'); ?></h1>

<?php if(!empty($auctions)) : ?>
	<?php echo $this->element('pagination'); ?>
	<?php echo $this->element('auctions'); ?>
	<?php echo $this->element('pagination'); ?>
<?php else: ?>
	<p><?php __('There are no won auctions at the moment.', true);?></p>
<?php endif; ?>
