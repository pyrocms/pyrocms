<ul class="rss">
	<?php foreach ($rss_items as $rss_item): ?>
	<li>
		<?php echo $rss_item->get_title(); ?>
		<p class="date"><em><?php echo anchor($rss_item->get_permalink(), format_date($rss_item->get_date(), Settings::get('date_format') . ' h:i'), 'target="_blank"'); ?></em></p>
		<?php $rss_item->__destruct(); ?>
	</li>
	<?php endforeach; ?>
</ul>