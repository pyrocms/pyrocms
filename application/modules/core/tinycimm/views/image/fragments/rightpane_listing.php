<div id="filelist">
	<ul class="folderlist clearfix">
	<?php if (sizeof($images) == 0) {?>
		<li>(<?php echo strtolower(lang('tinycimm_image_empty_folder'));?>)</li>
	<?php } else {?>
		<?php foreach($images as $image):?>
		<li>
			<span class="clearfix list-item" id="image-<?php echo $image['id'];?>" onclick="TinyCIMMImage.loadResizer('<?php echo $image['id'].$image['extension'];?>', event)" title="insert image" onMouseOver="this.style.color='#000066';this.style.background='#EEEEEE';" onMouseOut="this.style.color='#000000';this.style.background='#FFFFFF';">
				<span class="list-controls">
					<a href="#" title="delete image" class="delete" onclick="TinyCIMMImage.deleteImage(<?php echo $image['id'];?>);return false">&nbsp;</a>
					<a href="#" title="insert thumbnail" class="thumbnail" onclick="TinyCIMMImage.insertThumbnail(this, '<?php echo $image['filename'];?>');return false">&nbsp;</a>
	</span>
				<img id="img-<?php echo $image['id'];?>" class="image_preview" src="img/icons/<?php echo str_replace('.', '', $image['extension']);?>.gif" />
				<?php echo substr($image['name'], 0, 34);?>
			</span>
		</li>
		<?php endforeach;?>
	<?php }?>
	</ul>
</div>
<?php echo $this->pagination->create_links();?>
