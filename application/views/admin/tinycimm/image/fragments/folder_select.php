<select name="uploadfolder" id="folderselect">
	<optgroup label="Folders">
		<option value="">(<?php echo strtolower(lang('tinycimm_image_folder_none'));?>)</option>
		<?foreach($folders as $folderinfo):?>
			<?if ($folderinfo['id']) {?>
				<option value="<?php echo $folderinfo['id'];?>"<?php echo ($folder_id==$folderinfo['id'])?' selected':'';?>><?php echo $folderinfo['name'];?></option>
			<?}?>
		<?endforeach;?>
	</optgroup>
</select>
