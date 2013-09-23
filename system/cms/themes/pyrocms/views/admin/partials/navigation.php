<nav class="nav-primary hidden-xs">

	<ul class="nav">

		<!-- Start off with the dashboard link - Always -->
		<li id="dashboard-link">
			<a href="<?php echo site_url('admin'); ?>">
				<b class="badge badge-danger pull-right">3</b>
				<i class="icon-dashboard"></i>

				<span>
					<?php echo lang('global:dashboard'); ?>
				</span>
			</a>
		</li>

		<?php foreach ($menu_items as $key => $menu_item): ?>

			<?php if (is_array($menu_item)): ?>

				<li class="dropdown-submenu">
					
					<a href="<?php echo current_url(); ?>#" class="dropdown-toggle" data-toggle="dropdown">
						<span>
							<?php echo lang_label($key); ?>
						</span>
					</a>

					<ul class="dropdown-menu">

					<?php foreach ($menu_item as $lang_key => $uri): ?>

						<li>
							<a href="<?php echo site_url($uri); ?>">
								<span>
									<?php echo lang_label($lang_key); ?>
								</span>
							</a>
						</li>

					<?php endforeach; ?>

					</ul>

				</li>

			<?php elseif (is_array($menu_item) and count($menu_item) == 1): ?>

				<?php foreach ($menu_item as $lang_key => $uri): ?>

					<li>
						<a href="<?php echo site_url($menu_item); ?>">
							<span>
								<?php echo lang_label($lang_key); ?>
							</span>
						</a>
					</li>
				
				<?php endforeach; ?>

			<?php elseif (is_string($menu_item)): ?>

				<li>
					<a href="<?php echo site_url($menu_item); ?>">
						<span>
							<?php echo lang_label($key); ?>
						</span>
					</a>
				</li>

			<?php endif; ?>

		<?php endforeach; ?>

	</ul>

</nav>