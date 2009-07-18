<h3><?= $product->title?></h3>
<?= form_open('admin/products/deletephoto');?>
	<div class="float-left" style="width: 100%">	
		<? foreach($photos as $photo): ?>
			<div class="float-left" style="margin:5px;text-align:center;<?= ($photo->for_display != 0)? "background-color:#FF0000;":'';?>">
				<input type="checkbox" name="delete[<?= $photo->image_id; ?>]" /><br />
				<?= image('products/' . substr($photo->filename, 0, -4) . '_thumb' . substr($photo->filename, -4), '', array('title'=>$product->title));?><br />
				<?= ($photo->for_display != 0) ? lang('products_default_image_label') : anchor('admin/products/makedefault/'. $photo->image_id, lang('products_make_default_label')); ?>
			</div>
		<? endforeach; ?>		
	</div>	
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?= form_close(); ?>

<?= form_open_multipart('admin/products/addphoto/' . $this->uri->segment(4)); ?>
	<p>
		<label for="userfile"><?=lang('products_photo_label');?>:</label><br />
		<input type="file" name="userfile" id="userfile" />
	</p>
	<input type="hidden" name="product_id" value="<?= $product->id; ?>" />
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>