jQuery(function($){

	pyro.files = { results : {status : null}, cache : {}, history : {} };
	pyro.files.current_level = 0;

	/***************************************************************************
	 * A worker to display messages as they become available                   *
	 ***************************************************************************/
 	window.setInterval(function ()
 	{
 		if (pyro.files.results.status !== null && pyro.files.results.message > '') {

 			var status_class = pyro.files.results.status === true ? 'success' : 'failure';

	 		$('.console-title').after('<li class="'+status_class+'">'+pyro.files.results.message+'</li>');
	 		pyro.files.results.status = null;
 		}
 	}, 50);

 	/***************************************************************************
	 * Left click to open folders                                              *
	 ***************************************************************************/
 	$('.folders-right').on('dblclick', '.folder', function(e){
 		// fake a right click
 		pyro.files.$last_r_click = $(e.target);

 		$('.context-menu-source [data-menu="open"]').trigger('click');
 	});

 	$('.folders-sidebar li:has(ul)').addClass('open');

 	// use a single left click in the left sidebar
 	$('.folders-sidebar').on('click', '.folder', function(e){
 		e.preventDefault();

 		// did they click on the link or the icon
 		if ($(e.target).parent('li').length > 0) {
	 		// fake a right click
	 		pyro.files.$last_r_click = $(e.target).parent();

	 		$('.context-menu-source [data-menu="open"]').trigger('click');
 		} else {
 			$(e.target).children('ul').toggle();
 			$(e.target).toggleClass('open close');
 		}
 		e.stopPropagation();
 	});

	/***************************************************************************
	 * Context menu management                                                 *
	 ***************************************************************************/

	// open a right click menu on items in the main area
	$('.item').on('contextmenu', '.one_half', function(e){
		e.preventDefault();

		// make the right clicked element easily accessible
		pyro.files.$last_r_click = $(e.target);

		// we hide/show the items that don't apply to a folder
		if ($(e.target).hasClass('folder')){
			$('[data-menu]').show();
			$('[data-menu="new-folder"], [data-menu="edit"]').hide();
		} else {
			// show everything if they clicked in the open area but aren't in the root
			$('[data-menu]').show();

			// we only want to show New Folder and Details menus in the root
			if (pyro.files.current_level == 0){
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

		switch (menu){
			case 'open':
				pyro.files.folder_contents(
					pyro.files.$last_r_click.attr('data-folder-id')
				)
			break;

			case 'upload':
				console.log(menu);
			break;

			case 'new-folder':
				pyro.files.new_folder(pyro.files.current_level);
			break;

			case 'rename':
				pyro.files.rename_folder(pyro.files.current_level);
			break;

			case 'delete':
				if ( ! confirm(pyro.lang.dialog_message)) return;
				pyro.files.delete_folder(pyro.files.current_level);
			break;
		}
	});

	/***************************************************************************
	 * Select folders including with the control key. #TODO: shift key         *
	 ***************************************************************************/

	$('.folders-right').on('click', '[data-folder-id]', function(e){
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

	/***************************************************************************
	 * File and folder sorting                                                 *
	 ***************************************************************************/

	$('.folders-right').sortable({
		cursor: 'move',
		delay: 100,
		update: function() {
			order = [];
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

				// we use the current level if they clicked in the open area
				if (pyro.files.$last_r_click.attr('data-folder-id') > '') {
					var folder_id = pyro.files.$last_r_click.attr('data-folder-id');
				} else {
					var folder_id = pyro.files.current_level;
				}

				handler.formData = {
					name: handler.uploadRow.find('input.file-name').val(),
					folder_id: folder_id
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
	 pyro.files.new_folder = function(parent, name)
	 {
	 	if (typeof(name) === 'undefined') name = 'Untitled Folder';
	 	var new_class = Math.floor(Math.random() * 1000);

		$('.new-folder').clone()
			.appendTo('.folders-right')
			.removeClass('new-folder')
			.addClass('folder folder-' + new_class);

		$('.no_data').fadeOut('fast');

		var data
		var post = { parent : parent, name : name };

		$.post(SITE_URL + 'admin/files/new_folder', post, function(data){
			pyro.files.results = $.parseJSON(data);

			if (pyro.files.results.status) {

				// add the id in so we know who he is
				$('.folder-' + new_class).attr('data-folder-id', pyro.files.results.data.id);

				// update the text and remove the temporary class
				$('.folder-' + new_class + ' .folder-text')
					.html(pyro.files.results.data.name)
					.removeClass('folder-' + new_class);

				// now they will want to rename it
		 		pyro.files.$last_r_click = $('[data-folder-id="'+pyro.files.results.data.id+'"]');
		 		$('.context-menu-source [data-menu="rename"]').trigger('click');
			}
		});
	 }

	 pyro.files.folder_contents = function(folder_id)
	 {
	 	var post = { parent : folder_id };
	 	var level = pyro.files.current_level;
	 	var folders = [];
	 	var files = [];

		// let them know we're getting the stuff, it may take a second
		pyro.files.results.status = true;
		pyro.files.results.message = pyro.lang.fetching;

		$.post(SITE_URL + 'admin/files/folder_contents', post, function(data){
			pyro.files.results = $.parseJSON(data);

			if (pyro.files.results.status) {

				// iterate over all items so we can build a cache
				$('.folders-right li').each(function(index){
					var folder = {}
					var file = {}

					folder.id = $(this).attr('data-folder-id');

					if (folder.id > '') {
						folder.name = $(this).attr('data-folder-name');
						folders[index] = folder;
					} else {
						file.id = $(this).attr('data-file-id');
						file.name = $(this).attr('data-file-name');
						files[index] = file;
					}
				});

				// ok now we have a copy of what *was* there
				pyro.files.history[level] = { 'folder' : folders, 'file' : files }

				// so let's wipe it clean...
				$('.folders-right li').fadeOut('fast').remove();

				// iterate over array('folder' => $folders, 'file' => $files)
				$.each(pyro.files.results.data, function(type, data){

					$.each(data, function(index, item){

						// if it's an image then we set the thumbnail as the content
						if (item.type && item.type == 'i') {
							var li_content = '<img src="'+SITE_URL+'files/thumb/'+item.id+'/75/55/fill" alt="'+item.name+'"/>';
						} else {
							var li_content = '<span class="'+type+'-text">'+item.name+'</span>'
						}

						$('.folders-right').append(
							'<li class="'+type+' '+(type == 'file' ? 'type-'+item.type : '')+'" data-'+type+'-id="'+item.id+'" data-'+type+'-name="'+item.name+'">'+
								li_content+
							'</li>'
						)
					})

				});

				// Toto, we're not in Kansas anymore
				pyro.files.current_level = folder_id;

				// and we succeeded
				pyro.files.results.status = true;
				pyro.files.results.message = pyro.lang.fetch_completed;
			}
		});
	 }

	 pyro.files.rename_folder = function(current_level)
	 {
	 	// if they have one selected already then undo it
	 	$('[name="rename"]').parent().html($('[name="rename"]').val());

	 	var $folder = pyro.files.$last_r_click.find('.folder-text');
	 	$folder.html('<input name="rename" value="'+$folder.html()+'"/>')

	 	var $input  = $folder.find('input');
	 	$input.select();

	 	$input.keyup(function(e){
	 		if(e.which == 13) {
	 			$input.trigger('blur');
	 		}
	 	})

	 	$input.blur(function(){
	 		var post = { 'folder_id' : $folder.parent('li').attr('data-folder-id'), 
	 					 'name' 	 : $input.val() }

	 		$.post(SITE_URL + 'admin/files/rename_folder', post, function(data){
	 			pyro.files.results = $.parseJSON(data);

	 			// remove the input and place the text back in the span
	 			$('[name="rename"]').parent().html(pyro.files.results.data.name);
	 		})
	 	})
	 }

	 pyro.files.delete_folder = function(current_level)
	 {
	 	var post = { 'folder_id' : pyro.files.$last_r_click.attr('data-folder-id') };

 		$.post(SITE_URL + 'admin/files/delete_folder', post, function(data){
 			pyro.files.results = $.parseJSON(data);
 			if (pyro.files.results.status) {
 				$('[data-folder-id="'+post.folder_id+'"]').remove();
 			}
 		})
	 }

});