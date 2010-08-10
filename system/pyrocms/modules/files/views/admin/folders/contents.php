<?php echo form_open('admin/files');?>
	<h3><?php echo $folder->name; ?></h3>
	<div id="files_toolbar">
		<ul>
			<li>
				<label for="folder"><?php echo lang('files.subfolders.label'); ?>:</label>
				<?php echo form_dropdown('folder', $sub_folders, $selected_folder); ?>
			</li>
				<li>
					<label for="folder">Filter:</label>
					<?php echo form_dropdown('filter', array("All", "Audio", "Video", "Images", "Documents", "Other")); ?>
				</li>
<!--			<li><a href="#">Upload</a></li> -->
		</ul>
	</div>
	<?php if (!empty($files)): ?>

		<!-- TODO: Write File list table -->

	<?php else: ?>
		<p><?php echo lang('files.no_files');?></p>
	<?php endif; ?>

<?php echo form_close();?>
