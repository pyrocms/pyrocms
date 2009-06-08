				<!-- Site title -->
				<div id="site_title">
					<h1><img src="<?php echo base_url(); ?>application/themes/pyrocms/img/logo.png" alt="PyroCMS" width="170" height="80" /></h1>
				</div>
				<!-- Navigation menu -->
				<div id="navigation">
					<ul>
					<?php if(!empty($navigation['header'])) foreach($navigation['header'] as $nav_link): ?>					
						<li><?php echo anchor($nav_link->url, $nav_link->title, $nav_link->current_link ? 'id="current"' : ''); ?></li><?php endforeach; ?>
					
					</ul>
				</div>
				<div class="clear"></div>
				<!-- Banner -->
				<div id="banner">
					<!-- Site slogan -->
					<div id="slogan">
						<h2><?php echo $this->settings->item('site_slogan'); ?></h2>
					</div>
					<!-- Mini downloads, a la CodeIgniter -->
					<div id="mini_downloads">
						
					</div>
				</div>