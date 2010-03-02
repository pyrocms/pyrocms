<ul>
<?php foreach($rss_items as $rss_item): ?>
	<li>
		<a><?php echo anchor($rss_item->get_permalink(), $rss_item->get_title(), 'target="_blank"'); ?></a>
		<p class="date"><em><?php echo $rss_item->get_date(); ?></em></p>
	</li>
<?php endforeach; ?>
</ul>