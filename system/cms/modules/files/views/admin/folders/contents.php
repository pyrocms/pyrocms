<h3><?php echo $crumbs; ?></h3>
<?php echo form_open('admin/files/action');?>
	<div id="files-toolbar">
		<ul>
			<li>
				<label for="folder"><?php echo lang('file_folders.subfolders_label'); ?></label>
				<?php echo form_dropdown('folder_path', $sub_folders, $folder->virtual_path, 'id="folder_path" class="folder-hash"'); ?>
			</li>
			<li>
				<label for="folder"><?php echo lang('files.filter_label'); ?></label>
				<?php echo form_dropdown('filter', array('' => lang('select.all')) + $types, $selected_filter, 'id="filter" class="folder-hash"'); ?>
			</li>
			<?php if (group_has_role('files', 'edit_file')): ?>
			<li class="buttons buttons-small">
				<?php echo form_hidden('folder_id', $folder->id); ?>
				<a href="<?php echo site_url('admin/files/upload/'.$folder->id);?>" class="button upload open-files-uploader">
					<?php echo lang('files.upload_title'); ?>
				</a>
			</li>
			<?php endif; ?>
		</ul>
	</div>

	<?php if ($files): ?>
	<div id="files-display">	
        <a href="#" title="grid" class="toggle-view"><?php echo lang('files.display_grid'); ?></a>
        <a href="#" title="list" class="toggle-view active-view"><?php echo lang('files.display_list'); ?></a>
	</div>

    <div id="grid" class="list-items">
        <?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all grid-check-all')); ?><?php echo lang('check.all'); ?><br />
        <ul class="grid clearfix">
        <?php foreach($files as $file): ?>
            <li>
                <div class="actions">
                <?php echo form_checkbox('action_to[]', $file->id); ?>
				<?php
					if (group_has_role('files', 'download_file')) 
					{
						echo anchor('files/download/' . $file->id, lang('files.download_label'), array('class' => 'download_file'));
					}
					
						if (group_has_role('files', 'edit_file')) 
					{
						echo anchor('admin/files/edit/' . $file->id, lang('buttons.edit'), array('class' => 'edit_file'));
					}
					
					if (group_has_role('files', 'delete_file')) 
					{
						echo anchor('admin/files/delete/' . $file->id, lang('buttons.delete'), array('class'=>'confirm'));
					}
				?>
                </div>
            <?php if ($file->type === 'i'): ?>
            <a title="<?php echo $file->name; ?>" href="<?php echo base_url() . UPLOAD_PATH . 'files/' . $file->filename; ?>" rel="colorbox">
                <img title="<?php echo $file->name; ?>" width="64" src="<?php echo site_url('files/thumb/' . $file->id . '/64/64'); ?>" alt="<?php echo $file->name; ?>" />
            </a>
            <?php else: ?>
                <?php echo image($file->type . '.png', 'files'); ?>
            <?php endif; ?>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>

	<table border="0" class="table-list" id="list">
		<thead>
			<tr>
				<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
				<th><?php echo lang('files.name_label'); ?></th>
				<th><?php echo lang('files.type_label'); ?></th>
				<th><?php echo lang('files.filename_label'); ?></th>
				<th width="100" class="align-center"><?php echo lang('file_folders.created_label'); ?></th>
				<th width="300" class="align-center"><?php echo lang('files.actions_label'); ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="6">
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($files as $file): ?>
			<tr>
				<td><?php echo form_checkbox('action_to[]', $file->id); ?></td>
				<td><?php echo $file->name; ?></td>
				<td><?php echo lang('files.type_'.$file->type); ?></td>
				<td><?php echo $file->filename; ?></td>
				<td class="align-center"><?php echo format_date($file->date_added); ?></td>
				<td class="align-center buttons buttons-small">
				<?php 
					if (group_has_role('files', 'download_file')) 
					{
						echo anchor('files/download/' . $file->id, lang('files.download_label'), array('class' => 'button download download_file'));
					}
					
						if (group_has_role('files', 'edit_file')) 
					{
						echo anchor('admin/files/edit/' . $file->id, lang('buttons.edit'), array('class' => 'button edit edit_file'));
					}
					
					if (group_has_role('files', 'delete_file')) 
					{
						echo anchor('admin/files/delete/' . $file->id, lang('buttons.delete'), array('class'=>'confirm button delete'));
					}
				?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	
	<div class="buttons align-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
	</div>

	<?php else: ?>
	<div class="blank-slate files">
		<h2><?php echo lang('files.no_files');?></h2>
	</div>
	<?php endif; ?>
<?php echo form_close();?>