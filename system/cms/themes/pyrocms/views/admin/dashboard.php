<!-- left one_half -->
<div class="one_half">

	<!-- analytics -->
	<div class="one_half">
		<?php if ((isset($analytic_visits) or isset($analytic_views)) and $theme_options->pyrocms_analytics_graph == 'yes'): ?>
			<script type="text/javascript">
				jQuery(function($) {
					var visits = <?php echo isset($analytic_visits) ? $analytic_visits : 0; ?>;
					var views = <?php echo isset($analytic_views) ? $analytic_views : 0; ?>;

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
						} else {
							$("#tooltip").fadeOut(500);
							previousPoint = null;            
						}
					});
				});
			</script>

			<section class="title">
				<h4><i class="icon-signal"></i> Statistics</h4>
			</section>
	
			<div class="item" id="analyticsWrapper">
				<div id="analytics"></div>
			</div>
		<?php endif; ?>
	</div>
	<!-- /analytics -->

	<!-- rss feed -->
	<?php if ( isset($rss_items) and $theme_options->pyrocms_news_feed == 'yes') : ?>
		<div class="one_half" id="feed">
			<section class="title">
				<h4><i class="icon-list"></i> <?php echo lang('cp_news_feed_title'); ?></h4>
			</section>
		
			<section class="item">
				<ul class="nolist">
					<?php foreach($rss_items as $rss_item): ?>
						<li>
							<?php
								$item_date	= strtotime($rss_item->get_date());
								$item_month = date('M', $item_date);
								$item_day	= date('j', $item_date);
							?>
						
							<div class="date">
								<span class="month">
									<?php echo $item_month ?>
								</span>
								<span class="day">
									<?php echo $item_day; ?>
								</span>
							</div>
					
							<h5><?php echo anchor($rss_item->get_permalink(), $rss_item->get_title(), 'target="_blank"'); ?></h5>				
							<p class='item_body'><?php echo $rss_item->get_description(); ?></p>
						</li>
					<?php endforeach; ?>
				</ul>
			</section>
		</div>		
	<?php endif; ?>
	<!-- /rss feed -->

</div>
<!-- /left one_half -->

<!-- right one_half -->
<div class="one_half last">

	<!-- quick links -->
	<?php if ($theme_options->pyrocms_quick_links == 'yes') : ?>
		<div id="quick_links" class="one_half last">
			<section class="title <?php echo isset($rss_items); ?>">
				<h4><i class="icon-share"></i> <?php echo lang('cp_admin_quick_links') ?></h4>
			</section>

			<section class="item">
				<ul class="nolist">
					<?php if (isset($this->permissions['comments']) or $this->current_user->group === 'admin'): ?>
						<li>
							<a class="button orange" title="<?php echo lang('cp_manage_comments') ?>" href="<?php echo site_url('admin/comments') ?>">
								<i class="icon-comment icon-white"></i> <?php echo lang('cp_manage_comments') ?>
							</a>
						</li>
					<?php endif; ?>
				
					<?php if (isset($this->permissions['pages']) or $this->current_user->group === 'admin'): ?>
						<li>
							<a class="button orange" title="<?php echo lang('cp_manage_pages'); ?>" href="<?php echo site_url('admin/pages') ?>">
								<i class="icon-file icon-white"></i> <?php echo lang('cp_manage_pages'); ?>
							</a>
						</li>
					<?php endif; ?>
				
					<?php if (isset($this->permissions['files']) or $this->current_user->group === 'admin'): ?>
						<li>
							<a class="button orange" title="<?php echo lang('cp_manage_files'); ?>" href="<?php echo site_url('admin/files') ?>">
								<i class="icon-folder-open icon-white"></i> <?php echo lang('cp_manage_files'); ?>
							</a>
						</li>
					<?php endif; ?>
				
					<?php if (isset($this->permissions['users']) or $this->current_user->group === 'admin'): ?>
						<li>
							<a class="button orange" title="<?php echo lang('cp_manage_users'); ?>" href="<?php echo site_url('admin/users') ?>">
								<i class="icon-user icon-white"></i> <?php echo lang('cp_manage_users'); ?>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</section>
		</div>		
	<?php endif; ?>
	<!-- /quick links -->

	<!-- recent comments -->
	<?php if (isset($recent_comments) and is_array($recent_comments) and $theme_options->pyrocms_recent_comments == 'yes') : ?>
		<div id="existing-comments" class="one_half last">
			<section class="title">
				<h4><i class="icon-comment"></i> <?php echo lang('comments:recent_comments') ?></h4>
			</section>

			<section class="item">
				<?php if (count($recent_comments)): ?>
					<ul class="nolist">
						<?php foreach ($recent_comments as $comment) : ?>
							<li>
								<?php echo gravatar($comment->user_email, 100); ?>
								<p>
									<?php
										$title = $comment->uri ? anchor($comment->uri, $comment->entry_title) : $comment->entry_title;
										echo sprintf(lang('comments:list_comment'), $comment->user_name, $title);
									?>
									<?php echo (Settings::get('comment_markdown') AND $comment->parsed > '') ? strip_tags($comment->parsed) : $comment->comment; ?>
								</p>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php else: ?>
					<div class="block-message block-message-warning"><?php echo lang('comments:no_comments');?></div>
				<?php endif; ?>
			</section>
		</div>		
	<?php endif; ?>
	<!-- /recent comments -->

</div>
<!-- /right one_half -->

<!-- dashboard widgets -->
<div class="one_full">
	{{ widgets:area slug="dashboard" }}
</div>
<!-- /dashboard widgets -->
