<script type="text/javascript">
	var productImageNoSelection = '<?=lang('products_image_no_selection');?>';
	var productImageWidth = '<?=$this->config->item('product_width');?>';
	var productImageHeight = '<?=$this->config->item('product_height');?>';
	var productImageDataWidth = '<?=$image_data['width'];?>';
	var productImageDataHeight = '<?=$image_data['height'];?>';
</script>
<?= js('jquery/jquery.imgareaselect.js');?>
<?= js('crop.js', 'products');?>

<div class="float-left">
	<h3><?=lang('products_image_original_label');?></h3>
	<?=image('products/' . $image, '', array('id' => 'thumbnail', 'title' => lang('products_image_crop_desc')));?>
</div>

<div class="float-left spacer-left">
	<h3><?=lang('products_image_cropped_label');?></h3>
	
	<div style="position:relative; overflow:hidden; width:<?=$this->settings->item('product_width');?>px; height:<?=$this->settings->item('product_height');?>px;">
		<?=image('products/' . $image, '', array('style' => 'position: relative;', 'alt' => lang('products_thumb_preview_label'), 'title' => lang('products_image_crop_desc'), 'id' => 'thumbnail_preview'));?>
	</div>
</div>

<br class="clear-both"/>

<?= form_open('admin/products/crop/' . $this->uri->segment(4)); ?>
	<input type="hidden" name="x1" id="x1" value="" />
	<input type="hidden" name="y1" id="y1" value="" />
	<input type="hidden" name="x2" id="x2" value="" />
	<input type="hidden" name="y2" id="y2" value="" />
	<p><input type="submit" id="save_thumb" name="btnCrop" value="Crop Image" /></p>
<?= form_close(); ?>