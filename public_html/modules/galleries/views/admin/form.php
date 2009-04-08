<? if($this->uri->segment(3,'create') == 'create'): ?>
	<h3>Create gallery</h3>

<? else: ?>
	<h3>Edit gallery "<?= $category->title; ?>"</h3>
<? endif; ?>

<?= form_open($this->uri->uri_string()); ?>

<div class="field">
	<label for="title">Title</label>
	<input type="text" id="title" name="title" maxlength="100" value="<?= $gallery->title; ?>" class="text" />
</div>

<div class="field width-two-thirds">
	<label for="parent">Parent gallery</label>		
	<select name="parent" size="1">
		<option value="">-- None --</option>
		<? create_tree_select($galleries, 0, 0, $gallery->parent, $gallery->id); ?>
	</select>
</div>

<div class="field width-full">
	<label for="body">Content</label>
	<?= $this->spaw->show(); ?>
</div>

<p>
	<input type="image" name="btnSave" value="Save" src="/assets/img/admin/fcc/btn-save.jpg" />
	or
	<span class="fcc-cancel"><?= anchor('admin/galleries/index', 'Cancel'); ?></span>
</p>

<?= form_close(); ?>