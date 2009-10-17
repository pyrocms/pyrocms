<select name="uploadfolder" id="folderselect">
	<optgroup label="Folders">
		<option value="">General</option>
		<?foreach($folders AS $folderinfo):?>
		<option value="<?=$folderinfo['id'];?>"<?=($folder_id==$folderinfo['id'])?' selected':'';?>><?=$folderinfo['name'];?></option>
		<?endforeach;?>
	</optgroup>
</select>
