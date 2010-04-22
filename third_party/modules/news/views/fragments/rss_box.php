<h4><?php echo lang('news_subscripe_to_rss_label');?></h4>
<div class="spacer-left-dbl">	
	<img src="<?php echo image_path('icons/rss-14x14.png'); ?>" class="float-left spacer-right" />
	
	<a href="<?php echo site_url('news/rss/all|rss'); ?>"><strong><?php echo lang('news_all_articles_label');?></strong><br /></a>	
	<?php if(isset($category) && is_object($category)): ?>	
		<img src="<?php echo image_path('icons/rss-14x14.png'); ?>" class="clear-both float-left spacer-right" />	
		<a href="<?php echo site_url('news/rss/'.$category->slug.'|rss'); ?>"><strong><?php echo $category->title;?> <?php echo lang('news_articles_of_category_suffix');?></strong></a>
	<?php endif;?>	
</div>

<p class="clear-both"><?php echo lang('news_subscripe_to_rss_desc');?></p>