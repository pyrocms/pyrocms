<h3>Add supplier</h3>

<?= form_open_multipart('admin/suppliers/create'); ?>
<div class="field">	<label>Name</label>	<input type="text" name="title" class="text" id="title" maxlength="40" value="<?= $this->validation->title; ?>" /></div><div class="field">	<label>Website URL</label>	<input type="text" name="url" class="text" id="url" maxlength="100" value="<?= $this->validation->url; ?>" /></div><div class="field">	<label>Category</label>	
	<div class="float-left">		<? foreach ($categories as $category): ?>			<?= form_checkbox('category['.$category->id.']', TRUE); ?> <?=$category->title ?><br />		<? endforeach; ?>
	</div></div><div class="field">	<label>Logo</label>	<input type="file" class="text" name="userfile" id="userfile" value="<?= $this->validation->userfile; ?>" /></div><div class="field">	<label>Description</label>	<textarea name="description" class="text" id="body" rows="10" cols="60"><?= $this->validation->description; ?></textarea></div>
<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?><?= form_close(); ?>