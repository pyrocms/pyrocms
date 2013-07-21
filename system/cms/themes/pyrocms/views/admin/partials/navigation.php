<aside class="nav-collapse collapse">

	<div class="background visible-desktop"></div>
		
	<nav id="primary">

		<ul>

			<li class="<?php echo ( ! $this->module ? 'current ' : ''); ?>">
				<a href="<?php echo site_url('admin'); ?>" class="padded"><?php echo lang('global:dashboard') ?></a>
			</li>

			<?php ksort($menu_items); ?>
			
			<?php foreach ($menu_items as $key => $menu_item): ?>
				
				<?php if (is_array($menu_item)): ?>
					
					<li>
						<a href="<?php echo current_url(); ?>#" class="top-link padded"><?php echo lang_label($key); ?></a>

						<ul>

							<?php foreach ($menu_item as $lang_key => $uri): ?>
							
								<li class="<?php echo (strpos(current_url(), site_url($uri)) !== false) ? 'current' : ''; ?>">
									<a href="<?php echo site_url($uri); ?>"><?php echo lang_label($lang_key); ?></a>
								</li>

							<?php endforeach; ?>

						</ul>

					</li>

				<?php elseif (is_array($menu_item) and count($menu_item) == 1): ?>
					
					<?php foreach ($menu_item as $lang_key => $uri): ?>
					
						<li class="<?php echo (strpos(current_url(), site_url($uri)) !== false) ? 'current' : ''; ?>">
							<a href="<?php echo site_url($uri); ?>" class="top-link no-submenu padded"><?php echo lang_label($lang_key); ?></a>
						</li>

					<?php endforeach; ?>
					
				<?php elseif (is_string($menu_item)): ?>
					
					<li class="<?php echo (strpos(current_url(), site_url($menu_item)) !== false) ? 'current' : ''; ?>">
						<a href="<?php echo site_url($menu_item); ?>" class="top-link no-submenu padded"><?php echo lang_label($key); ?></a>
					</li>

				<?php endif; ?>

			<?php endforeach; ?>

		</ul>

	</nav>

</aside>