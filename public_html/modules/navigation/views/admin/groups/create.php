<h3>New navigation group</h3>
    
<?= form_open('admin/navigation/groups/create'); ?>

<fieldset>
	
	<legend>Group</legend>
	
	<div class="field">
		<label for="title">Title</label>
		<?= form_input('title', $this->validation->title, 'class="text"'); ?>
	</div>
	
	<div class="field">
		<label for="url">Abbreviation</label>
		<?= form_input('abbrev', $this->validation->abbrev, 'class="text"'); ?>
	</div>
	
</fieldset>

<p>
	<input type="image" name="btnSave" value="Save" src="/assets/img/admin/fcc/btn-save.jpg" />
	or
	<span class="fcc-cancel"><?= anchor('admin/navigation/index', 'Cancel'); ?></span>
</p>

<?= form_close(); ?>