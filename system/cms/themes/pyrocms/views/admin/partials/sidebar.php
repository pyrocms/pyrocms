<aside class="aside-sm nav-vertical <?php if (isset($_COOKIE['persistent_sidebar']) and $_COOKIE['persistent_sidebar'] == 'true') echo 'only-icon'; ?> animated-zing fadeInLeft" data-exit-animation="fadeOut" id="sidebar">

	<section class="vertical-box">

		<header class="nav-bar header">
		
			<a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#sidebar, body">
				<i class="fa fa-reorder"></i>
			</a>
		

			<a class="nav-brand n-p" href="<?php echo site_url('/'); ?>" target="_blank">

				<!-- Icon -->
				<span class="icon">
					<?php echo Asset::img('icon-logo-white.png', 'PyroCMS', array('height' => '24px', 'id' => 'brand-icon')); ?>
				</span>

			</a>


			<a class="btn btn-link visible-xs hidden" data-toggle="class:show" data-target=".nav-user">
				<i class="icon-comment-alt"></i>
			</a>

		</header>


		<section>

			<?php file_partial('navigation'); ?>

		</section>


		<footer class="hidden-xs">
			<nav class="nav-primary hidden-xs">
				<ul class="nav">
					<li>
						<a href="#" data-toggle="class:only-icon" data-target="#sidebar" data-persistent="sidebar" class="btn btn-sm btn-link">
							<i class="fa fa-reorder"></i>
						</a>
					</li>
				</ul>
			</nav>
		</footer>


	</section>

</aside>