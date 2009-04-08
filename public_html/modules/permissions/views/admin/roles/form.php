<? if($this->uri->segment(4,'create') == 'create'): ?>
	<h3>Create role</h3>
	
<? else: ?>
	<h3>Edit role "<?= $permission_role->title; ?>"</h3>
<? endif; ?>      <?= form_open($this->uri->uri_string()); ?><div class="field">
	<label for="title">Title</label>
	<?= form_input('title', $permission_role->title, 'class="text"'); ?>
</div>

<div class="field">
	<label for="abbrev">Abbreviation</label>
	
	<? if($this->uri->segment(4,'create') == 'create'): ?>
	<?= form_input('abbrev', $permission_role->abbrev, 'class="text width-10"'); ?>
	
	<? else: ?>
	<?= $permission_role->abbrev; ?>
	<? endif; ?>
</div>

<p>
	<input type="image" name="btnSave" value="Save" src="/assets/img/admin/fcc/btn-save.jpg" />
	or
	<span class="fcc-cancel"><?= anchor('admin/permisisons/index', 'Cancel'); ?></span>
</p><?= form_close(); ?>