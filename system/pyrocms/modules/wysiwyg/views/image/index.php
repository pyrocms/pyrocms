<div id="upload-box">
	<h2><?php echo lang('files.upload.title'); ?><span class="close ui-icon ui-icon-closethick">Close</span></h2>
		<?php echo form_open_multipart('admin/wysiwyg/upload'); ?>
		<?php echo form_hidden('type', 'i'); ?>
		<?php echo form_hidden('redirect_to', 'image'); ?>
		<p>
			<?php echo form_input('name', set_value('name',lang('files.folders.name'))); ?>
			<?php echo form_upload('userfile'); ?>
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
                    <?php echo anchor("admin/wysiwyg/image/index/{$folder->id}", $folder->name, 'title="'.$folder->slug.'"'); ?>  
                </li>
                
                <?php endforeach; ?>
                
				<?php if(!empty($folder_options)): ?>
                <li class="upload">
                    <?php echo anchor("admin/wysiwyg/image/#upload", lang('files.upload.title'), 'title="upload"'); ?>  
                </li>
				<?php endif; ?>
                
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
				<?php
				//$folder_options['0'] = $sub_folders[0];
				
				echo form_dropdown('parent_id', $folder_options, $active_folder->id, 'id="parent_id" title="image"');
				?>
			</li>
            </ul>
            
        </div>
        
        <div id="options-bar">
            
            <label for="insert_width"><?php echo lang('wysiwyg.label.insert_width'); ?></label>
            <input id="insert_width" type="text" name="insert_width" value="200" />
            
        </div>
        
        <div id="radio-group">
            <label for="insert_float"><?php echo lang('wysiwyg.label.float'); ?></label>
                <label for="radio_left"><?php echo lang('wysiwyg.label.left'); ?></label>
                <input id="radio_left" type="radio" name="insert_float" value="left" />
                
                <label for="radio_right"><?php echo lang('wysiwyg.label.right'); ?></label>
                <input id="radio_right" type="radio" name="insert_float" value="right" />
                
                <label for="radio_none"><?php echo lang('wysiwyg.label.none'); ?></label>
                <input id="radio_none" type="radio" name="insert_float" value="none" checked="checked" />
            </div>
        
        <div id="slider"></div>
        
        <?php  if(!empty($active_folder->items)): ?>
        <table class="table-list" border="0">
            
            <thead>
                
                <tr>
                    <th><?php echo lang('files.i'); ?></th>
                    <th><?php echo lang('files.folders.name') . '/' . lang('files.description'); ?></th>
                    <th><?php echo lang('files.file_name') . '/' . lang('files.folders.created'); ?></th>
                    <th><?php echo lang('wysiwyg.meta.width'); ?></th>
                    <th><?php echo lang('wysiwyg.meta.height'); ?></th>
                    <th><?php echo lang('wysiwyg.meta.size'); ?></th>
                </tr>
                
            </thead>
            
            <tbody>
                
                <?php foreach($active_folder->items as $file): ?>
                <tr class="<?php echo alternator('', 'alt'); ?>">
                    <td class="image"><img class="pyro-image" src="<?php echo base_url(); ?>uploads/files/<?php echo $file->filename; ?>" alt="<?php echo $file->name; ?>" width="50" onclick="javascript:insertImage('<?php echo $file->filename; ?>', '<?php echo htmlentities($file->name); ?>');" /></td>
                    <td class="name-description">
                        <p><?php echo $file->name; ?><p>
                        <p><?php echo $file->description; ?></p>
                    </td>
                    <td class="filename">
                        <p><?php echo $file->filename; ?></p>
                        <p><?php echo date('Y.m.d', $file->date_added); ?></p>
                    </td>
                    <td class="meta width"><?php echo $file->width; ?></td>
                    <td class="meta height"><?php echo $file->height; ?></td>
                    <td class="meta size"><?php echo $file->filesize; ?></td>
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