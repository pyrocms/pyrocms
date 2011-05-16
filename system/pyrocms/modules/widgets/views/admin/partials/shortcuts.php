<nav id="shortcuts">
	<h6><?php echo lang('cp_shortcuts_title'); ?></h6>
	<ul>
		<li><?php echo anchor('admin/widgets', 'List Widgets'); ?></li>
		<?php if ($this->method == 'index'): ?>
		<li><?php echo anchor('admin/widgets/areas/create', lang('widgets.add_area'), 'class="add create-area"') ?></li>
		<?php endif; ?>
		<li><?php echo anchor('admin/widgets/manage', 'Manage Widgets'); ?></li>
	</ul>
	<br class="clear-both" />
</nav>
