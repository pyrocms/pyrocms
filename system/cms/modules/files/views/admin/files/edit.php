<section class="title">
	<h4><?php echo sprintf(lang('files.edit_title'), $file->name); ?></h4>
</section>

<section>
	<?php echo form_open_multipart(uri_string(), array('class' => 'form_inputs', 'id' => 'files_crud')); ?>
	<fieldset>
		<ul>
			<li class="even">
				<?php echo form_label(lang('files.name_label'), 'name'); ?>
				<?php echo form_input('name', $file->name, 'class="crud"'); ?>
			</li>
			<li>
				<?php echo form_label(lang('files.description_label'), 'description'); ?>
				<?php echo form_textarea(array(
					'name'	=> 'description',
					'id'	=> 'description',
					'value'	=> $file->description,
					'rows'	=> '3',
					'cols'	=> '50'
				)); ?>
			</li>
			<li class="even">
				<?php echo form_label(lang('file_folders.folder_label'), 'folder_id'); ?>
				<?php echo form_dropdown('folder_id', array(0 => lang('files.dropdown_no_subfolders')) + $folders_tree, $file->folder_id, 'id="folder_id" class="crud"');
				?>
			</li>
			<li>
				<?php echo form_label(lang('files.file_label'), 'userfile'); ?>
				<?php echo form_upload(array(
					'name'	=> 'userfile',
					'id'	=> 'userfile'
				)); ?>
			</li>
		</ul>

		<div class="align-right buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )); ?>
		</div>
	</fieldset>
	<?php echo form_close(); ?>
</section>