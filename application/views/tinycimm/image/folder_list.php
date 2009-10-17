<ul class="folderlist">
	<?foreach($folders as $folder):?>
	<li>
		<span class="folder-row" id="folder-<?=$folder['id'];?>" onMouseOver="this.style.color='#000066';this.style.background='#EEEEEE';" onMouseOut="this.style.color='#000000';this.style.background='#FFFFFF';">
			<span class="editimg">
				<!--
				<a href="javascript:;">
					<img height="13" onclick="editFolder('53');" title="edit" src="img/pencil_sm.png"/>
				</a>
				-->
				<a href="javascript:;">
					<img onclick="TinyCIMMImage.deleteFolder('<?=$folder['id'];?>');" title="remove" src="img/delete.gif"/>
				</a>
			</span>
			<span class="foldername" onClick="TinyCIMMImage.fileBrowser('<?=$folder['id'];?>', 0, true, this);">
				<img class="folderimg" id="img-<?=$folder['id'];?>" src="img/folder.gif" />
				<?=$folder['name'];?>/
			</span>
		</span>
		<br class="clear" />
	</li>
	<?endforeach;?>
</ul>
