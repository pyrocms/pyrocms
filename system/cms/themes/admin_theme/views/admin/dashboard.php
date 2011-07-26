<?php if ((isset($analytic_visits) OR isset($analytic_views)) AND $theme_options->analytics_graph == 'yes'): ?>
<script type="text/javascript">

	jQuery(function($) {
		var visits = <?php echo isset($analytic_visits) ? $analytic_visits : 0; ?>;
		var views = <?php echo isset($analytic_views) ? $analytic_views : 0; ?>;
		
		$('#analytics').css({
			height: '300px',
			width: '95%'
		});

		$.plot($('#analytics'), [{ label: 'Visits', data: visits },{ label: 'Page views', data: views }], {
			lines: { show: true },
			points: { show: true },
			grid: { hoverable: true, backgroundColor: '#fffaff' },
			series: {
				lines: { show: true, lineWidth: 1 },
				shadowSize: 0
			},
			xaxis: { mode: "time" },
			yaxis: { min: 0},
			selection: { mode: "x" }
		});
		
		function showTooltip(x, y, contents) {
			$('<div id="tooltip">' + contents + '</div>').css( {
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5,
				border: '1px solid #fdd',
				padding: '2px',
				'background-color': '#fee',
				opacity: 0.80
			}).appendTo("body").fadeIn(200);
		}
	 
		var previousPoint = null;
		
		$("#analytics").bind("plothover", function (event, pos, item) {
			$("#x").text(pos.x.toFixed(2));
			$("#y").text(pos.y.toFixed(2));
	 
				if (item) {
					if (previousPoint != item.dataIndex) {
						previousPoint = item.dataIndex;
						
						$("#tooltip").remove();
						var x = item.datapoint[0],
							y = item.datapoint[1];
						
						showTooltip(item.pageX, item.pageY,
									item.series.label + " : " + y);
					}
				}
				else {
					$("#tooltip").remove();
					previousPoint = null;            
				}
		});
	
	});
</script>

<div id="analytics" class="line" style="padding-bottom: 10px"></div>
<?php endif; ?><!-- End Analytics -->

	<!-- Dashboard Widgets FTW -->
		{pyro:widgets:area slug="dashboard"}
	<!-- Then End -->
	
	
	<!-- Begin Recent Comments -->
	<?php if (isset($recent_comments) AND is_array($recent_comments) AND $theme_options->recent_comments == 'yes'): ?>
		<section class="box unit size1of1">
			<header>
				<h3><?php echo lang('comments.recent_comments') ?></h3>
			</header>
			
			<ul class="recent-comments">
				<li class="clearfix icon"><a href="<?php echo site_url('admin/comments') . '">' . image('icons/comments.png'); ?></a></li>
				<?php foreach ($recent_comments AS $rant): ?>
					<li class="clearfix">
						<p><?php echo sprintf(lang('comments.list_comment'), $rant->name, $rant->item); ?> <em><?php echo $rant->comment; ?></em></p>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
	<?php endif; ?>
	<!-- End Recent Comments -->


	<!-- Begin Quick Links -->
	<?php if ($theme_options->quick_links == 'yes'): ?>
	<div class="line">
		<section class="box unit <?php echo isset($rss_items) ? 'size1of3' : 'size1of2'; ?>">
			<header>
				<h3><?php echo lang('cp_admin_quick_links') ?></h3>
			</header>
			
			<ul class="quick-links">
				<?php if(array_key_exists('comments', $this->permissions) OR $this->user->group == 'admin'): ?>
				<li class="clearfix">
					<?php echo image('icons/comments.png'); ?>
					<a href="<?php echo site_url('admin/comments') ?>"><h4><?php echo lang('cp_manage_comments'); ?></h4></a>
				</li>
				<?php endif; ?>
				
				<?php if(array_key_exists('pages', $this->permissions) OR $this->user->group == 'admin'): ?>
				<li class="clearfix">
					<?php echo image('icons/pages.png'); ?>
					<a href="<?php echo site_url('admin/pages') ?>"><h4><?php echo lang('cp_manage_pages'); ?></h4></a>
				</li>
				<?php endif; ?>
				
				<?php if(array_key_exists('files', $this->permissions) OR $this->user->group == 'admin'): ?>
				<li class="clearfix">
					<?php echo image('icons/folder_open.png'); ?>
					<a href="<?php echo site_url('admin/files') ?>"><h4><?php echo lang('cp_manage_files'); ?></h4></a>
				</li>
				<?php endif; ?>
				
				<?php if(array_key_exists('users', $this->permissions) OR $this->user->group == 'admin'): ?>
				<li class="clearfix">
					<?php echo image('icons/user.png'); ?>
					<a href="<?php echo site_url('admin/users') ?>"><h4><?php echo lang('cp_manage_users'); ?></h4></a>
				</li>
				<?php endif; ?>
			</ul>
		</section>
		<?php endif; ?>
		<!-- End Quick Links -->


		<!-- Begin RSS Feed -->
		<?php if ( isset($rss_items) AND $theme_options->news_feed == 'yes') : ?>
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
		<?php endif; ?>
		<!-- End RSS Feed -->
	</div>