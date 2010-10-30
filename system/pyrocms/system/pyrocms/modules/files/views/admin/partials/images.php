<?php echo form_open('admin/media');?>
	<div id="toolbar">
		<ul>
			<li>
				<label for="folder"><?php echo lang('media.folders.label'); ?>:</label>
				<?php echo form_dropdown('folder', $folders, $selected_folder); ?>
			</li>
		</ul>
	</div>
	<?php if (!empty($files)): ?>

		<!-- TODO: Write File list table -->

	<?php else: ?>
		<p><?php echo lang('media.no_files');?></p>
	<?php endif; ?>

<?php echo form_close();?>
