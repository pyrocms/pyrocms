<fieldset style="padding:0em 1em">
	<legend>Manage Image</legend>
	<input type="hidden" id="image-name" value="<?=$image->name;?>" />
	<div style="display:none">
		<b>Image Name:</b>
		<br/><input id="image_caption" type="text" style="width:160px" value="" disabled="disabled" />
		<br/>
	</div>
	<div style="margin-top:4px;">
		<p>
			<a id="image-preview-popup" href="<?=$this->config->item('tinycimm_asset_path').$image->id.$image->extension;?>" title="view larger version">
				<img id="image-preview" src="<?=$this->config->item('tinycimm_controller');?>image/get/<?=$image->id;?>/280/200" />
			</a>
		</p>
	</div>
	<?php
		$dimensions = getimagesize($this->config->item('tinycimm_asset_path_full').$image->id.$image->extension);
		$image->filesize = $image->filesize/1024;
	?>
	<p>
		<strong><?=$image->name;?></strong><br/>
		<?=$dimensions[0].' x '.$dimensions[1];?>px - <?=($image->filesize > 1024 ? round($image->filesize/1024, 2).'mb' : round($image->filesize).'kb');?>
	</p>
	<strong>Image Description:</strong>
	<p id="alttext-container">
		<textarea id="image-alttext" rows="4" cols="20"><?=$image->description;?></textarea>
	</p>
	<p id="folder-select-list">
		<strong>Image Folder:</strong><br/>
		<?=TinyCIMM_image::get_folders_select($image->folder_id);?>
	</p>
	<p id="manager-actions">
		<a href="javascript:;" id="update-image">
			<img src="img/image_save.png" alt="update" />[Update]
		</a>&nbsp;
		<a href="javascript:;" id="download-image" class="hidden">
			<img src="img/image_restore.png" alt="download" />[Download]
		</a>
		<a href="javascript:;" id="delete-image">
			<img src="img/image_delete.png" alt="delete" />[Delete]
		</a>&nbsp;
		<a href="javascript:;" id="insert-image">
			<img src="img/insertthumb.gif" alt="insert" />[Insert]
		</a>

	</p>
</fieldset>
