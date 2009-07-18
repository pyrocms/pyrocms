<h4><?=lang('news_subscripe_to_rss_label');?></h4>
<div class="spacer-left-dbl">	
	<img src="<?= image_path('icons/rss-14x14.png'); ?>" class="float-left spacer-right" />
	
	<a href="<?=site_url('news/rss/all|rss'); ?>"><strong><?=lang('news_all_articles_label');?></strong><br /></a>	
	<? if(isset($category) && is_object($category)): ?>	
		<img src="<?= image_path('icons/rss-14x14.png'); ?>" class="clear-both float-left spacer-right" />	
		<a href="<?=site_url('news/rss/'.$category->slug.'|rss'); ?>"><strong><?=$category->title;?> <?=lang('news_articles_of_category_suffix');?></strong></a>
	<? endif;?>	
</div>

<p class="clear-both"><?=lang('news_subscripe_to_rss_desc');?></p>