<noscript>
	<span>PyroCMS requires that JavaScript be turned on for many of the functions to work correctly. Please turn JavaScript on and reload the page.</span>
</noscript>

<div class="topbar" dir=<?php $vars = $this->load->_ci_cached_vars; echo $vars['lang']['direction']; ?>>
	
	<div class="wrapper">
		<div id="logo">
			<?php echo anchor('', $this->settings->site_name, 'target="_blank"'); ?>
		</div>
	
		<nav>
			<?php file_partial('navigation'); ?>
		</nav>
	</div>
	
</div>

<div class="subbar">
	<div class="wrapper">
		<h2><?php echo $module_details['name'] ? anchor('admin/' . $module_details['slug'], $module_details['name']) : lang('cp_admin_home_title'); ?></h2>
	
		<small>
			<?php if ( $this->uri->segment(2) ) { echo '&nbsp; | &nbsp;'; } ?>
			<?php echo $module_details['description'] ? $module_details['description'] : ''; ?>
		</small>

			<?php template_partial('shortcuts'); ?>
	</div>
</div>

<?php file_partial('notices'); ?>