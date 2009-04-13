<h3>Edit member of staff "<?= $member->name; ?>"</h3>

<?= form_open_multipart('admin/staff/edit/' . $member->slug); ?>
<?= form_hidden('user_id', $member->user_id); ?>

<?= image('staff/' . $member->filename, '', array('title'=>$member->name));?>
	
<? if($member->user_id > 0): ?>

<div class="if-user">
	<div class="field">
		<label>Name</label>
		<p><?= $member->name; ?></p>
	</div>
	
	<div class="field">
		<label>E-mail</label>
		<p><?= $member->email; ?></p>
	</div>
</div>

<? else: ?>

<div class="if-not-user">
	<div class="field">
		<label FOR="name">Name</label>
		<?= form_input('name', $member->name, 'class="text" maxlength="40"'); ?>
	</div>
	
	<div class="field">
		<label for="email">E-mail</label>
		<?= form_input('email', $member->email, 'class="text" maxlength="40"'); ?>
	</div>
</div>

<? endif; ?>

<div class="field">
	<label for="userfile">Change Photo</label>
	<input type="file" class="text" name="userfile" id="userfile" maxlength="100" value="" />
</div>

<div class="field">
	<label for="position">Job title</label>
	<?= form_input('position', $member->position, 'class="text" maxlength="40"'); ?>
</div>

<div class="field">
	<label for="fact">Random Fact</label>
	<?= form_input('fact', $member->fact, 'class="text"'); ?>
</div>

<div class="field">
	<label>Biography</label>
	<?= $this->spaw->show(); ?>
</div>

<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>

<?= form_close(); ?>