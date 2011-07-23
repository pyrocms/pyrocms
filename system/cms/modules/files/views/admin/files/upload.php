<h2><?php echo lang('files.upload_title'); ?></h2>

<?php echo form_open_multipart(uri_string(), array('class' => 'crud', 'id' => 'files_crud')); ?>
<fieldset>
	<ol>
		<li class="even">
			<label for="nothing"><?php echo lang('files.file_label'); ?></label>
			<?php echo form_upload('userfile'); ?>
		</li>
		<li>
			<?php echo form_label(lang('files.name_label'), 'name'); ?>
			<?php echo form_input('name', $file->name); ?>
		</li>
		<li class="even">
			<?php echo form_label(lang('files.description_label'), 'description'); ?>
			<?php echo form_textarea(array(
				'name'	=> 'description',
				'id'	=> 'description',
				'value'	=> $file->description,
				'rows'	=> '3',
				'cols'	=> '50'
			)); ?>
		</li>
		<li>
			<?php echo form_label(lang('file_folders.folder_label'), 'folder_id'); ?>
			<?php echo form_dropdown('folder_id', $folders_tree, $file->folder_id, 'id="folder_id"'); ?>
		</li>
	</ol>

	<div class="align-right buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )); ?>
	</div>
</fieldset>
<?php echo form_close(); ?>