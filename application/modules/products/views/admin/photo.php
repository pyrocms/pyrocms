<h3><?php echo $product->title?></h3>
<?php echo form_open('admin/products/deletephoto');?>
	<div class="float-left" style="width: 100%">	
		<?php foreach($photos as $photo): ?>
			<div class="float-left" style="margin:5px;text-align:center;<?php echo ($photo->for_display != 0)? "background-color:#FF0000;":'';?>">
				<input type="checkbox" name="delete[<?php echo $photo->image_id; ?>]" /><br />
				<?php echo image('products/' . substr($photo->filename, 0, -4) . '_thumb' . substr($photo->filename, -4), '', array('title'=>$product->title));?><br />
				<?php echo ($photo->for_display != 0) ? lang('products_default_image_label') : anchor('admin/products/makedefault/'. $photo->image_id, lang('products_make_default_label')); ?>
			</div>
		<?php endforeach; ?>		
	</div>	
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?php echo form_close(); ?>

<?php echo form_open_multipart('admin/products/addphoto/' . $this->uri->segment(4)); ?>
	<p>
		<label for="userfile"><?php echo lang('products_photo_label');?>:</label><br />
		<input type="file" name="userfile" id="userfile" />
	</p>
	<input type="hidden" name="product_id" value="<?php echo $product->id; ?>" />
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?php echo form_close(); ?>