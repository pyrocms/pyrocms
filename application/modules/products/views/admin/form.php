<?php if($method == 'create'): ?>
	<h2><?php echo lang('products_create_title');?></h2>	
<?php else: ?>
	<h2><?php echo sprintf(lang('products_edit_title'), $product->title);?></h2>
<?php endif; ?>
        
<?php echo form_open_multipart($this->uri->uri_string()); ?>

	<div class="field">
		<label for="title"><?php echo lang('products_title_label');?></label>
		<?php echo form_input('title', $product->title, 'class="text"'); ?>
	</div>
	
	<div class="field">
		<label for="price"><?php echo lang('products_price_label');?> (<?php echo $this->settings->item('currency');?>)</label>
		<?php echo form_input('price', $product->price, 'class="text width-5"'); ?>
	</div>
	
	<div class="field">
		<label for="category_slug"><?php echo lang('products_category_label');?></label>
		<select name="category_slug" id="category_slug" size="1">
		<?php if ($categories) {
			foreach ($categories as $category) {
				$selected = '';
				if ($category->slug == $product->category_slug) {
					$selected = ' selected="selected"';
				}
				echo '<option value="' . $category->slug . '"' . $selected . '>' . $category->title . '</option>';
			}
		} else {
			echo '<option value="">'.lang('products_no_categorys_label').'</option>';
		} ?>
		</select>
		<?php echo anchor('admin/categories/create', lang('products_create_new_category_label')); ?>
	</div>
	
	<div class="field">
		<label for="supplier_slug"><?php echo lang('products_suppliers_label');?></label>
		<select name="supplier_slug" id="supplier_slug" size="1">
		<?php if ($suppliers) {
			foreach ($suppliers as $supplier) {
				$selected = '';
				if ($supplier->slug == $product->supplier_slug) {
					$selected = ' selected="selected"';
				}
				echo '<option value="' . $supplier->slug . '"' . $selected . '>' . $supplier->title . '</option>';
			}
		} else {
			echo '<option value="">'.lang('products_no_suppliers_label').'</option>';
		} ?>
		</select>
		<?php echo anchor('admin/suppliers/create', lang('products_create_new_supplier_label')); ?>
	</div>
	
	<?php if($method == 'create'): ?>
	<div class="field">
		<label for="userfile"><?php echo lang('products_photo_label');?></label>
		<input type="file" name="userfile" id="userfile" class="text" />
	</div>
	<?php endif; ?>
	
	<div class="field">
		<label for="description"><?php echo lang('products_desc_label');?></label>
		<?php echo form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $product->description, 'rows' => 10, 'class'=>'wysiwyg-simple')); ?>
	</div>
	
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?php echo form_close(); ?>