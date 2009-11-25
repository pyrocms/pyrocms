<h3><?php echo sprintf(lang('supp_edit_title'), $supplier->title); ?></h3>
<?php echo form_open_multipart('admin/suppliers/edit/' . $supplier->slug); ?>    
<p><?php echo image('suppliers/' . $supplier->image, '', array('title'=>$supplier->title)); ?></p>    
<div class="field">
	<label><?php echo lang('supp_website_label');?></label>
	<input type="text" name="url" class="text" id="url" maxlength="100" value="<?php echo $supplier->url; ?>" />
</div>
<div class="field">
	<label><?php echo lang('supp_category_label');?></label>
	<div class="float-left">
		<?php foreach ($categories as $category):?>
			<?php $checked = FALSE;?>
			<?php foreach ($cur_categories as $current_cat): ?>
				<?php if ($category->id == $current_cat['category_id']): ?>
					<?php $checked = TRUE; ?>
				<?php endif; ?>
			<?php endforeach; ?>
			<?php echo form_checkbox('category['.$category->id.']', TRUE, $checked); ?> <?php echo $category->title ?><br />		
		<?php endforeach; ?>
	</div>
</div>
<div class="field">
	<label><?php echo lang('supp_logo_change_label');?></label>
	<input type="file" class="text" name="userfile" id="userfile" />
</div>
<div class="field">
	<label><?php echo lang('supp_desc_label');?></label>
	<?php echo form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $supplier->description, 'rows' => 10, 'class'=>'wysiwyg-simple')); ?>
</div>
<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?php echo form_close(); ?>