<? if($this->uri->segment(3,'create') == 'create'): ?>
	<h2>Create Product</h2>
	
<? else: ?>
	<h2>Edit Product "<?= $product->title; ?>"</h2>
<? endif; ?>        
<?= form_open_multipart($this->uri->uri_string()); ?><div class="field">	<label for="title">Title</label>	<?= form_input('title', $product->title, 'class="text"'); ?></div><div class="field">	<label for="price">Price (<?= $this->settings->item('currency');?>)</label>	<?= form_input('price', $product->price, 'class="text width-5"'); ?></div>

<div class="field">
	<label for="category_slug">Category</label>
	<select name="category_slug" id="category_slug" size="1">
	<? if ($categories) {		foreach ($categories as $category) {			$selected = '';			if ($category->slug == $product->category_slug) {				$selected = ' selected="selected"';			}			echo '<option value="' . $category->slug . '"' . $selected . '>' . $category->title . '</option>';		}	} else {		echo '<option value="">-- Add a Category --</option>';	} ?>
	</select>
	<?= anchor('admin/categories/create', 'Create a new category'); ?>
</div>

<div class="field">	<label for="supplier_slug">Suppliers</label>	<select name="supplier_slug" id="supplier_slug" size="1">
	<? if ($suppliers) {		foreach ($suppliers as $supplier) {			$selected = '';			if ($supplier->slug == $product->supplier_slug) {				$selected = ' selected="selected"';			}			echo '<option value="' . $supplier->slug . '"' . $selected . '>' . $supplier->title . '</option>';		}	} else {		echo '<option value="">-- Add a Supplier --</option>';	} ?>
	</select>
	<?= anchor('admin/suppliers/create', 'Create a new supplier'); ?></div>

<? if($this->uri->segment(3,'create') == 'create'): ?>
<div class="field">
	<label for="userfile">Item Photo</label>
	<input type="file" name="userfile" id="userfile" class="text" />
</div>
<? endif; ?>
<div class="field">	<label for="body">Description</label>	<?= $this->spaw->show(); ?></div>
<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>

<?= form_close(); ?>