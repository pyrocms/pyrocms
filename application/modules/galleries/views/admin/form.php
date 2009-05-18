<? if($this->uri->segment(3,'create') == 'create'): ?>
	<h3>Create gallery</h3>

<? else: ?>
	<h3>Edit gallery "<?= $gallery->title; ?>"</h3>
<? endif; ?>

<?= form_open($this->uri->uri_string()); ?>

<div class="field">
	<label for="title">Title</label>
	<input type="text" id="title" name="title" maxlength="255" value="<?= $gallery->title; ?>" class="text" />
	<span class="required-icon tooltip">Required</span>
</div>

<div class="field">
	<label for="parent">Parent gallery</label>		
	<select name="parent" size="1">
		<option value="">-- None --</option>
		<? create_tree_select($galleries, 0, 0, $gallery->parent, $gallery->id); ?>
	</select>
</div>

<div class="field">
	<label for="description">Description</label>
	<?=form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $gallery->description, 'rows' => 10, 'class' => 'wysiwyg-simple')); ?>
</div>

<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>

<?= form_close(); ?>