<? if($this->uri->segment(3,'create') == 'create'): ?>
	<h2>Create category</h2>
	
<? else: ?>
	<h2>Edit category "<?= $category->title; ?>"</h2>
<? endif; ?>

<?= form_open($this->uri->uri_string()); ?>

<div class="field">	<label for="title">Title</label>	<input type="text" name="title" id="title" class="text" maxlength="40" value="<?= $category->title; ?>" /></div><p>
	<input type="image" name="btnSave" value="Save" src="/assets/img/admin/fcc/btn-save.jpg" />
	or
	<span class="fcc-cancel"><?= anchor('admin/categories/index', 'Cancel'); ?></span>
</p>

<?= form_close(); ?>