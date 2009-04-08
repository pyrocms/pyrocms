<h3>Add member of staff</h3><?= form_open_multipart('admin/staff/create'); ?>

<div class="field">
	<label>User</label>
	<?=form_dropdown('user_id', $users, $this->validation->user_id) ?>
</div>

<div class="if-not-user">
	<div class="field if-not-user">
		<label>Name</label>
		<input type="text" name="name" id="name" class="text" maxlength="40" value="<?= $this->validation->name; ?>" />
	</div>
	
	<div class="field">
		<label>E-mail</label>
		<input type="text" name="email" id="email" class="text" maxlength="40" value="<?= $this->validation->email; ?>" />
	</div>
</div>

<div class="field">	<label>Photo</label>	<input type="file" name="userfile" class="text" id="userfile" maxlength="100" value="<?= $this->validation->userfile; ?>" /></div>

<div class="field">
	<label>Job title</label>
	<input type="text" name="position" class="text" id="position" maxlength="40" value="<?= $this->validation->position; ?>" />
</div>

<div class="field">
	<label>Random Fact</label>
	<input type="text" name="fact" class="text" id="fact" maxlength="100" value="<?= $this->validation->fact; ?>" />
</div>
<div class="field">	<label>Biography</label>
	<?= $this->spaw->show(); ?></div>

<p>
	<input type="image" name="btnSave" value="Save" src="/assets/img/admin/fcc/btn-save.jpg" />
	 or 
	<span class="fcc-cancel"><?= anchor('admin/suppliers/index', 'Cancel'); ?></span></p>

<?= form_close(); ?>