<div id="addfolder" class="clearfix" style="display:none;">
	<div class="heading">&raquo; Add Folder</div>
	<input type="text" id="add_folder_caption" class="input" style="width:136px;float:left;margin-right:5px">
	<img src="img/save.gif" onClick="TinyCIMMImage.addFolder('image');" style="cursor:pointer;float:left;opacity:0.65" onMouseOver="this.style.opacity='1';" onMouseOut="this.style.opacity='0.65';" alt="save folder" title="save folder" />
	&nbsp;<img src="img/cancel.png" onclick="tinyMCEPopup.dom.get('addfolder').style.display='none';tinyMCEPopup.dom.get('add_folder_caption').value='';" style="cursor:pointer;opacity:0.65" onMouseOver="this.style.opacity='1';" onMouseOut="this.style.opacity='0.65';" title="cancel" />
</div>
<div class="heading">
	<span style="float:right;padding-right:2px;font-weight:normal">
		[<a href="#" onclick="tinyMCEPopup.dom.get('addfolder').style.display='block';tinyMCEPopup.dom.get('add_folder_caption').focus()">add</a>]
	</span>&raquo; Folders
</div>
<div id="folderlist">
	<?= $this->load->view($this->view_path.'folder_list');?>
</div>
<br/>
<div class="heading">&raquo; Folder Info</div>
<table border="0" cellpadding="2" cellspacing="1">
	<tr><td>Images:</td><td><?=$selected_folder_info['total_assets'];?></td></tr>
	<tr><td>Size:</td><td><?=$selected_folder_info['total_file_size'];?></td></tr>
	<tr><td>View:</td><td>
	<select style="border:1px solid #AAA" onchange="TinyCIMMImage.changeView(this.options[this.selectedIndex].value)">
		<optgroup label="Views">
			<option value="listing"<?=$this->session->userdata('cimm_view')=='listing'?' selected':'';?>>File Listing</option>
			<option value="thumbnails"<?=$this->session->userdata('cimm_view')=='thumbnails'?' selected':'';?>>Thumbnails</option>
		</optgroup>
	</select></td></tr>
</table>	
