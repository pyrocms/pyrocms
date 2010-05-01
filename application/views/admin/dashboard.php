<div class="box">
	<h3><?php echo lang('cp_news_feed_title'); ?></h3>
	
	<div class="box-container">
	
		<ul>
			<?php foreach($rss_items as $rss_item): ?>
			<li class='rss_item'>
				<strong class='item_name'><?php echo anchor($rss_item->get_permalink(), $rss_item->get_title(), 'target="_blank"'); ?></strong>
				<p class='item_date'><em><?php echo $rss_item->get_date(); ?></em></p>
				<p class='item_body'><?php echo $rss_item->get_description(); ?></p>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	
</div>

<br class="clear-both" />