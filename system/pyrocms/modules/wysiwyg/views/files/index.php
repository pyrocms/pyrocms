<div id="upload-box">
	<h2><?php echo lang('files.upload.title'); ?><span class="close ui-icon ui-icon-closethick">Close</span></h2>
		<?php echo form_open_multipart('admin/wysiwyg/upload'); ?>
		
		<?php echo form_hidden('redirect_to', 'files'); ?>
		<p>
			<?php echo form_input('name', set_value('name',lang('files.folders.name'))); ?>
			<?php echo form_upload('userfile'); ?>
		</p>
		<p>
			<?php echo form_dropdown('type', $file_types, array($this->input->post('type'))); ?>
		</p>
		<p>
			<?php echo form_dropdown('folder_id', $folder_options); ?>
		</p>
		<p>
			<?php echo form_submit('button_action', lang('buttons.save'), 'class="button"'); ?>
		</p>
		<?php echo form_close(); ?>
  </div>

<div id="files_browser">
  
    <div id="files_left_pane">
        <h3><?php echo lang('files.folders.label'); ?></h3>
            <ul id="files-nav">
                
                <?php foreach($folders as $key => $folder): ?>
                
                <li id="folder-id-<?php echo $folder->id; ?>" class="<?php echo $key == 0 ? 'current' : ''; ?>">
                    <?php echo anchor("admin/wysiwyg/files/index/{$folder->id}", $folder->name, 'title="'.$folder->slug.'"'); ?>  
                </li>
                
                <?php endforeach; ?>
                
                <li class="upload">
                    <?php echo anchor("admin/wysiwyg/files/upload", lang('files.upload.title'), 'title="upload"'); ?>  
                </li>
                
            </ul>
    </div>
    
    <div id="files_right_pane">
        <div id="files-wrapper">
        <?php if(!empty($active_folder)): ?>
        
        <h3><?php echo $active_folder->name; ?></h3>
        
        <div id="files_toolbar">
            
            <ul>
			<li>
				<label for="folder"><?php echo lang('files.subfolders.label'); ?>:</label>
				<?php echo form_dropdown('parent_id', $folder_options, $active_folder->id, 'id="parent_id" title="files"'); ?>
			</li>
            </ul>
            
        </div>
        
        <?php  if(!empty($active_folder->items)): ?>
        <table class="table-list" border="0">
            
            <thead>
                
                <tr>
                    <th><?php echo lang('files.labels.action'); ?></th>
                    <th><?php echo lang('files.folders.name') . '/' . lang('files.description'); ?></th>
                    <th><?php echo lang('files.file_name') . '/' . lang('files.folders.created'); ?></th>
                    <th><?php echo lang('wysiwyg.meta.mime'); ?></th>
                </tr>
                
            </thead>
            
            <tbody>
                
                <?php foreach($active_folder->items as $file): ?>
                <tr class="<?php echo alternator('', 'alt'); ?>">
                    <td class="image">
						<button onclick="javascript:insertFile('<?php echo $file->id; ?>', '<?php echo htmlentities($file->name); ?>');">
							Insert
						</button>
					</td>
                    <td class="name-description">
                        <p><?php echo $file->name; ?><p>
                        <p><?php echo $file->description; ?></p>
                    </td>
                    <td class="filename">
                        <p><?php echo $file->filename; ?></p>
                        <p><?php echo date('Y.m.d', $file->date_added); ?></p>
                    </td>
                    <td class="meta width"><?php echo $file->mimetype; ?></td>
                </tr>
                <?php endforeach; ?>
            
            </tbody>
            
        </table>
        <?php else: ?>
        <p><?php echo lang('files.no_files'); ?></p>
        <?php endif; ?>
		
		<?php else: ?>
		<p><?php echo lang('files.folders.no_folders'); ?><?php echo anchor('admin/files/folders/create', lang('files.folders.create'), 'class="button"'); ?></p>
        <?php endif; ?>
        </div>
    </div>
    
</div>