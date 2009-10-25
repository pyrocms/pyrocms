<div id="filelist" class="clearfix">
	<?if (sizeof($images) == 0) {?>
		(folder is empty)
	<?} else {?>
		<?foreach($images as $image):?>
			<span class="thumb-wrapper">
				<span class="thumb" onclick="TinyCIMMImage.loadResizer('<?=$image['id'].$image['extension'];?>', event);" style="background:url(<?=$this->config->item('tinycimm_image_controller');?>get/<?=$image['id'];?>/92/92) no-repeat center center;">
					<span class="loader"></span>
				</span>
				<span class="name-bg"></span>
				<span class="name"><span><?=htmlspecialchars($image['name']);?></span></span>
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
					<a href="#" title="edit image" class="edit" onclick="TinyCIMMImage.showManager(this, <?=$image['id'];?>);return false;">&nbsp;</a>
					<a href="#" title="delete image" class="delete" onclick="TinyCIMMImage.deleteImage(<?=$image['id'];?>);return false;">&nbsp;</a>
					<a href="#" title="insert thumbnail" class="thumbnail" onclick="TinyCIMMImage.insertThumbnail(this, '<?=$image['id'];?>');return false;">&nbsp;</a>
				</span>
			</span>
		<?endforeach;?>
	<?}?>
</div>
<?=$this->pagination->create_links();?>
