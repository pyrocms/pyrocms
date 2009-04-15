<?= js('jquery/jquery.imgareaselect.js'); ?>
<script type="text/javascript">
function preview(img, selection) { 
	var scaleX = <?=$this->config->item('staff_width');?> / selection.width; 
	var scaleY = <?=$this->config->item('staff_height');?> / selection.height; 
	
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

$(document).ready(function () { 
	$('#save_thumb').click(function() {
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
			alert("You must make a selection on the original image first.");
			return false;
		}else{
			return true;
		}
	});
}); 

$(window).load(function () { 
	$('#thumbnail').imgAreaSelect({ aspectRatio: '1:1', onSelectChange: preview }); 
});

</script>


	<h3>Crop Image</h3>
	
	<div style="float:left;">
		<h3>Original Image</h3>
			<?= image('staff/' . $image, '', array('id'=>'thumbnail', 'title'=>'Drag the box to crop this image')); ?>
	</div>
	<div style="float:left; padding-left:20px;">
		<h3>Croped Image</h3>
			<div style="position:relative; overflow:hidden; width:<?=$this->config->item('staff_width');?>px; height:<?=$this->config->item('staff_height');?>px;">
				<?= image('staff/' . $image, '', array('style'=>'position: relative;', 'alt' => 'Thumbnail Preview', 'title'=>'Drag the box to crop this image', 'id' => 'thumbnail_preview')); ?>
			</div>
	</div>
	<br style="clear:both;"/>
	<?= form_open('admin/staff/crop/' . $this->uri->segment(4)); ?>
		<input type="hidden" name="x1" id="x1" value="" />
		<input type="hidden" name="y1" id="y1" value="" />
		<input type="hidden" name="x2" id="x2" value="" />
		<input type="hidden" name="y2" id="y2" value="" />
		<p><input type="submit" id="save_thumb" name="btnCrop" value="Crop Image" /></p>
	<?= form_close(); ?>

