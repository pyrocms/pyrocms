<?php echo form_open('admin/files');?>
	<div id="toolbar">
		<ul>
			<li>
				<label for="folder"><?php echo lang('files.folders.label'); ?>:</label>
				<?php echo form_dropdown('folder', $folders, $selected_folder); ?>
			</li>
		</ul>
	</div>
	<?php if (!empty($media_folders)): ?>

		<!-- TODO: Write File list table -->

	<?php else: ?>
		<p><?php echo lang('files.no_files');?></p>
	<?php endif; ?>

<?php echo form_close();?>
