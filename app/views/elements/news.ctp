<?php if($this->requestAction('/settings/enabled/latest_news')) : ?>
	<?php $news = $this->requestAction('/news/getlatest/3'); ?>

	<?php if(!empty($news)) : ?>
		<?php foreach ($news as $article) : ?>
			<div id="news_content_top"><a href="/news/view/<?php echo $article['News']['id']; ?>"><?php echo $article['News']['title']; ?></a></div>
			<div id="news_content_bg">
				<div class="content">
					<?php echo $article['News']['brief']; ?>
				</div>
			</div>
			<div id="news_content_bottom"></div>
		<?php endforeach; ?>
	<?php endif; ?>
<?php endif; ?>