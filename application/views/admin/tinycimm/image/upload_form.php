<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Upload Image Form</title>
	<style type="text/css" media="screen">
		html, body {background:#FFF;height:500px;}
		body {margin:0;}
		.fileuploadinput {font-weight:bold;}
		.fileuploadinput a {font-weight:normal;}
		.fileupload {display:inline;width:220px;}
	</style>
	<script type="text/javascript">
	//<![CDATA[
		var tinymce = parent.tinymce;
		// load theme popup css
		tinymce.EditorManager.activeEditor.windowManager.createInstance('tinymce.dom.DOMUtils', document).loadCSS(tinymce.EditorManager.activeEditor.settings.popup_css);

		/**
		* remove overlay layer and spinner image
		**/
		function removedim() {
			try {
				var 
				dim = parent.document.getElementById("dimwindow"), 
				img = parent.document.getElementById("dimwindowimg");
				dim.parentNode.removeChild(dim);
				img.parentNode.removeChild(img);
			} catch(e) {}
		}

		/**
		* create overlay layer and spinner image and add to the dom
		**/
		function dimimage() {
			var 
			dim = parent.document.createElement("div"),
			img = parent.document.createElement("div"),
			bodyRef = parent.document.getElementById("upload_panel");
			dim.setAttribute("id", "dimwindow");
			img.setAttribute("id", "dimwindowimg");
			img.innerHTML = '<div><img src="img/progress.gif" /></div>';
			bodyRef.appendChild(dim);
			bodyRef.appendChild(img);
		}


		/**
		* - bind change event to file input, append new file input to parent form
		* - will create unqiue names for inputs and will not group them - this is to 
		* support how multi files are managed by CI (ideally i'd like to group the inputs)
		**/
		Object.prototype.multiFileUpload = function(){
			this.onchange = function(){
				var self = this, container = document.createElement('div'), removeanchor = document.createElement('a'), newinput = document.createElement('input');
				// define new file input
				newinput.setAttribute('type', 'file');
				newinput.setAttribute('name', this.name+Math.floor(Math.random()*2));
				newinput.setAttribute('class', 'fileupload');
				// bind multi-file-uplood change event to new file input element
				newinput.multiFileUpload();
				// insert new file input element
				this.parentNode.insertBefore(newinput, this);
				// create and insert the 'remove' anchor and container	
				container.className = 'fileuploadinput';
				removeanchor.href = '#';
				removeanchor.onclick = function(e){
					e.preventDefault();
					container.parentNode.removeChild(container);
					self.parentNode.removeChild(self);
				};
				removeanchor.innerHTML = '[remove]';
				// strip path segments if any
				container.innerHTML = this.value.replace(/\\/g, "/").replace(/.*\//, "")+" ";
				container.appendChild(removeanchor);
				this.parentNode.appendChild(container);
				// 'hide' the current file input (safari doesn't like display:none)
				this.style.position = 'absolute';
				this.style.left = '-1000px';
			};
			return this;
		};
		
		// prepare the upload form
		window.onload = function() {
			document.forms[0].action = parent.tinyMCEPopup.editor.documentBaseURI.toAbsolute(parent.tinyMCE.settings.tinycimm_controller+'image/upload');
			document.getElementById('fileupload').multiFileUpload();
		}
	//]]>
	</script>
	<base target="_self" />
</head>
<body style="background:#FFF;margin:0">
	<iframe id="hidden_iframe" name="hidden_iframe" src="javascript:false" style="display:none"></iframe>
	<form method="post" target="hidden_iframe" enctype="multipart/form-data" action="#" id="uploadform" name="uploadform">
		<table border="0" cellpadding="4" cellspacing="2">
		<tbody>
			<tr>
				<td>Allowed Types</td>
				<td colspan="3"><?=str_replace('|', ', ', $upload_config['allowed_types']);?></td>
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
					<input type="submit" class="button" name="submit_upload" value="Upload" onclick="dimimage();document.forms['uploadform'].submit();" />
				</td>
			</tr>
		</tbody>
		</table>
	</form>
</body>
</html>
