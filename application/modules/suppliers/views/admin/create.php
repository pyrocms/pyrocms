<h3><?= lang('supp_create_title');?></h3>
<?= form_open_multipart('admin/suppliers/create'); ?>
<div class="field">
	<label><?= lang('supp_name_label');?></label>
	<input type="text" name="title" class="text" id="title" maxlength="40" value="<?= $this->validation->title; ?>" />
</div>
<div class="field">
	<label><?= lang('supp_website_label');?></label>
	<input type="text" name="url" class="text" id="url" maxlength="100" value="<?= $this->validation->url; ?>" />
</div>
<div class="field">
	<label><?= lang('supp_category_label');?></label>	
	<div class="float-left">
		<? foreach ($categories as $category): ?>
			<?= form_checkbox('category['.$category->id.']', TRUE); ?> <?=$category->title ?><br />
		<? endforeach; ?>
	</div>
</div>
<div class="field">
	<label><?= lang('supp_logo_label');?></label>
	<input type="hidden" name="userfile" />
	<input type="file" class="text" name="userfile" id="userfile" value="<?= $this->validation->userfile; ?>" />
</div>
<div class="field">
	<label><?= lang('supp_desc_label');?></label>
	<?=form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $this->validation->description, 'rows' => 10, 'class'=>'wysiwyg-simple')); ?>
</div>
<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>