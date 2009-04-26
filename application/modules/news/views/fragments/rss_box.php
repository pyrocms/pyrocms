<h4>Subscribe to RSS</h4>

<div class="spacer-left-dbl">
	
	<img src="<?= image_path('icons/rss-14x14.png'); ?>" class="float-left spacer-right" />
	
	<a href="<?=site_url('news/rss/all.rss'); ?>">
		<strong>All articles</strong><br />
	</a>
	
	<? if(isset($category) && is_object($category)): ?>
	
	<img src="<?= image_path('icons/rss-14x14.png'); ?>" class="clear-both float-left spacer-right" />
	
	<a href="<?=site_url('news/rss/'.$category->slug.'.rss'); ?>">
		<strong><?=$category->title;?> articles</strong>
	</a>
	<? endif;?>
	
</div>

<p class="clear-both">Get articles straight away by subscribing to our RSS feed. You can do this via most popular e-mail clients, or try <a href="http://reader.google.co.uk/">Google Reader</a>.</p>