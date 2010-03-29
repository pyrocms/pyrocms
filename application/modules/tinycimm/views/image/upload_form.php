<iframe id="hidden_iframe" name="hidden_iframe" src="javascript:false" style="display:none"></iframe>
<fieldset>
	<legend>
		<?php echo lang('tinycimm_image_upload_image'); ?>
	</legend>
	<div id="fileuploader">

		<form method="post" target="hidden_iframe" enctype="multipart/form-data" action="<?php echo $this->config->item('tinycimm_image_controller');?>upload" id="uploadform" name="uploadform">
			<table border="0" cellpadding="4" cellspacing="2">
			<tbody>
				<tr>
					<td>
						<?php echo lang('tinycimm_image_allowed_types'); ?>
					</td>
					<td colspan="3" id="allowedtypes"><?php echo str_replace('|', ', ', $upload_config['allowed_types']);?></td>
				</tr>
				<tr>
					<td valign="top">
						<?php echo lang('tinycimm_image_select_files'); ?>
					</td>
					<td colspan="3">
						<input type="file" id="fileupload" name="fileupload" class="fileupload" />
					</td>
				</tr>
				<tr>
					<td>
						<?php echo lang('tinycimm_image_remote_folder'); ?>
					</td>
					<td colspan="3">
						<div id="folder-select-list">
							<?php echo $this->tinycimm->get_folders('select');?>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo lang('tinycimm_image_constrain_dimensions'); ?>
					</td>
					<td class="constrain-dimensions">
						<input type="radio" name="adjust_size" id="upload-adjust-size-y" value="1" checked="checked" onclick="document.getElementById('con_dimensions').style.display='block';" /> 
						<label for="upload-adjust-size-y">
							<?php echo lang('tinycimm_image_yes'); ?>
						</label> 
						<input type="radio" name="adjust_size" id="upload-adjust-size-n" value="0" onclick="document.getElementById('con_dimensions').style.display='none';" /> 
						<label for="upload-adjust-size-n">
							<?php echo lang('tinycimm_image_no'); ?>
						</label>
					</td>
					<td>&nbsp;</td>
					<td class="constrain-demensions-values">
						<div id="con_dimensions">
							<input type="text" name="max_x" value="640" /> x
							<input type="text" name="max_y" value="480" /> px
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo lang('tinycimm_image_quality'); ?>
					</td>
					<td colspan="3">
						<input type="text" name="image_quality" class="image-quality" value="90" />%
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
