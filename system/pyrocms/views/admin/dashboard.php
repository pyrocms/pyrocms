<?php if ($this->settings->google_analytic) : ?>
<h3>Google Analytics</h3>

<div id="analytics" class="line" style="width: 100%; height: 200px;"></div>

<p>Total visits per day, based on information from your <a href="http://google.com/analytics" target="_blank">Google Analytics</a> account.</p>
<?php endif; ?>

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
			
			<ul id="news-feed">
				<?php foreach($rss_items as $rss_item): ?>
				<li>
					<h3><?php echo anchor($rss_item->get_permalink(), $rss_item->get_title(), 'target="_blank"'); ?></h3>
					
					<?php
						$item_date	= strtotime($rss_item->get_date());
						$item_month = date('M', $item_date);
						$item_day	= date('j', $item_date);
					?>
					<div class="date">
						<span><?php echo $item_month ?></span>
						<?php echo $item_day; ?>
					</div>
										
					<p class='item_body'><?php echo $rss_item->get_description(); ?></p>
				</li>
				<?php endforeach; ?>
			</ul>
		
	</section>

</div>	<!-- /line -->

<script>
jQuery(function($) {
	$(document).ready(function(){
		
		// Build our Google Analytics chart, if we have the required information.
		var visits = <?php echo isset($ga_visits) && !empty($ga_visits) ? $ga_visits : ''; ?>;
		
		if (visits != undefined)
		{
			var options = {
				series: {
					lines: {
						show: true,
						fill: true,
						fillColor: '#e6f2fa',
						lineWidth: 4
					},
					points: {
						show: true
					},
					legend: {
						show: false,
						margin: 10,
						backgroundOpacity: 0.5
					}
				},
				xaxis: {
					mode: 'time'
				}, 
				grid: {
					color: '#aaa'
				}
			};
	
		
			$.plot($('#analytics'), 
				[
					{ 
						label: 'Visits', 
						data: visits,
						color: '#0077cc'
					}
				], options);
		}
		
	});
});
</script>