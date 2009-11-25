<?php if($this->uri->segment(4,'create') == 'create'): ?>
	<h3><?php echo lang('role_create_title');?></h3>	
<?php else: ?>
	<h3><?php echo sprintf(lang('perm_role_edit_title'), $permission_role->title);?></h3>
<?php endif; ?>
      
<?php echo form_open($this->uri->uri_string()); ?>
<div class="field">
	<label for="title"><?php echo lang('perm_title_label');?></label>
	<?php echo form_input('title', $permission_role->title, 'class="text"'); ?>
</div>

<div class="field">
	<label for="abbrev"><?php echo lang('perm_abbrev_label');?></label>	
	<?php if($this->uri->segment(4,'create') == 'create'): ?>
		<?php echo form_input('abbrev', $permission_role->abbrev, 'class="text width-10"'); ?>	
	<?php else: ?>
		<?php echo $permission_role->abbrev; ?>
	<?php endif; ?>
</div>
<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?php echo form_close(); ?>