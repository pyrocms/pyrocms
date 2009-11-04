<div id="filelist" class="clearfix">
	<?php if (sizeof($images) == 0) {?>
		(<?php echo strtolower(lang('tinycimm_image_empty_folder'));?>)
	<?php } else {?>
		<?php foreach($images as $image):?>
			<span class="thumb-wrapper">
				<span class="thumb" 
					onclick="TinyCIMMImage.loadResizer('<?php echo $image['id'].$image['extension'];?>', event);" 
					style="background:url(<?php echo $this->config->item('tinycimm_image_controller');?>get/<?php echo $image['id'];?>/92/92) no-repeat center center;">
					<span class="loader"></span>
				</span>
				<span class="name-bg"></span>
				<span class="name"><span><?php echo htmlspecialchars($image['name']);?></span></span>
				<span class="controls-bg"></span>
				<span class="controls" style="height:15px">
					<!--
					<select style="border:0;margin:0;background:#FFF">
						<option>actions</option>
						<option value="insert">Insert</option>
						<option value="delete">Delete</option>
						<option value="view-edit">View/Edit</option>
						<option value="download">Download</option>
					</select>
					-->
					<a href="#" title="edit image" class="edit" onclick="TinyCIMMImage.showManager(this, <?php echo $image['id'];?>);return false;">&nbsp;</a>
					<a href="#" title="delete image" class="delete" onclick="TinyCIMMImage.deleteImage(<?php echo $image['id'];?>);return false;">&nbsp;</a>
					<a href="#" title="insert thumbnail" class="thumbnail" onclick="TinyCIMMImage.insertThumbnail(this, '<?php echo $image['id'];?>');return false;">&nbsp;</a>
				</span>
			</span>
		<?php endforeach;?>
	<?}?>
</div>
<?php echo $this->pagination->create_links();?>
