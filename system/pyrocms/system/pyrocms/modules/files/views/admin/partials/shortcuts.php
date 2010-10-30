<nav id="shortcuts">
	<h6><?php echo lang('cp_shortcuts_title'); ?></h6>
	<ul>
		<li><?php echo anchor('admin/files/folders/create', lang('files.folders.create'), 'id="new_folder" class="add"'); ?></li>
		<?php if (isset($id)): ?>
		<li><?php echo anchor('admin/files/upload/'.$id, lang('files.upload.title'), 'id="new_files"'); ?></li>
		<?php endif; ?>
	</ul>
	<br class="clear-both" />
</nav>

<script type="text/javascript">
jQuery(function($) {
	$("#new_folder").colorbox({
		width:"400", height:"350", iframe:true,
		onClosed:function(){ location.reload(); }
	});
});
</script>