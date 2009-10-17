<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Upload Image Form</title>
	<style type="text/css" media="screen">
		html, body {background:#FFF;}
		body {margin:0;}
	</style>
	<script type="text/javascript">
		var tinymce = parent.tinymce;
		// load popup css
		tinymce.EditorManager.activeEditor.windowManager.createInstance('tinymce.dom.DOMUtils', document).loadCSS(tinymce.EditorManager.activeEditor.settings.popup_css);

		/**
		* remove overlay layer and spinner image
		**/
		function removedim() {
			try {
				var dim = parent.document.getElementById("dimwindow");
				dim.parentNode.removeChild(dim);
				var img = parent.document.getElementById("dimwindowimg");
				img.parentNode.removeChild(img);
			} catch(e) {}
		}

		/**
		* create overlay layer and spinner image and add to the dom
		**/
		function dimimage() {
			var dim = parent.document.createElement("div");
			dim.setAttribute("id", "dimwindow");
			var img = parent.document.createElement("div");
			img.setAttribute("id", "dimwindowimg");
			img.innerHTML = '<div><img src="img/progress.gif" /></div>';
			var bodyRef = parent.document.getElementById("upload_panel");
			bodyRef.appendChild(dim);
			bodyRef.appendChild(img);
		}

		/**
		*
		**/
		function updateimg(folder) {
			document.forms[0].reset();
			document.forms[0].description.value = '';
			parent.TinyCIMMImage.assetUploaded(folder);
		}

		window.onload = function() {
			document.forms[0].action = parent.tinyMCEPopup.editor.documentBaseURI.toAbsolute(parent.tinyMCE.settings.tinycimm_controller+'image/upload');
			document.getElementById('fileupload').onchange = function(e) {
				if (this.value) {
					document.getElementById('description').value = 
					this.value
					.replace(/\\/g, '/')
					.replace(/.*\/|\.\w*$/g, '')
					.replace(/[_-]/g, ' ')
					.replace(/\s{2,}/g, ' ');
				}
			}
		}
	</script>
	<base target="_self" />
</head>
<body style="background:#FFF;margin:0">
	<iframe id="hidden_iframe" name="hidden_iframe" src="javascript:false" style="display:none"></iframe>
	<form method="post" target="hidden_iframe" enctype="multipart/form-data" action="#" id="uploadform" name="uploadform">
		<table border="0" cellpadding="4" cellspacing="2">
			<tr>
				<td>Allowed Types</td>
				<td colspan="3"><?=str_replace('|', ', ', $upload_config['allowed_types']);?></td>
			<tr>
				<td>Select File</td>
				<td colspan="3">
					<input type="file" id="fileupload" name="fileupload" size="25" style="display:inline;width:220px;" />
				</td>
			</tr>
			<tr>
				<td valign="top">Description</td>
				<td colspan="3">
					<textarea name="description" id="description"></textarea>
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
					<input type="submit" class="button" name="submit_upload" value="Upload" onclick="dimimage();document.forms['uploadform'].submit();">
				</td>
			</tr>
		</table>
	</form>
	<br /><br />
</body>
</html>
