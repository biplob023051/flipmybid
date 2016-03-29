<h1><?php echo $category['Category']['name']; ?></h1>

<?php if(!empty($categories)) : ?>
	<?php if(!empty($auctions)) : ?>
	<h2><?php __('Subcategories'); ?></h2>
	<?php endif; ?>
	<?php echo $this->element('categories'); ?>
<?php endif; ?>

<?php if(!empty($auctions)) : ?>
	<?php echo $this->element('pagination'); ?>
	<?php echo $this->element('auctions'); ?>
	<?php echo $this->element('pagination'); ?>
<?php elseif(empty($categories)) : ?>
	<p><?php __('There are no auctions in this category at the moment.');?></p>
<?php endif; ?>