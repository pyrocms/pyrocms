<fieldset>
	<legend>Manage Image</legend>
	<input type="hidden" id="image-name" value="<?=$image->name;?>" />
	<div style="display:none">
		<b>Image Name:</b>
		<br/><input id="image_caption" type="text" style="width:160px" value="" disabled="disabled" />
		<br/>
	</div>
	<strong>Preview</strong>
	<p>
		<img id="image-preview" src="<?=$this->config->item('tinycimm_controller');?>image/get/<?=$image->id;?>/300/200" />
	</p>
	<strong>Image Description:</strong>
	<p id="alttext-container">
		<textarea id="image-alttext" rows="4" cols="20"><?=$image->description;?></textarea>
	</p>
	<strong>Image Folder:</strong><br/>
	<p id="folder_select_list">
		<?=TinyCIMM_image::get_folders_select($image->folder_id);?>
	</p>
	<p id="manager-actions">
		<input id="update-image" type="button" value="Update" class="button update" />
		<input id="delete-image" type="button" value="Delete" class="button delete" />
	</p>
	<!--
	<strong>Image Info:</strong>
	<br/> 640 x 480px - 23KB
	-->
</fieldset>
