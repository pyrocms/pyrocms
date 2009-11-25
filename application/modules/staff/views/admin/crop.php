<script type="text/javascript">
	var staffNoImgSelectedError = '<?php echo lang('staff_no_img_selected_error');?>';
	var staffWidth = '<?php echo $this->config->item('staff_width');?>';
	var staffHeight = '<?php echo $this->config->item('staff_height');?>';
	var imageDataWidth = '<?php echo $image_data['width'];?>';
	var imageDataHeight = '<?php echo $image_data['height'];?>';
</script>
<?php echo js('jquery/jquery.imgareaselect.js'); ?>
<?php echo js('staff.js', 'staff'); ?>

	<h3><?php echo lang('staff_crop_image_title');?></h3>
	
	<div style="float:left;">
		<h3><?php echo lang('staff_original_image_label');?></h3>
			<?php echo image('staff/' . $image, '', array('id'=>'thumbnail', 'title'=> lang('staff_original_image_desc'))); ?>
	</div>
	
	<div style="float:left; padding-left:20px;">
		<h3><?php echo lang('staff_cropped_image_label');?></h3>
			<div style="position:relative; overflow:hidden; width:<?php echo $this->config->item('staff_width');?>px; height:<?php echo $this->config->item('staff_height');?>px;">
				<?php echo image('staff/' . $image, '', array('style'=>'position: relative;', 'alt' => lang('staff_thumb_preview_label'), 'title'=> lang(''), 'id' => 'thumbnail_preview')); ?>
			</div>
	</div>
	<br style="clear:both;"/>
	<?php echo form_open('admin/staff/crop/' . $this->uri->segment(4)); ?>
		<input type="hidden" name="x1" id="x1" value="" />
		<input type="hidden" name="y1" id="y1" value="" />
		<input type="hidden" name="x2" id="x2" value="" />
		<input type="hidden" name="y2" id="y2" value="" />
		<p><input type="submit" id="save_thumb" name="btnCrop" value="Crop Image" /></p>
	<?php echo form_close(); ?>