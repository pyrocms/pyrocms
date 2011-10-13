<nav id="shortcuts">
	<ul>
		<li><?php echo anchor('admin/blog/create', lang('blog_create_title'), 'class="add"') ?></li>
		<li><?php echo anchor('admin/blog', lang('blog_list_title')); ?></li>
		<?php if (group_has_role('blog', 'addedit_categories')) : ?>
		<li><?php echo anchor('admin/blog/categories/create', lang('cat_create_title'), 'class="add"'); ?></li>
		<li><?php echo anchor('admin/blog/categories', lang('cat_list_title'))?></li>
		<?php endif; ?>
	</ul>
</nav>