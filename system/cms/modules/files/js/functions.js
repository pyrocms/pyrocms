jQuery(function($){

	pyro.files = { results : { status : null } };

	/***************************************************************************
	 * A worker to display messages as they become available                   *
	 ***************************************************************************/
 	window.setInterval(function ()
 	{
 		if (pyro.files.results && pyro.files.results.status !== null) {

 			var status_class = pyro.files.results.status === true ? 'success' : 'failure';

	 		$('.console-title').after('<li class="'+status_class+'">'+pyro.files.results.message+'</li>');
	 		pyro.files.results.status = null;
 		}
 	}, 50);
 
	/***************************************************************************
	 * Context menu management                                                 *
	 ***************************************************************************/

	// open a right click menu on items in the main area
	$('.item').delegate('.one_half', 'contextmenu', function(e){
		e.preventDefault();

		pyro.files.last_right_clicked = e.target;

		// we hide/show the items that don't apply to a folder
		if ($(e.target).hasClass('folder')){
			$('[data-menu]').show();
			$('[data-menu="new-folder"], [data-menu="edit"]').hide();
		} else {
			// show everything if they clicked in the open area but aren't in the root
			$('[data-menu]').show();

			// we only want to show New Folder and Details menus in the root
			if ($('[name="current-level"]').val() == '0'){
				$('[data-menu]').hide();
				$('[data-menu="new-folder"], [data-menu="details"]').show();
			}
		}

		$('.context-menu-source').fadeIn('fast');
		// jquery UI position the context menu by the mouse
		$('.context-menu-source').position({
			my:			'left top',
			at:			'left bottom',
			of:			e,
			collision:	'fit'
		});
	});

	// call the correct function for the menu item they have clicked
	$('.context-menu-source').on('click', '[data-menu]', function(e){

		var menu = $(this).attr('data-menu');
		var current_level = $('[name="current-level"]').val();

		switch (menu){
			case 'upload':
				console.log(menu);
			break;

			case 'new-folder':
				pyro.files.new_folder(current_level);
			break;

			case 'rename':
				pyro.files.rename_folder(current_level);
			break;

			case 'delete':
				pyro.files.delete_folder(current_level);
			break;
		}
	});

	// select folders; including use of control key. #TODO: shift key
	$('.folders-right [data-folder-id]').click(function(e){
		e.stopPropagation();
		var selected = $('.folders-right').find('.selected').length > 0;
		if ( ! e.ctrlKey && ! e.shiftKey) {
			if(selected) {
				$('[data-folder-id]').removeClass('selected');
			}
		}
		$(this).toggleClass('selected');
	});

	// if they left click in the main area reset selected items or hide the context menu
	$('html').click(function(e){
		$('.folder').removeClass('selected');
		$('.context-menu-source').fadeOut('fast');
	});

	// sort folders
	$('.folders-sidebar, .folders-right').sortable({
		cursor: 'move',
		delay: 100,
		update: function() {
			order = new Array();
			$(this).find('li').each(function(){
				order.push( $(this).attr('data-folder-id') );
			});
			order = order.join(',');

			$.post(SITE_URL + 'admin/files/order_folders', { order: order }, function(data){
				pyro.files.results = $.parseJSON(data);
			});
		}

	});

	/***************************************************************************
	 * Files uploader section                                                 *
	 ***************************************************************************/

	// Store data for filesUpload plugin
	$('#files-uploader form').data('fileUpload', {
		lang : {
			start : 'Start',
			cancel : pyro.lang.delete
		}
	});

	$('.open-files-uploader').livequery(function(){
		$(this).colorbox({
			scrolling	: false,
			inline		: true,
			href		: '#files-uploader',
			width		: '800',
			height		: '80%',
			onComplete	: function(){
				$('#files-uploader-queue').empty();
				$.colorbox.resize();
			},
			onCleanup : function(){
				//$(window).hashchange();
			}
		});
	});

	var upload_form = $('#files-uploader form'),
		upload_vars	= upload_form.data('fileUpload');

	upload_form.fileUploadUI({
		fieldName       : 'userfile',
		uploadTable     : $('#files-uploader-queue'),
		downloadTable   : $('#files-uploader-queue'),
		previewSelector : '.file_upload_preview div',
        cancelSelector  : '.file_upload_cancel button.cancel',
		buildUploadRow	: function(files, index, handler){
			return $('<li><div class="file_upload_preview ui-corner-all"><div class="ui-corner-all"></div></div>' +
					'<div class="filename"><label for="file-name">' + files[index].name + '</label>' +
					'<input class="file-name" type="hidden" name="name" value="'+files[index].name+'" />' +
					'</div>' +
					'<div class="file_upload_progress"><div></div></div>' +
					'<div class="file_upload_cancel buttons buttons-small">' +
					'<button class="button start ui-helper-hidden-accessible"><span>' + upload_vars.lang.start + '</span></button>'+
					'<button class="button cancel"><span>' + upload_vars.lang.cancel + '</span></button>' +
					'</div>' +
					'</li>');
		},
		buildDownloadRow: function(response){
			if (response.message)
			{
				pyro.files.results = response;
			}
		},
		beforeSend: function(event, files, index, xhr, handler, callBack){
			handler.uploadRow.find('button.start').click(function(){
				handler.formData = {
					name: handler.uploadRow.find('input.file-name').val(),
					folder_id: $(pyro.files.last_right_clicked).attr('data-folder-id')
				};
				callBack();
			});
		},
		onComplete: function (event, files, index, xhr, handler){
			handler.onCompleteAll(files);
		},
		onCompleteAll: function (files){
			if ( ! files.uploadCounter)
			{
				files.uploadCounter = 1;  
			}
			else
			{
				files.uploadCounter = files.uploadCounter + 1;
			}

			if (files.uploadCounter === files.length)
			{
				$('#files-uploader a.cancel-upload').click();
			}
		}
	});

	$('#files-uploader a.start-upload').click(function(e){
		e.preventDefault();
		$('#files-uploader-queue button.start').click();
	});

	$('#files-uploader a.cancel-upload').click(function(e){
		e.preventDefault();
		$('#files-uploader-queue button.cancel').click();
		$.colorbox.close();
	});



	/***************************************************************************
	 * All functions that are part of the pyro.files namespace                 *
	 ***************************************************************************/
	 pyro.files.new_folder = function(current_level, name)
	 {
	 	if (typeof(name) === 'undefined') name = 'Untitled Folder';
	 	var new_class = Math.floor(Math.random() * 1000);

		$('.new-folder').clone()
			.appendTo('.folders-right')
			.removeClass('new-folder')
			.addClass('folder folder-' + new_class);

		$('.no_data').fadeOut('fast');

		var data
		var post = { parent : current_level, name : name };

		$.post(SITE_URL + 'admin/files/new_folder', post, function(data){
			pyro.files.results = $.parseJSON(data);

			if (pyro.files.results.status) {

				// add the id in so we know who he is
				$('.folder-' + new_class).attr('data-folder-id', pyro.files.results.data.id);

				// update the text and remove the temporary class
				$('.folder-' + new_class + ' .folder-text')
					.html(pyro.files.results.data.name)
					.removeClass('folder-' + new_class);
			}
		});
	 }

	 pyro.files.rename_folder = function(current_level)
	 {
	 	// if they have one selected already then undo it
	 	$('[name="rename"]').parent().html($('[name="rename"]').val());

	 	var $folder = $(pyro.files.last_right_clicked).find('.folder-text');

	 	$folder.html('<input name="rename" value="'+$folder.html()+'"/>').find('input').select();

	 	$folder.find('input').blur(function(){
	 		var post = { 'folder_id' : $folder.parent('li').attr('data-folder-id'), 
	 					 'name' 	 : $folder.find('input').val() }

	 		$.post(SITE_URL + 'admin/files/rename_folder', post, function(data){
	 			pyro.files.results = $.parseJSON(data);

	 			// remove the input and place it back in the span
	 			$('[name="rename"]').parent().html($('[name="rename"]').val());
	 		})
	 	})
	 }

	 pyro.files.delete_folder = function(current_level)
	 {
	 	var post = { 'folder_id' : $(pyro.files.last_right_clicked).attr('data-folder-id') };

 		$.post(SITE_URL + 'admin/files/delete_folder', post, function(data){
 			pyro.files.results = $.parseJSON(data);
 			if (pyro.files.results.status) {
 				$('[data-folder-id="'+post.folder_id+'"]').remove();
 			}
 		})
	 }

});