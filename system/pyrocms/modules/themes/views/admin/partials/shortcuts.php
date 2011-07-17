<nav id="shortcuts">
	<h6><?php echo lang('cp_shortcuts_title'); ?></h6>
	<ul>
		<?php if ($this->settings->addons_upload): ?>
			<li><?php echo anchor('admin/themes/upload', lang('themes.upload_title'), 'class="add"'); ?></li>
		<?php endif; ?>
		<li><?php echo anchor('admin/themes', lang('themes.list_title')); ?></li>
	</ul>
	<br class="clear-both" />
</nav>