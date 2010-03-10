<ul class="folderlist">
	<?php foreach($folders as $folder):?>
	<li>
		<span class="folder-row" id="folder-<?php echo $folder['id'];?>" onMouseOver="this.style.color='#000066';this.style.background='#EEEEEE';" onMouseOut="this.style.color='#000000';this.style.background='#FFFFFF';">
			<?php if ($folder['id']): ?>
				<span class="folder-controls">
					<a href="javascript:;">
						<img onclick="TinyCIMMImage.editFolder(<?php echo $folder['id'];?>);" title="edit" src="img/pencil_sm.png"/>
					</a>
					<a href="javascript:;">
						<img onclick="TinyCIMMImage.deleteFolder('<?php echo $folder['id'];?>');" title="remove" src="img/delete.gif"/>
					</a>
				</span>
			<?php endif; ?>
			<span class="foldername" onClick="TinyCIMMImage.fileBrowser('<?php echo $folder['id'];?>', 0, true, this);">
				<img class="folderimg" id="img-<?php echo $folder['id'];?>" src="img/folder.gif" />
				<?php echo $folder['name'];?>/
			</span>
		</span>
		<br class="clear" />
	</li>
	<?php endforeach;?>
</ul>
