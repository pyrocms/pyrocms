<h3>Add member of staff</h3><?= form_open_multipart('admin/staff/create'); ?>

<div class="field">
	<label for="user_id">User</label>
	<?=form_dropdown('user_id', $users, $this->validation->user_id) ?>
</div>

<div class="if-not-user">
	<div class="field if-not-user">
		<label for="name">Name</label>
		<?= form_input('name', $this->validation->name, 'class="text" maxlength="40"'); ?>
	</div>
	
	<div class="field">
		<label fpr="email">E-mail</label>
		<?= form_input('email', $this->validation->email, 'class="text" maxlength="40"'); ?>
	</div>
</div>

<div class="field">	<label for="userfile">Photo</label>	<input type="file" name="userfile" class="text" id="userfile" value="<?= $this->validation->userfile; ?>" /></div>

<div class="field">
	<label for="position">Job title</label>
	<?= form_input('position', $this->validation->position, 'class="text" maxlength="40"'); ?>
</div>

<div class="field">
	<label for="fact">Random Fact</label>
	<?= form_input('fact', $this->validation->fact, 'class="text"'); ?>
</div>
<div class="field">	<label>Biography</label>
	<?= $this->spaw->show(); ?></div>
<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>