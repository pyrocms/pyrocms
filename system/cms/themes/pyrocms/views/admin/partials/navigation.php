<nav class="nav-primary hidden-xs">

	<ul class="nav">

		<!-- Start off with the dashboard link - Always -->
		<li id="dashboard-link">
			<a href="<?php echo site_url('admin'); ?>">
				<i class="icon-dashboard"></i>

				<span>
					<?php echo lang('global:dashboard'); ?>
				</span>
			</a>
		</li>

		<?php foreach ($menu_items as $key => $menu_item): ?>

			<?php if (isset($menu_item['items']) and is_array($menu_item['items'])): ?>

				<li class="dropdown-submenu <?php echo in_array(uri_string(), $menu_item['items']) ? 'has-active' : null; ?>">
					
					<a href="<?php echo current_url(); ?>#" class="dropdown-toggle" data-toggle="dropdown">
						<?php echo isset($menu_item['before']) ? $menu_item['before'] : null; ?>
						<span>
							<?php echo lang_label($menu_item['title']); ?>
						</span>
					</a>

					<ul class="dropdown-menu animated-zing fadeInUp">

						<li class="dropdown-header">
							<?php echo lang_label($menu_item['title']); ?>
						</li>

					<?php foreach ($menu_item['items'] as $lang_key => $uri): ?>

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

			<?php elseif (isset($menu_item['items']) and is_array($menu_item['items']) and count($menu_item['items']) == 1): ?>

				<?php foreach ($menu_item['items'] as $lang_key => $uri): ?>

					<li class="<?php echo uri_string() == $uri ? 'has-active' : null; ?>">
						<a href="<?php echo site_url($uri); ?>">
							<?php echo isset($menu_item['before']) ? $menu_item['before'] : null; ?>
							<span>
								<?php echo lang_label($lang_key); ?>
							</span>
						</a>
					</li>
				
				<?php endforeach; ?>

			<?php elseif (isset($menu_item['uri'])): ?>

				<li class="<?php echo uri_string() == $menu_item['uri'] ? 'has-active' : null; ?>">
					<a href="<?php echo site_url($menu_item['uri']); ?>">
						<?php echo isset($menu_item['before']) ? $menu_item['before'] : null; ?>
						<span>
							<?php echo lang_label($menu_item['title']); ?>
						</span>
					</a>
				</li>

			<?php endif; ?>

		<?php endforeach; ?>

	</ul>

</nav>