<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
        <td width="178" valign="top">
                <?= $this->load->view($this->view_path.'subtpl/leftpane');?>
        </td>
        <td width="5">&nbsp;</td>
        <td valign="top">
                <div class="heading">
                        <?= $this->load->view($this->view_path.'subtpl/search');?>
                </div>
                <div id="filelist">
			<?if (sizeof($assets) == 0) {?>
				(folder is empty)
			<?} else {?>
				<?foreach($assets as $asset):?>
					<span class="thumb_wrapper" title="insert <?=$asset['description'];?>">
						<span class="thumb" onclick="TinyCIMMImage.insertImage(this, '<?=$asset['filename'];?>', '<?=$asset['description'];?>');" style="background:url(/assetmanager/image/get/<?=$asset['id'];?>/92/92) no-repeat center center;">
							<span class="loader"></span>
						</span>
						<span class="controls-bg"></span>
						<span class="controls">
							<a href="#" title="delete image" class="delete" onclick="TinyCIMMImage.deleteImage(<?=$asset['id'];?>);return false">&nbsp;</a>
						</span>
					</span>
				<?endforeach;?>
			<?}?>
			<br class="clear" />
		</div>
		<?=$this->pagination->create_links();?>
	</td>
	</tr>
</table>
