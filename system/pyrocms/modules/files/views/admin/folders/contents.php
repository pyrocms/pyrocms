<?php echo form_open('admin/files');?>
	<h3><?php echo $folder->name; ?> <span><a href="<?php echo site_url('admin/files/upload/'.$id);?>" id="new_files"><?php echo lang('files.upload.title'); ?></a></span></h3>
	
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
		</ul>
	</div>
	<?php if ( ! empty($files)): ?>

		<?php
			$tmpl = array ( 'table_open'  => '<table border="0" class="table-list">' );
			$this->table->set_template($tmpl);
			$this->table->set_heading(
				form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')),
				lang('files.folders.name'),
				lang('files.type'),
				lang('files.file_name'),
				lang('files.folders.created'),
				'<span>'. lang('files.labels.action') .'</span>'
			);
				
				foreach ($files as $file)
				{
					$edit = anchor('admin/files/folders/edit/' . $file->id, lang('files.labels.edit'));
					$delete = anchor('admin/files/folders/delete/' . $file->id, lang('files.labels.delete'), array('class'=>'confirm'));
					$this->table->add_row(
					 	form_checkbox('action_to[]', $file->id),
					 	$file->name,
					 	lang('files.'.$file->type),
						$file->filename,
						date("m.d.y \a\\t g.i a", $file->date_added),
						$edit .' | '. $delete
					 );
				}

			echo $this->table->generate();
		?>

	<?php else: ?>
		<p><?php echo lang('files.no_files');?></p>
	<?php endif; ?>

<?php echo form_close();?>
