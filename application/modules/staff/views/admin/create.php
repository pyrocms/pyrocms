<h3><?php echo lang('staff_mamber_add_title');?></h3>

<?php echo form_open_multipart('admin/staff/create'); ?>

<div class="field">
	<label for="user_id"><?php echo lang('staff_user_label');?></label>
	<?php echo form_dropdown('user_id', $users, $this->validation->user_id) ?>
</div>

<div class="if-not-user">
	<div class="field if-not-user">
		<label for="name"><?php echo lang('staff_name_label');?></label>
		<?php echo form_input('name', $this->validation->name, 'class="text" maxlength="40"'); ?>
	</div>
	
	<div class="field">
		<label for="email"><?php echo lang('staff_email_label');?></label>
		<?php echo form_input('email', $this->validation->email, 'class="text" maxlength="40"'); ?>
	</div>
</div>

<div class="field">
	<label for="userfile"><?php echo lang('staff_photo_label');?></label>
	<input type="file" name="userfile" class="text" id="userfile" value="<?php echo $this->validation->userfile; ?>" />
</div>

<div class="field">
	<label for="position"><?php echo lang('staff_job_title_label');?></label>
	<?php echo form_input('position', $this->validation->position, 'class="text" maxlength="40"'); ?>
</div>

<div class="field">
	<label for="fact"><?php echo lang('staff_random_fact_label');?></label>
	<?php echo form_input('fact', $this->validation->fact, 'class="text"'); ?>
</div>

<div class="field">
	<label for="body"><?php echo lang('staff_biography_label');?></label>
	<?php echo form_textarea(array('id'=>'body', 'name'=>'body', 'value' => $this->validation->body, 'rows' => 10, 'class'=>'wysiwyg-simple')); ?>
</div>

<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?php echo form_close(); ?>