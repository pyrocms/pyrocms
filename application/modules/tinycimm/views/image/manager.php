<fieldset style="padding:0em 1em">
	<legend>
		<?php echo lang('tinycimm_image_manage'); ?>
	</legend>
	<span id="loading" style="margin-top:1em;">
		<?php echo lang('tinycimm_image_caching'); ?>
	</span>
	<div id="image-manager-details">
		<input type="hidden" id="image-name" value="<?php echo $image->name;?>" />
		<div class="left" style="margin-right:20px">
			<div style="margin-top:4px;">
				<a id="image-preview-popup" href="<?php echo $this->config->item('tinycimm_asset_path').$image->id.$image->extension;?>" title="view larger version">
					<img id="image-preview" src="<?php echo $this->config->item('tinycimm_image_controller');?>get/<?php echo $image->id;?>/270/320" />
				</a>
			</div>
			<p>
				<?php
					$image->filesize = $image->filesize/1024;
					echo $image->width.' x '.$image->height.'px - ';
					echo ($image->filesize > 1024) ?  round($image->filesize/1024, 2).'mb' : round($image->filesize).'kb';
				?>
			</p>
		</div>
		<div class="left">
			<strong>
				<?php echo lang('tinycimm_image_filename'); ?>:
			</strong>
			<p>
				<input type="text" id="image-filename" value="<?php echo $image->filename;?>" />
			</p>
			<strong>
				<?php echo lang('tinycimm_image_description'); ?>:
			</strong>
			<p id="alttext-container">
				<textarea id="image-alttext" rows="4" cols="12"><?php echo $image->description;?></textarea>
			</p>
			<p id="folder-select-list" style="margin-bottom:20px">
				<strong>
					<?php echo lang('tinycimm_image_folder'); ?>:
				</strong><br/>
				<?php echo $this->tinycimm->get_folders('select', $image->folder_id);?>
			</p>
			<input class="button" value="<?php echo lang('tinycimm_image_update');?>" type="button" id="update-image" />
			or
			<select id="manager-actions">
				<option value="">
					<?php echo strtolower(lang('tinycimm_image_select')); ?>..
				</option>
				<option value="delete">
					<?php echo lang('tinycimm_image_delete'); ?>
				</option>
				<option value="insert">
					<?php echo lang('tinycimm_image_insert'); ?>
				</option>
				<option value="download">
					<?php echo lang('tinycimm_image_download'); ?>
				</option>
			</select>
		</div>
	</div>
</fieldset>
