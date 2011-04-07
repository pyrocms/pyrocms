<h2><?php echo $this->method === 'create'
	? lang('file_folders.create_title')
	: sprintf(lang('file_folders.edit_title'), $folder->name); ?></h2>

<?php echo form_open($this->uri->uri_string(), array('class' => 'crud', 'id' => 'folders_crud')); ?>
<fieldset>
	<ol>
		<li class="even">
			<label for="name"><?php echo lang('file_folders.name_label'); ?></label>
			<?php echo form_input('name', $folder->name, 'class="required"'); ?>
		</li>
		<li class="">
			<label for="slug"><?php echo lang('file_folders.slug_label'); ?></label>
			<?php echo form_input('slug', $folder->slug, 'class="required"'); ?>
		</li>
		<li id="folders-dropdown" class="even">
			<?php echo form_label(lang('file_folders.parent_label'), 'parent_id'); ?>
			<?php echo form_dropdown('parent_id', array(0 => lang('files.dropdown_no_subfolders')) + $folders_tree, $folder->parent_id, 'id="parent_id" class="required"'); ?>
		</li>
	</ol>

	<div class="buttons align-right padding-top">
	<?php if ($this->method === 'create'): ?>
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save_exit') )); ?>
	<?php endif; ?>
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )); ?>
	</div>
</fieldset>
<?php echo form_close(); ?>