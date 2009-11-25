<h3><?php echo lang('supp_create_title');?></h3>
<?php echo form_open_multipart('admin/suppliers/create'); ?>
<div class="field">
	<label><?php echo lang('supp_name_label');?></label>
	<input type="text" name="title" class="text" id="title" maxlength="40" value="<?php echo $this->validation->title; ?>" />
</div>
<div class="field">
	<label><?php echo lang('supp_website_label');?></label>
	<input type="text" name="url" class="text" id="url" maxlength="100" value="<?php echo $this->validation->url; ?>" />
</div>
<div class="field">
	<label><?php echo lang('supp_category_label');?></label>	
	<div class="float-left">
		<?php foreach ($categories as $category): ?>
			<?php echo form_checkbox('category['.$category->id.']', TRUE); ?> <?php echo $category->title ?><br />
		<?php endforeach; ?>
	</div>
</div>
<div class="field">
	<label><?php echo lang('supp_logo_label');?></label>
	<input type="hidden" name="userfile" />
	<input type="file" class="text" name="userfile" id="userfile" value="<?php echo $this->validation->userfile; ?>" />
</div>
<div class="field">
	<label><?php echo lang('supp_desc_label');?></label>
	<?php echo form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $this->validation->description, 'rows' => 10, 'class'=>'wysiwyg-simple')); ?>
</div>
<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?php echo form_close(); ?>