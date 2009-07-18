<h3><?= sprintf(lang('supp_edit_title'), $supplier->title); ?></h3>
<?= form_open_multipart('admin/suppliers/edit/' . $supplier->slug); ?>    
<p><?= image('suppliers/' . $supplier->image, '', array('title'=>$supplier->title)); ?></p>    
<div class="field">
	<label><?= lang('supp_website_label');?></label>
	<input type="text" name="url" class="text" id="url" maxlength="100" value="<?= $supplier->url; ?>" />
</div>
<div class="field">
	<label><?= lang('supp_category_label');?></label>
	<div class="float-left">
		<? foreach ($categories as $category):?>
			<? $checked = FALSE;?>
			<? foreach ($cur_categories as $current_cat): ?>
				<? if ($category->id == $current_cat['category_id']): ?>
					<? $checked = TRUE; ?>
				<? endif; ?>
			<? endforeach; ?>
			<?= form_checkbox('category['.$category->id.']', TRUE, $checked); ?> <?=$category->title ?><br />		
		<? endforeach; ?>
	</div>
</div>
<div class="field">
	<label><?= lang('supp_logo_change_label');?></label>
	<input type="file" class="text" name="userfile" id="userfile" />
</div>
<div class="field">
	<label><?= lang('supp_desc_label');?></label>
	<?=form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $supplier->description, 'rows' => 10, 'class'=>'wysiwyg-simple')); ?>
</div>
<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>