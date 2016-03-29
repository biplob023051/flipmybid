<div id="right_bar">
	<div class="banners">
	<?php $banners = $this->requestAction('/banners/get/2'); ?>
	<?php if(!empty($banners)) : ?>
		<?php foreach ($banners as $banner) : ?>
			<?php if(!empty($banner['Banner']['url'])) : ?>
				<a target="_blank" href="<?php echo $banner['Banner']['url']; ?>"><?php echo $banner['Banner']['code']; ?></a>
			<?php else : ?>
				<?php echo $banner['Banner']['code']; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
	</div>
</div>