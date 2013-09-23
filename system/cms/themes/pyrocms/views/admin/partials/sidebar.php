<aside class="aside-sm animated-zing fadeInLeft only-icon" id="sidebar">

	<section class="vertical-box">

		<header class="nav-bar header bg-brand-primary">
		
			<a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#sidebar, body">
				<i class="icon-reorder"></i>
			</a>
		

			<a class="nav-brand no-padding" href="<?php echo site_url('/'); ?>" target="_blank">

				<!-- Icon -->
				<span class="icon">
					<?php echo Asset::img('icon-logo-white.png', 'PyroCMS', array('height' => '32px')); ?>
				</span>

				<span class="color-white">PyroCMS</span>
			</a>


			<a class="btn btn-link visible-xs hidden" data-toggle="class:show" data-target=".nav-user">
				<i class="icon-comment-alt"></i>
			</a>

		</header>


		<footer class="footer bg-gradient hidden-xs">
			<a href="<?php echo site_url('admin/logout'); ?>" class="btn btn-sm btn-link m-r-n-xs pull-right">
				<i class="icon-off"></i>
			</a>

			<a href="#nav" data-toggle="class:nav-vertical" data-target="#sidebar" class="btn btn-sm btn-link">
				<i class="icon-reorder"></i>
			</a>
		</footer>


		<section>

			<!--

				Dashboard 		icon-dashboard
				Content 		icon-book
				Structure 		icon-sitemap
				Data 			icon-hdd
				Users			icon-group
				Settings		icon-cog
				Addons			icon-truck | icon-puzzle-piece
				User 			icon-user
				Misc			icon-folder-open

			-->


			<?php file_partial('navigation'); ?>

		</section>

	</section>

</aside>