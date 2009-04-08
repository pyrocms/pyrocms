<h3>Edit member of staff "<?= $member->name; ?>"</h3>

<?= form_open_multipart('admin/staff/edit/' . $member->slug); ?>
<?= form_hidden('user_id', $member->user_id); ?>

<?= image('staff/' . $member->filename, '', array('title'=>$member->name));?>
	
<? if($member->user_id > 0): ?>

<div class="if-not-user">
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
		<label>Name</label>
		<input type="text" class="text" name="name" id="name" maxlength="40" value="<?= $member->name; ?>" />
	</div>
	
	<div class="field">
		<label>E-mail</label>
		<input type="text" class="text" name="email" id="email" maxlength="40" value="<?= $member->email; ?>" />
	</div>
</div>

<? endif; ?>

<div class="field">
	<label>Change Photo</label>
	<input type="file" class="text" name="userfile" id="userfile" maxlength="100" value="" />
</div>

<div class="field">
	<label>Job title</label>
	<input type="text" class="text" name="position" id="position" maxlength="40" value="<?= $member->position; ?>" />
</div>

<div class="field">
	<label>Random Fact</label>
	<input type="text" class="text" name="fact" id="fact" maxlength="100" value="<?= $member->fact; ?>" />
</div>

<div class="field">
	<label>Biography</label>
	<?= $this->spaw->show(); ?>
</div>

<input type="image" name="btnSave" value="Save" src="/assets/img/admin/fcc/btn-save.jpg" /> or <span class="fcc-cancel"><?= anchor('admin/suppliers/index', 'Cancel'); ?></span>
<?= form_close(); ?>