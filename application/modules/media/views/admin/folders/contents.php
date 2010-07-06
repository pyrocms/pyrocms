<?php echo form_open('admin/media');?>
	<h3><?php echo $folder->name; ?></h3>
	<div id="toolbar">
		<ul>
			<li>
				<label for="folder"><?php echo lang('media.subfolders.label'); ?>:</label>
				<?php echo form_dropdown('folder', $sub_folders, $selected_folder); ?>
			</li>
			<li><a href="#">Upload</a></li>
		</ul>
	</div>
	<?php if (!empty($files)): ?>

		<!-- TODO: Write File list table -->

	<?php else: ?>
		<p><?php echo lang('media.no_files');?></p>
	<?php endif; ?>

<?php echo form_close();?>
