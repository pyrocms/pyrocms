<aside class="background-color-red aside-md" id="nav">

	<section class="vertical-box">

		<header class="dker nav-bar">
			<a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="body">
			<i class="icon-reorder"></i>
			</a>
			<a href="#" class="nav-brand" data-toggle="fullscreen">todo</a>
			<a class="btn btn-link visible-xs" data-toggle="class:show" data-target=".nav-user">
			<i class="icon-comment-alt"></i>
			</a>
		</header>

		<footer class="footer bg-gradient hidden-xs">
			<a href="modal.lockme.html" data-toggle="ajaxModal" class="btn btn-sm btn-link m-r-n-xs pull-right">
			<i class="icon-off"></i>
			</a>
			<a href="#nav" data-toggle="class:nav-vertical" class="btn btn-sm btn-link m-l-n-sm">
			<i class="icon-reorder"></i>
			</a>
		</footer>


		<section>


			<nav class="nav-primary hidden-xs">

				<ul class="nav">

					<li id="dashboard-link"><?php echo anchor('admin', lang('global:dashboard'), 'class="top-link '.( ! $this->module ? 'current ' : '').'"') ?></li>

					<?php foreach ($menu_items as $key => $menu_item): ?>

						<?php if (is_array($menu_item)): ?>

							<li class="dropdown-submenu"><a href="<?php echo current_url(); ?>#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang_label($key); ?></a>

								<ul class="dropdown-menu">

								<?php foreach ($menu_item as $lang_key => $uri): ?>

									<li><a href="<?php echo site_url($uri); ?>"><?php echo lang_label($lang_key); ?></a></li>

								<?php endforeach; ?>

								</ul>

							</li>

						<?php elseif (is_array($menu_item) and count($menu_item) == 1): ?>

							<?php foreach ($menu_item as $lang_key => $uri): ?>

								<li><a href="<?php echo site_url($menu_item); ?>"><?php echo lang_label($lang_key); ?></a></li>
							
							<?php endforeach; ?>

						<?php elseif (is_string($menu_item)): ?>

							<li><a href="<?php echo site_url($menu_item); ?>"><?php echo lang_label($key); ?></a></li>

						<?php endif; ?>

					<?php endforeach; ?>

				</ul>

			</nav>

		</section>

	</section>

</aside>