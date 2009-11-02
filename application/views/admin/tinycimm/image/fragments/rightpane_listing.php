<div id="filelist">
	<ul class="folderlist clearfix">
	<?if (sizeof($images) == 0) {?>
		<li>(folder is empty)</li>
	<?} else {?>
		<?foreach($images as $image):?>
		<li>
			<span class="clearfix list-item" id="image-<?=$image['id'];?>" onclick="TinyCIMMImage.loadResizer('<?=$image['id'].$image['extension'];?>', event)" title="insert image" onMouseOver="this.style.color='#000066';this.style.background='#EEEEEE';" onMouseOut="this.style.color='#000000';this.style.background='#FFFFFF';">
				<span class="list-controls">
					<a href="#" title="delete image" class="delete" onclick="TinyCIMMImage.deleteImage(<?=$image['id'];?>);return false">&nbsp;</a>
					<a href="#" title="insert thumbnail" class="thumbnail" onclick="TinyCIMMImage.insertThumbnail(this, '<?=$image['filename'];?>');return false">&nbsp;</a>
	</span>
				<img id="img-<?=$image['id'];?>" class="image_preview" src="img/icons/<?=str_replace('.', '', $image['extension']);?>.gif" />
				<?=substr($image['name'], 0, 34);?>
			</span>
		</li>
		<?endforeach;?>
	<?}?>
	</ul>
</div>
<?=$this->pagination->create_links();?>
