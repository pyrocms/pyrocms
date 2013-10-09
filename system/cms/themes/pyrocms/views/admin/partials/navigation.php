<nav class="nav-primary hidden-xs">

	<ul class="nav">


		<!--
		/**
		 * Start off with the profile menu item when on mobiles
		 * - This helps the collapsed menu look nicer...
		 */
		-->
		<li class="dropdown-submenu visible-xs">
			<a href="#" class="dropdown-submenu" data-toggle="dropdown">
				<img src="https://gravatar.com/avatar/<?php echo md5($this->current_user->email); ?>" class="avatar-xs"/>
				<span>Ryan Thompson</span>
			</a>

			<ul class="dropdown-menu animated fadeInTop">
				<li class="dropdown-header">Ryan Thompson</li>
				<li><a href="<?php echo site_url('admin/settings'); ?>"><?php echo lang('cp:nav_settings'); ?></a></li>
				<li><a href="<?php echo site_url('edit-profile'); ?>"><?php echo lang('cp:edit_profile_label'); ?></a></li>
				<li><a href="<?php echo site_url('admin/logout'); ?>"><?php echo lang('cp:logout_label'); ?></a></li>
			</ul>
		</li>

		

		<!--
		/**
		 * The dashboard link is first. Period.
		 * - Don't ask question.
		 */
		-->
		<li id="dashboard-link">
			<a href="<?php echo site_url('admin'); ?>">
				<i class="icon-dashboard"></i>

				<span>
					<?php echo lang('global:dashboard'); ?>
				</span>
			</a>
		</li>



		<!--
		/**
		 * Normal module links
		 * - Be sure to define a sick icon!
		 */
		-->
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



		<!--
		/**
		 * When not in mobile - profile links are last
		 * - Chances are their avatar isn't meshing with the theme
		 * - So send them to the bottom, because we like beautiful things ^_^
		 */
		-->
		<li class="dropdown-submenu hidden-xs">
			<a href="#" class="dropdown-submenu" data-toggle="dropdown">
				<img src="https://gravatar.com/avatar/<?php echo md5($this->current_user->email); ?>" class="avatar-sm"/>
			</a>

			<ul class="dropdown-menu animated fadeInTop">
				<li class="dropdown-header">Ryan Thompson</li>
				<li><a href="<?php echo site_url('admin/settings'); ?>"><?php echo lang('cp:nav_settings'); ?></a></li>
				<li><a href="<?php echo site_url('edit-profile'); ?>"><?php echo lang('cp:edit_profile_label'); ?></a></li>
				<li><a href="<?php echo site_url('admin/logout'); ?>"><?php echo lang('cp:logout_label'); ?></a></li>
			</ul>
		</li>

	</ul>

</nav>