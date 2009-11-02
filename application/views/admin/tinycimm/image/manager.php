<fieldset style="padding:0em 1em">
	<legend>Manage Image</legend>
	<span id="loading" style="margin-top:1em;">caching image</span>
	<div id="image-manager-details">
		<input type="hidden" id="image-name" value="<?=$image->name;?>" />
		<div class="left" style="margin-right:20px">
			<div style="margin-top:4px;">
				<a id="image-preview-popup" href="<?=$this->config->item('tinycimm_asset_path').$image->id.$image->extension;?>" title="view larger version">
					<img id="image-preview" src="<?=$this->config->item('tinycimm_image_controller');?>get/<?=$image->id;?>/270/320" />
				</a>
			</div>
			<?php
				$image->filesize = $image->filesize/1024;
			?>
			<p>
				<?=$image->width.' x '.$image->height;?>px - <?=($image->filesize > 1024 ? round($image->filesize/1024, 2).'mb' : round($image->filesize).'kb');?>
			</p>
		</div>
		<div class="left">
			<strong>Filename:</strong>
			<p>
				<input type="text" id="image-filename" value="<?=$image->filename;?>" />
			</p>
			<strong>Image Description:</strong>
			<p id="alttext-container">
				<textarea id="image-alttext" rows="4" cols="12"><?=$image->description;?></textarea>
			</p>
			<p id="folder-select-list" style="margin-bottom:20px">
				<strong>Image Folder:</strong><br/>
				<?=$this->tinycimm->get_folders('select', $image->folder_id);?>
			</p>
			<input class="button" value="Update" type="button" id="update-image" />
			or
			<select id="manager-actions">
				<option value="">select..</option>
				<option value="delete">Delete</option>
				<option value="insert">Insert</option>
				<option value="download">Download</option>
			</select>
		</div>
	</div>
</fieldset>
