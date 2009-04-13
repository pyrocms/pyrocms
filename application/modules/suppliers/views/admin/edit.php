<h3>Edit supplier "<?= $supplier->title; ?>"</h3>

<?= form_open_multipart('admin/suppliers/edit/' . $supplier->slug); ?>    <p><?= image('suppliers/' . $supplier->image, '', array('title'=>$supplier->title)); ?></p>    <div class="field">	<label>Website URL</label>	<input type="text" name="url" class="text" id="url" maxlength="100" value="<?= $supplier->url; ?>" /></div><div class="field">	<label>Category</label>	<div class="float-left">
		<? foreach ($categories as $category):			$checked = FALSE;			foreach ($cur_categories as $current_cat) {				if ($category->id == $current_cat['category_id']) {					$checked = TRUE;				}			}
		?>
		<?= form_checkbox('category['.$category->id.']', TRUE, $checked); ?> <?=$category->title ?><br />	
		
		<? endforeach; ?>
	</div>
</div><div class="field">	<label>Change Logo</label>	<input type="file" class="text" name="userfile" id="userfile" /></div><div class="field">	<label>Description</label>	<textarea name="description" class="text" id="description" rows="10" cols="60"><?= $supplier->description; ?></textarea></div>
<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>