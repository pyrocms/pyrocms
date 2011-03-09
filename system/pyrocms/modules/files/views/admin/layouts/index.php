<div id="uploader">
	<div class="uploader-browser">
		<?php echo form_open_multipart('admin/files/upload'); ?>
			<input type="hidden" value="" id="folder_id" />
			<input class="no-uniform" type="file" name="userfile" multiple>
				
			<div><?php echo lang('files.upload.title'); ?></div>
	
		<?php echo form_close(); ?>
		<ul id="file-queue"></ul>
	</div>
	<div class="buttons float-right padding-top">
		<button class="button start-upload"><span><?php echo lang('files.labels.upload'); ?></span></button>
		<button class="button cancel-upload"><span><?php echo lang('buttons.cancel');?></span></button>
	</div>
</div>

<div id="files_browser">
	<div id="files_left_pane">
		<h3><?php echo lang('files.folders.title'); ?></h3>
		<?php echo $template['partials']['nav']; ?>
	</div>
	<div id="files_right_pane">
	</div>
</div>

<script type="text/javascript">
(function($){
	$(function(){
		$("#files_left_pane li a").click(function(){
			var anchor = $(this);
			var current_text = anchor.text();
			parent.location.hash = anchor.attr("title");
			anchor.text("<?php echo lang('files.loading'); ?>");
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

		//file upload stuff
		$('.dd-upload, button.cancel-upload').livequery(function(e){
			$(this).click(function(e){

			e.preventDefault();
			
			//get the folder id
			folder_id = $('select#parent_id').val();
			$('input#folder_id').val(folder_id);
			
			//upload box object
			box = $('#uploader');
			
			//empty the file queue contents
			$('#file-queue').html('');
			
			b_width = $('#files_browser').width();
			b_height = $('#files_browser').height();
			
			
			if ($(this).is('button.cancel-upload') || box.is(":visible"))
			{
				$("#files_right_pane").load('admin/files/folders/contents/'+folder_id);
				box.fadeOut('fast');
			}
			else
			{
				box.css('min-height', b_height);
				box.width(b_width);
			
				box.fadeIn('fast');
			}
			});
		});
		
		$('#uploader form').fileUploadUI({
			fieldName		: 'userfile',
			uploadTable		: $('#file-queue'),
			downloadTable	: $('#file-queue'),
			previewSelector	: '.file_upload_preview div',
			buildUploadRow	: function(files, index){
				return $('<li><div class="file_upload_preview"><div></div></div>' +
						'<div class="filename">' + files[index].name + '</div>' +
						'<input class="file-name" type="hidden" name="name" value="'+files[index].name+'" />' +
						'<button class="start">Start</button>'+
						'<div class="file_upload_progress"><div></div></div>' +
						'<div class="file_upload_cancel"><button class="button small cancel"><span><?php echo lang('files.labels.delete'); ?></span></button></div>' +
						'</li>');
			},
			buildDownloadRow: function(file){
				return $('<li><div>' + file.name + '</div></li>');
			},
			beforeSend: function(event, files, index, xhr, handler, callBack){
				handler.uploadRow.find('button.start').click(function(){
					handler.formData = {
						name: handler.uploadRow.find('input.file-name').val(),
						folder_id: $('input#folder_id').val()
					};
					callBack();
				});
				
			}
		});
		
		$('button.start-upload').click(function(){
			$('button.start').click();
		});
		
		$('button.cancel-upload').click(function(){
			$('button.cancel').click();
		});

	});
})(jQuery);
</script>
