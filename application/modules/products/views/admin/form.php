<? if($this->uri->segment(3,'create') == 'create'): ?>
	<h2><?=lang('products_create_title');?></h2>	
<? else: ?>
	<h2><?=sprintf(lang('products_edit_title'), $product->title);?></h2>
<? endif; ?>
        
<?= form_open_multipart($this->uri->uri_string()); ?>

	<div class="field">
		<label for="title"><?=lang('products_title_label');?></label>
		<?= form_input('title', $product->title, 'class="text"'); ?>
	</div>
	
	<div class="field">
		<label for="price"><?=lang('products_price_label');?> (<?= $this->settings->item('currency');?>)</label>
		<?= form_input('price', $product->price, 'class="text width-5"'); ?>
	</div>
	
	<div class="field">
		<label for="category_slug"><?=lang('products_category_label');?></label>
		<select name="category_slug" id="category_slug" size="1">
		<? if ($categories) {
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
		<?= anchor('admin/categories/create', lang('products_create_new_category_label')); ?>
	</div>
	
	<div class="field">
		<label for="supplier_slug"><?=lang('products_suppliers_label');?></label>
		<select name="supplier_slug" id="supplier_slug" size="1">
		<? if ($suppliers) {
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
		<?= anchor('admin/suppliers/create', lang('products_create_new_supplier_label')); ?>
	</div>
	
	<? if($this->uri->segment(3,'create') == 'create'): ?>
	<div class="field">
		<label for="userfile"><?=lang('products_photo_label');?></label>
		<input type="file" name="userfile" id="userfile" class="text" />
	</div>
	<? endif; ?>
	
	<div class="field">
		<label for="description"><?=lang('products_desc_label');?></label>
		<?=form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $product->description, 'rows' => 10, 'class'=>'wysiwyg-simple')); ?>
	</div>
	
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>