<noscript>
	<span>PyroCMS requires that JavaScript be turned on for many of the functions to work correctly. Please turn JavaScript on and reload the page.</span>
</noscript>

<div class="topbar" dir=<?php $vars = $this->load->get_vars(); echo $vars['lang']['direction'] ?>>
	<div class="topbar-inner">
		<div class="wrapper">
			<div id="logo">
				<!-- <?php echo anchor('', Asset::img('logo.png', 'view site'), 'target="_blank"') ?> -->
				<?php echo anchor('','<span id="pyro-logo"></span>', 'target="_blank"') ?>
			</div>
		
			<nav id="primary">
				<?php file_partial('navigation') ?>
			</nav>
			
			<div class="topbar-form">
				<form class="topbar-search">
					<input type="text" class="search-query" id="nav-search" placeholder="<?php echo lang("cp:search"); ?>" ontouchstart="">
				</form>
			</div>
			
		</div>
	</div>
	
</div>

<div class="subbar">
	<div class="wrapper">
		<div class="subbar-inner">
		
			<?php if ($this->module): ?>
			<h2><?php echo anchor('admin/'.$module_details['slug'], $module_details['name']) ?></h2>

			<small>
				<span class="divider">&nbsp; | &nbsp;</span>
				<?php echo $module_details['description'] ?>
				<span class="divider">&nbsp; | &nbsp;</span>
				<?php echo anchor('admin/help/core/'.$module_details['slug'], lang('help_label'), array('title' => $module_details['name'].'&nbsp;'.lang('help_label'), 'class' => 'modal')); ?>
			</small>

			<?php else: ?>
			<h2><?php echo lang('global:dashboard') ?></h2>
			<?php endif ?>
			
			<?php file_partial('shortcuts') ?>
	
		</div>
	</div>
</div>

<?php if ( ! empty($module_details['sections'])) file_partial('sections') ?>
