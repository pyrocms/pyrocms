<div class="line">
	<section class="box unit size1of3">
		<header>
			<h3><?php echo lang('cp_admin_quick_links') ?></h3>
		</header>
		
		<ul class="big-list">
			<li class="clearfix">
				<img src="<?php echo base_url(). 'system/pyrocms/assets/img/icons/comments.png'; ?>" />
				<a href="<?php echo site_url('admin/comments') ?>"><h4>Manage Comments</h4></a>
			</li>
			<li class="clearfix">
				<img src="<?php echo base_url() .'system/pyrocms/assets/img/icons/pages.png'; ?>" />
				<a href="<?php echo site_url('admin/pages') ?>"><h4>Manage Pages</h4></a>
			</li>
			<li class="clearfix">
				<img src="<?php echo base_url() .'system/pyrocms/assets/img/icons/folder_open.png'; ?>" />
				<a href="<?php echo site_url('admin/files') ?>"><h4>Manage Files</h4></a>
			</li>
			<li class="clearfix">
				<img src="<?php echo base_url() .'system/pyrocms/assets/img/icons/user.png'; ?>" />
				<a href="<?php echo site_url('admin/users') ?>"><h4>Manage Users</h4></a>
			</li>
		</ul>
		
		
	</section>

	<!-- News Feed -->
	<section class="box unit size2of3 lastUnit">
		<header>
			<h3><?php echo lang('cp_news_feed_title'); ?></h3>
		</header>
			
			<ul>
				<?php foreach($rss_items as $rss_item): ?>
				<li class='rss_item'>
					<strong class='item_name'><?php echo anchor($rss_item->get_permalink(), $rss_item->get_title(), 'target="_blank"'); ?></strong>
					<p class='item_date'><em><?php echo $rss_item->get_date(); ?></em></p>
					<p class='item_body'><?php echo $rss_item->get_description(); ?></p>
				</li>
				<?php endforeach; ?>
			</ul>
		
	</section>

</div>	<!-- /line -->