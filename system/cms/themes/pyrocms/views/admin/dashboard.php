<!-- Add an extra div to allow the elements within it to be sortable! -->
<div id="sortable">

	<!-- Dashboard Widgets -->
	{{ widgets:area slug="dashboard" }}
	
	<!-- Begin Quick Links -->
	<?php if ($theme_options->pyrocms_quick_links == 'yes') : ?>
	<div class="one_full">
		
		<section class="draggable title">
			<h4><?php echo lang('cp:admin_quick_links') ?></h4>
			<a class="tooltip-s toggle" title="Toggle this element"></a>
		</section>
		
		<section id="quick_links" class="item <?php echo isset($rss_items) ?>">
			<div class="content">
				<ul>
					<?php if((array_key_exists('comments', $this->permissions) OR $this->current_user->group == 'admin') AND module_enabled('comments')): ?>
					<li>
						<a class="tooltip-s" title="<?php echo lang('cp:manage_comments') ?>" href="<?php echo site_url('admin/comments') ?>"><?php echo Asset::img('icons/comments.png', lang('cp:manage_comments')) ?></a>
					</li>
					<?php endif ?>
					
					<?php if((array_key_exists('pages', $this->permissions) OR $this->current_user->group == 'admin') AND module_enabled('pages')): ?>
					<li>
						<a class="tooltip-s" title="<?php echo lang('cp:manage_pages') ?>" href="<?php echo site_url('admin/pages') ?>"><?php echo Asset::img('icons/pages.png', lang('cp:manage_pages')) ?></a>
					</li>
					<?php endif ?>
					
					<?php if((array_key_exists('files', $this->permissions) OR $this->current_user->group == 'admin') AND module_enabled('files')): ?>
					<li>
						<a class="tooltip-s" title="<?php echo lang('cp:manage_files') ?>" href="<?php echo site_url('admin/files') ?>"><?php echo Asset::img('icons/files.png', lang('cp:manage_files')) ?></a>
					</li>
					<?php endif ?>
					
					<?php if(array_key_exists('users', $this->permissions) OR $this->current_user->group == 'admin'): ?>
					<li>
						<a class="tooltip-s" title="<?php echo lang('cp:manage_users') ?>" href="<?php echo site_url('admin/users') ?>"><?php echo Asset::img('icons/users.png', lang('cp:manage_users')) ?></a>
					</li>
					<?php endif ?>
				</ul>
			</div>
		</section>

	</div>	
	<?php endif ?>
	<!-- End Quick Links -->

	<!-- Begin Recent Comments -->
	<?php if (isset($recent_comments) AND is_array($recent_comments) AND $theme_options->pyrocms_recent_comments == 'yes') : ?>
	<div class="one_full">
		
		<section class="draggable title">
			<h4><?php echo lang('comments:recent_comments') ?></h4>
			<a class="tooltip-s toggle" title="Toggle this element"></a>
		</section>
		
		<section class="item">
			<div class="content">
				<ul id="widget-comments">

					<?php if (count($recent_comments)): ?>
						<?php foreach ($recent_comments as $comment): ?>
							<li>
								<div class="comments-gravatar"><?php echo gravatar($comment->user_email) ?></div>
								<div class="comments-date"><?php echo format_date($comment->created_on) ?></div>
								<p>
									<?php echo sprintf(lang('comments:list_comment'), $comment->user_name, $comment->entry_title) ?> 
									<span><?php echo (Settings::get('comment_markdown') AND $comment->parsed > '') ? strip_tags($comment->parsed) : $comment->comment ?></span>
								</p>
							</li>
						<?php endforeach ?>
					<?php else: ?>
						<?php echo lang('comments:no_comments') ?>
					<?php endif ?>
				</ul>
			</div>
		</section>

	</div>		
	<?php endif ?>
	<!-- End Recent Comments -->
		
	
	<?php if ((isset($analytic_visits) OR isset($analytic_views)) AND $theme_options->pyrocms_analytics_graph == 'yes'): ?>
	<script type="text/javascript">
	
	$(function($) {
			var visits = <?php echo isset($analytic_visits) ? $analytic_visits : 0 ?>;
			var views = <?php echo isset($analytic_views) ? $analytic_views : 0 ?>;
	
			var buildGraph = function() {
				$.plot($('#analytics'), [{ label: 'Visits', data: visits },{ label: 'Page views', data: views }], {
					lines: { show: true },
					points: { show: true },
					grid: { hoverable: true, backgroundColor: '#fefefe' },
					series: {
						lines: { show: true, lineWidth: 1 },
						shadowSize: 0
					},
					xaxis: { mode: "time" },
					yaxis: { min: 0},
					selection: { mode: "x" }
				});
			}
			// create the analytics graph when the page loads
			buildGraph();
	
			// re-create the analytics graph on window resize
			$(window).resize(function(){
				buildGraph();
			});
			
			function showTooltip(x, y, contents) {
				$('<div id="tooltip">' + contents + '</div>').css( {
					position: 'absolute',
					display: 'none',
					top: y + 5,
					left: x + 5,
					'border-radius': '3px',
					'-moz-border-radius': '3px',
					'-webkit-border-radius': '3px',
					padding: '3px 8px 3px 8px',
					color: '#ffffff',
					background: '#000000',
					opacity: 0.80
				}).appendTo("body").fadeIn(500);
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
						$("#tooltip").fadeOut(500);
						previousPoint = null;            
					}
			});
		
		});
	</script>
	<div class="one_full">
		<section class="title">
			<h4>Statistics</h4>
		</section>	
		<section class="item">
			<div class="content">
				<div id="analytics"></div>
			</div>
		</section>
	</div>
	
	<?php endif ?>
	<!-- End Analytics -->

	<!-- Begin RSS Feed -->
	<?php if ( isset($rss_items) AND $theme_options->pyrocms_news_feed == 'yes') : ?>
	<div id="feed" class="one_full">
		
		<section class="draggable title">
			<h4><?php echo lang('cp:news_feed_title') ?></h4>
			<a class="tooltip-s toggle" title="Toggle this element"></a>
		</section>
		
		<section class="item">
			<div class="content">
				<ul>
					<?php foreach($rss_items as $rss_item): ?>
					<li>
							
						<?php
							$item_date	= strtotime($rss_item->get_date());
							$item_month = date('M', $item_date);
							$item_day	= date('j', $item_date);
						?>
							
						<div class="date">
							<div class="time">
								<span class="month">
									<?php echo $item_month ?>
								</span>
								<span class="day">
									<?php echo $item_day ?>
								</span>
							</div>
						</div>
						<div class="post">
							<h4><?php echo anchor($rss_item->get_permalink(), $rss_item->get_title(), 'target="_blank"') ?></h4>
													
							<p class='item_body'><?php echo $rss_item->get_description() ?></p>
						</div>
					</li>
					<?php endforeach ?>
				</ul>
			</div>
		</section>

	</div>		
	<?php endif ?>
	<!-- End RSS Feed -->
	<script type="text/javascript">
		(function ($) {

			$('#remove_installer_directory').on('click', function (e) {
				e.preventDefault();
				var $parent = $(this).parent();
				$.get(SITE_URL + 'admin/remove_installer_directory', function (data) {
					$parent.removeClass('warning').addClass(data.status).html(data.message);
				});
			});
		})(jQuery);
	</script>
</div>
<!-- End sortable div -->