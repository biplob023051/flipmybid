<ul class="categories">
<?php foreach($categories as $category): ?>
	<li>
		<div class="content">
			<div class="title">
				<h3><?php echo $html->link($category['Category']['name'], array('action' => 'view', $category['Category']['id'])); ?></h3>
			</div>
			<div class="thumb">
				<?php if(!empty($category['Category']['image'])) : ?>
					<?php echo $html->link($html->image('category_images/thumbs/'.$category['Category']['image']), array('action' => 'view', $category['Category']['id']), array('escape' => false)); ?>
				<?php elseif(!empty($category['Category']['random_image'])) : ?>
					<?php echo $html->link($html->image('product_images/thumbs/'.$category['Category']['random_image']), array('action' => 'view', $category['Category']['id']), array('escape' => false)); ?>
				<?php else : ?>
					<?php echo $html->link($html->image('category_images/thumbs/no-image.gif'), array('action' => 'view', $category['Category']['id']), array('escape' => false)); ?>
				<?php endif; ?>
			</div>
		</div>
	</li>
<?php endforeach;?>
</ul>