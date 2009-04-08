<h3><?= $product->title?></h3>

<div class="float-left" style="width: 100%">

<?= form_open('admin/products/deletephoto');?>

	<? foreach($photos as $photo): ?>
		<div class="float-left" style="margin:5px;text-align:center;<?= ($photo->for_display != 0)? "background-color:#FF0000;":'';?>">
			<input type="checkbox" name="delete[<?= $photo->image_id; ?>]" /><br />
			<?= image('products/' . substr($photo->filename, 0, -4) . '_thumb' . substr($photo->filename, -4), '', array('title'=>$product->title));?><br />
			<?= ($photo->for_display != 0) ? "Default Image" : anchor('admin/products/makedefault/'. $photo->image_id, "Make Default"); ?>
		</div>
	<? endforeach; ?>
	
</div>

<p>
	<input type="submit" name="btnDelete" value="Delete Selected" />
</p>

<?= form_close(); ?>


<?= form_open_multipart('admin/products/addphoto/' . $this->uri->segment(4)); ?>

<p><label for="userfile">Item Photo:</label><br />
<input type="file" name="userfile" id="userfile" /> <input type="hidden"
	name="product_id" value="<?= $product->id; ?>" /></p>

<p>
	<input type="submit" name="btnSave" value="Save" />
	 or <?= anchor('admin/products/index', 'Cancel'); ?>
</p>

<?= form_close(); ?>