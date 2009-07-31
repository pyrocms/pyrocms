<? if($this->uri->segment(4,'create') == 'create'): ?>
	<h3><?= lang('role_create_title');?></h3>	
<? else: ?>
	<h3><?= sprintf(lang('perm_role_edit_title'), $permission_role->title);?></h3>
<? endif; ?>
      
<?= form_open($this->uri->uri_string()); ?>
<div class="field">
	<label for="title"><?= lang('perm_title_label');?></label>
	<?= form_input('title', $permission_role->title, 'class="text"'); ?>
</div>

<div class="field">
	<label for="abbrev"><?= lang('perm_abbrev_label');?></label>	
	<? if($this->uri->segment(4,'create') == 'create'): ?>
		<?= form_input('abbrev', $permission_role->abbrev, 'class="text width-10"'); ?>	
	<? else: ?>
		<?= $permission_role->abbrev; ?>
	<? endif; ?>
</div>
<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>