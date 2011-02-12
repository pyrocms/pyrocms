<style type="text/css">
h3 span {
	font-size: 14px;
	padding-left: 10px;
}
#files_browser {
	display: table;
	width: 100%;
	margin-bottom: 20px;
	background-color: #FFFFFF;
	color: #333333;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	-o-border-radius: 5px;
	border-radius: 5px;
	border: 1px solid #CCCCCC;
}
#files_left_pane {
	width: 15%;
	display: table-cell;
	border-right: 1px solid #CCCCCC;
	padding: 10px 0;

}
#files_left_pane ul,
#files_left_pane ul li,
#files_toolbar ul,
#files_toolbar ul li {
	list-style: none;
	padding: 0px;
	margin: 0px;
}
#files_browser h3 {
	margin: 0px;
	padding: 3px 0 5px 0px;
}
#files_left_pane h3 {
	padding-left: 10px;
}
#files_right_pane {
	width: 85%;
	display: table-cell;
	padding: 10px;
}
#files_left_pane li a {
	padding: 10px;
	background: transparent;
	display: block;
	text-decoration: none;
	color: #666666;
}
#files_left_pane li a:hover {
	background-color: #F4F4F4;
	color: #333333;
}
#files_left_pane li.current a {
	background-color: #3a4043;
	color: #FFFFFF;
}
#files_toolbar ul li {
	display: inline-block;
	padding-left: 5px;
}
#files_toolbar label {
	font-weight: bold;
}

#uploader form {
	min-height: 100px;
}
</style>

<div id="files_browser">

	<div id="files_left_pane">
		<h3><?php echo lang('files.folders.title'); ?></h3>
		<?php echo $template['partials']['nav']; ?>
	</div>
	<div id="files_right_pane">
	</div>
</div>
<div id="uploader">
	<?php echo form_open_multipart('admin/files/upload'); ?>
		<?php echo form_dropdown('folder_id', $folder_options, array(), 'id="folder_id"'); ?>
		<input class="no-uniform" type="file" name="userfile" multiple>
		<button>Upload</button>
		<div>Upload files</div>
		<button id="start_uploads">Start uploads</button>


	<?php echo form_close(); ?>
</div>
<table id="file-queue"></table>
<script type="text/javascript">
(function($) {
	$(function() {
		
		//file upload stuff
		$('#uploader form').fileUploadUI({
			fieldName: 'userfile',
			uploadTable: $('#file-queue'),
			downloadTable: $('#file-queue'),
			buildUploadRow: function (files, index) {
				return $('<tr><td class="file_upload_preview"><\/td>' +
						'<td>' + files[index].name + '<\/td>' +
						'<td><input class="file-name" type="text" name="name" value="'+files[index].name+'" />' + 
						'<td class="file_upload_progress"><div><\/div><\/td>' +
						'<td class="file_upload_start">' +
						'<button class="ui-state-default ui-corner-all" title="Start Upload">' +
						'<span class="ui-icon ui-icon-circle-arrow-e">Start Upload<\/span>' +
						'<\/button><\/td>' +
						'<td class="file_upload_cancel">' +
						'<button class="ui-state-default ui-corner-all" title="Cancel">' +
						'<span class="ui-icon ui-icon-cancel">Cancel<\/span>' +
						'<\/button><\/td><\/tr>');
			},
			buildDownloadRow: function (file) {
				return $('<tr><td colspan="4">' + file.name + '</td></tr>');
			},
			beforeSend: function (event, files, index, xhr, handler, callBack) {
				handler.uploadRow.find('.file_upload_start button').click(function() {
					handler.formData = {
						name: handler.uploadRow.find('input.file-name').val(),
						folder_id: $('select#folder_id').val()
					};
					callBack();
				});
			},
			onComplete: function(event, files, index, xhr, handler) {
				$('.file_upload_start button').trigger('click', function() {
					
				});
			}
		});

		
		$("#files_left_pane li a").click(function() {
			var anchor = $(this);
			var current_text = anchor.text();
			parent.location.hash = anchor.attr("title");
			anchor.text("Loading...");
			$("#files_right_pane").load(anchor.attr("href"));
			anchor.parent().parent().find('li').removeClass('current');
			anchor.parent().addClass('current');
			anchor.text(current_text);
			return false;
		});

		// All this jazz allows direct links to folders
		var current_folder = $('#files_left_pane ul li a[title='+parent.location.hash.substring(1)+']');
		if (current_folder.length)
		{
			current_folder.click();
		}
		else
		{
			$("#files_left_pane li:first-child a").click();
		}

	});
})(jQuery);
</script>
