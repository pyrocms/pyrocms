<?php echo form_open('admin/files');?>
	<h3><?php echo $folder->name; ?></h3>
	<div id="files_toolbar">
		<ul>
			<li>
				<label for="folder"><?php echo lang('files.subfolders.label'); ?>:</label>
				<?php 
				$folder_options['0'] = $sub_folders[0];
				foreach($sub_folders as $row)
				{
					if ($row['id'] == $id OR $row['parent_id'] > 0)
					{
						$indent = ($row['parent_id'] != 0 && isset($row['depth'])) ? repeater('&nbsp;&raquo;&nbsp;', $row['depth']) : '';
						$folder_options[$row['id']] = $indent.$row['name'];
					}
				}	
				echo form_dropdown('parent_id', $folder_options, $folder->parent_id, 'id="parent_id" class="required"');
				?>
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
