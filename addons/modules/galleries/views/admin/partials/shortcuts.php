<nav id="shortcuts">
	<h6><?php echo lang('cp_shortcuts_title'); ?></h6>
	<?php $colorbox = ''; if(!empty($galleries)) $colorbox = 'upload_colorbox'; ?>
	<ul>
		<li><?php echo anchor('admin/galleries/create'	, lang('galleries.new_gallery_label'), 'class="add"') ?></li>
		<li><?php echo anchor('admin/galleries/upload'	, lang('galleries.upload_label'), 'class="add '.$colorbox.'"'); ?></li>
		<li><?php echo anchor('admin/galleries'			, lang('galleries.list_label')); ?></li>
	</ul>
	<br class="clear-both" />
</nav>
