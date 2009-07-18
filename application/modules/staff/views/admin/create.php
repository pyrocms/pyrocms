<h3><?= lang('staff_mamber_add_title');?></h3>

<?= form_open_multipart('admin/staff/create'); ?>

<div class="field">
	<label for="user_id"><?= lang('staff_user_label');?></label>
	<?=form_dropdown('user_id', $users, $this->validation->user_id) ?>
</div>

<div class="if-not-user">
	<div class="field if-not-user">
		<label for="name"><?= lang('staff_name_label');?></label>
		<?= form_input('name', $this->validation->name, 'class="text" maxlength="40"'); ?>
	</div>
	
	<div class="field">
		<label for="email"><?= lang('staff_email_label');?></label>
		<?= form_input('email', $this->validation->email, 'class="text" maxlength="40"'); ?>
	</div>
</div>

<div class="field">
	<label for="userfile"><?= lang('staff_photo_label');?></label>
	<input type="file" name="userfile" class="text" id="userfile" value="<?= $this->validation->userfile; ?>" />
</div>

<div class="field">
	<label for="position"><?= lang('staff_job_title_label');?></label>
	<?= form_input('position', $this->validation->position, 'class="text" maxlength="40"'); ?>
</div>

<div class="field">
	<label for="fact"><?= lang('staff_random_fact_label');?></label>
	<?= form_input('fact', $this->validation->fact, 'class="text"'); ?>
</div>

<div class="field">
	<label for="body"><?= lang('staff_biography_label');?></label>
	<?=form_textarea(array('id'=>'body', 'name'=>'body', 'value' => $this->validation->body, 'rows' => 10, 'class'=>'wysiwyg-simple')); ?>
</div>

<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>