<select name="uploadfolder" id="folderselect">
	<optgroup label="Folders">
		<option value="">(none)</option>
		<?foreach($folders as $folderinfo):?>
			<?if ($folderinfo['id']) {?>
				<option value="<?=$folderinfo['id'];?>"<?=($folder_id==$folderinfo['id'])?' selected':'';?>><?=$folderinfo['name'];?></option>
			<?}?>
		<?endforeach;?>
	</optgroup>
</select>
