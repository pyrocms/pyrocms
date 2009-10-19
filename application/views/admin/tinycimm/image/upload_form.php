<iframe id="hidden_iframe" name="hidden_iframe" src="javascript:false" style="display:none"></iframe>
<fieldset>
	<legend>Quick Image Upload</legend>
	<div id="fileuploader">

		<form method="post" target="hidden_iframe" enctype="multipart/form-data" action="<?=$this->config->item('tinycimm_controller');?>image/upload" id="uploadform" name="uploadform">
			<table border="0" cellpadding="4" cellspacing="2">
			<tbody>
				<tr>
					<td>Allowed Types</td>
					<td colspan="3" id="allowedtypes"><?=str_replace('|', ', ', $upload_config['allowed_types']);?></td>
				</tr>
				<tr>
					<td valign="top">Select File/s</td>
					<td colspan="3">
						<input type="file" id="fileupload" name="fileupload" class="fileupload" />
					</td>
				</tr>
				<tr>
					<td>Remote Folder</td>
					<td colspan="3">
						<div id="folder_select_list" style="display: inline;">
							<?=TinyCIMM_image::get_folders_select();?>
						</div>
					</td>
				</tr>
				<tr>
					<td>Constrain Dimensions</td>
					<td>
						<input style="width:14px;float:left;border:0" type="radio" name="adjust_size" id="adjust_size_1" value="1" checked="checked" onclick="document.getElementById('con_dimensions').style.display='block';" /> 
						<label style="float:left;line-height:18px" for="adjust_size_1">Yes</label> 
						<input style="width:14px;float:left;border:0" type="radio" name="adjust_size" id="adjust_size_0" value="0" onclick="document.getElementById('con_dimensions').style.display='none';" /> 
						<label style="float:left;line-height:18px" for="adjust_size_0">No</label>
					</td>
					<td>&nbsp;</td>
					<td>
						<div id="con_dimensions">
							<input style="text-align:center;width:38px" type="text" name="max_x" value="640" /> x
							<input style="text-align:center;width:38px" type="text" name="max_y" value="480" /> px
						</div>
					</td>
				</tr>
				<tr>
					<td>Quality</td>
					<td colspan="3">
						<input type="text" size="3" style="text-align:center;width:24px" id="image-quality" value="90" />%
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<input type="submit" class="button" id="submit-upload" name="submit_upload" value="Upload" />
					</td>
				</tr>
			</tbody>
			</table>
		</form>
	</div>
</fieldset>
<script type="text/javascript">
document.getElementById('fileupload').multiFileUpload();
</script>
