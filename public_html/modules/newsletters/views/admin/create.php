<?= form_open('admin/newsletters/create'); ?>

<div class="field clearfix">
	<label for="title">Title</label>
	<input type="text" id="title" name="title" maxlength="100" value="<?= $this->validation->title; ?>" />
</div>

<div class="field clearfix">
	<label for="body">Message</label>
	<?= $this->spaw->show(); ?>
</div>

<p>
	<input type="image" name="btnSave" value="Send" src="/assets/img/admin/fcc/btn-save.jpg" />
	or
	<span class="fcc-cancel"><?= anchor('admin/newsletters/index', 'Cancel'); ?></span>
</p>

<?= form_close(); ?>