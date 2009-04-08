<?= form_open($this->uri->uri_string()); ?>

<div class="field">
	<label for="title">Title</label>
	<?= form_input('title', $this->validation->title, 'class="text"'); ?>
</div>

<div class="field">
	<label for="description">Description</label>
	<?= $this->spaw->show(); ?>
</div>

<? if( $this->uri->segment(3,'create') == 'create' ): ?>
<div class="field">
	<label for="title">Featured</label>
	<input type="checkbox" name="featured" />
</div>
<? endif; ?>

<p>
	<input type="image" name="btnSave" value="Send" src="/assets/img/admin/fcc/btn-save.jpg" />
	or
	<span class="fcc-cancel"><?= anchor('admin/packages/index', 'Cancel'); ?></span>
</p>

<?= form_close(); ?>