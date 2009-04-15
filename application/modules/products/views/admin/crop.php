<?= js('jquery/jquery.imgareaselect.js');?>
<?= js('crop.js', 'products');?>
<script type="text/javascript">
function preview(img, selection) { 
	var scaleX = <?=$this->config->item('product_width');?> / selection.width; 
	var scaleY = <?=$this->config->item('product_height');?> / selection.height; 
	
	$('#thumbnail_preview').css({ 
		width: Math.round(scaleX * <?php echo $image_data['width'];?>) + 'px', 
		height: Math.round(scaleY * <?php echo $image_data['height'];?>) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
	});
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
} 
</script>

<div class="float-left">
	<h3>Original Image</h3>
	<?= image('products/' . $image, '', array('id'=>'thumbnail', 'title'=>'Drag the box to crop this image')); ?>
</div>

<div class="float-left spacer-left">
	<h3>Croped Image</h3>
	
	<div style="position:relative; overflow:hidden; width:<?=$this->settings->item('product_width');?>px; height:<?=$this->settings->item('product_height');?>px;">
		<?= image('products/' . $image, '', array('style'=>'position: relative;', 'alt' => 'Thumbnail Preview', 'title'=>'Drag the box to crop this image', 'id' => 'thumbnail_preview')); ?>
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