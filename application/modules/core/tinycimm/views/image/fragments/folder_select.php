<select name="uploadfolder" id="folderselect">
	<optgroup label="Folders">
		<option value="">(<?php echo strtolower(lang('tinycimm_image_folder_none'));?>)</option>
		<?php foreach($folders as $folderinfo):?>
			<?php if ($folderinfo['id']) {?>
				<option value="<?php echo $folderinfo['id'];?>"<?php echo ($folder_id==$folderinfo['id'])?' selected':'';?>><?php echo $folderinfo['name'];?></option>
			<?php }?>
		<?php endforeach;?>
	</optgroup>
</select>
