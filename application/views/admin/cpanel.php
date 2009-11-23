<!-- To do: Replace the shitty inline styles and update the message -->
<strong><?php echo sprintf(lang('cp_welcome'), $this->settings->item('site_name'));?></strong>

<br class="clear-both" />

<!-- Fancy site stats -->
<div class="dashboard_box" id='stats_box'>
	<h3>Site Info</h3>
	<ul id='stats_list'>
		<li><strong>Pages:</strong> <?php echo $this->data->total_pages; ?></li>
		<li><strong>Articles:</strong> <?php echo $this->data->live_articles; ?> (live)</li>
		<li><strong>Comments:</strong> <?php echo $this->data->approved_comments; ?> (approved)</li>
		<li><strong>Users:</strong> <?php echo $this->data->total_users; ?></li>
	</ul>
</div>

<!-- Geeky details about the current release -->
<div class="dashboard_box" id='release_box'>
	<h3>PyroCMS Info</h3>
	<ul id='release_list'>
		<li><strong>Version:</strong> <?php echo CMS_VERSION; ?></li>
		<li><strong>Release Date:</strong> <?php echo CMS_DATE; ?></li>
	</ul>
</div>

<div class="dashboard_box" id='contact_box'>
	<h3>Support</h3>
	<ul>
		<li><a href="http://www.pyrocms.com/" title="PyroCMS website">PyroCMS website</a></li>
		<li><a href="http://github.com/philsturgeon/pyrocms/issues" title="PyroCMS Bugtracker">Public Bugtracker</a></li>
		<li><a href="http://www.pyrocms.com/documentation" title="Documentation">The "Documentation"</a></li>
		<li><a href="http://java.freenode.net/index.php?channel=pyrocms" title="PyroCMS Freenode IRC channel">IRC Channel</a></li>
	</ul>
</div>

<br class="clear-both" />

<!-- Delicious, home baked RSS feeds. -->
<div class="dashboard_box" id='feeds_box'>
	<h3>RSS Feeds</h3>
	<ul id='feeds_list'>
		<?php foreach($this->data->rss_items as $rss_item): ?>
		<li class='rss_item'>
			<strong class='item_name'><?php echo anchor($rss_item->get_permalink(), $rss_item->get_title(), 'target="_blank"'); ?></strong>
			<p class='item_date'><em><?php echo $rss_item->get_date(); ?></em></p>
			<p class='item_body'><?php echo $rss_item->get_description(); ?></p>
		</li>
		<?php endforeach; ?>
	</ul>
</div>

<br class="clear-both" />