jQuery(function($){

	pyro.files = { cache : {}, history : {} };
	pyro.files.current_level = 0;

	/***************************************************************************
	 * Activity sidebar message handler                     			       *
	 ***************************************************************************/
 	$(window).on('show-message', function(e, results){

 		if (results.message > '') {
 			switch (results.status) {
 				case true:
 					status_class = 'success'
 				break;
 				case false:
 					status_class = 'failure';
 				break;
 				default:
 					status_class = 'info';
 				break;
 			}

	 		$('.console-title').after('<li class="'+status_class+'">'+results.message+'</li>');
 		}
 	});

 	/***************************************************************************
	 * Left click to open folders                                              *
	 ***************************************************************************/
 	$('.folders-right').on('dblclick', '.folder', function(e){
 		// store element so it can be accessed the same as if it was right clicked
 		pyro.files.$last_r_click = $(e.target);

 		$('.context-menu-source [data-menu="open"]').trigger('click');
 	});

 	$('.folders-sidebar li:has(ul)').addClass('open');

 	// use a single left click in the left sidebar
 	$('.folders-sidebar').on('click', '.folder', function(e){
 		e.preventDefault();
 		e.stopPropagation();
 		var $clicked = $(e.target);

 		// did they click on the link or the icon
 		if ($clicked.is('a')) {
	 		// store element so it can be accessed the same as if it was right clicked
	 		pyro.files.$last_r_click = $clicked.parent('li');
	 		$('.context-menu-source [data-menu="open"]').trigger('click');
 		} else {
 			$clicked.children('ul').slideToggle();
 			$clicked.toggleClass('open close');
 		}
 	});

	/***************************************************************************
	 * Context menu management                                                 *
	 ***************************************************************************/

	// open a right click menu on items in the main area
	$('.item').on('contextmenu', '.folders-right, .folders-right li', function(e){
		e.preventDefault();
		e.stopPropagation();

		// make the right clicked element easily accessible
		pyro.files.$last_r_click = $(this);

		// reset in case they've right clicked before
		$('.context-menu-source li').show();

		// what did the user click on? folder, pane, or file
		$('.context-menu-source li').filter(function(index){
			// make an exception cause the image thumbnail itself may be the target
			if ($(e.target).hasClass('file') || $(e.target).is('img')){
				var pattern = new RegExp('file');
			} else if ($(e.target).hasClass('folder')){
				var pattern = new RegExp('folder');
			} else if ($(e.target).hasClass('pane') && pyro.files.current_level === 0){
				var pattern = new RegExp('root-pane');
			} else {
				var pattern = new RegExp('pane');
			}

			// now hide the menu items not allowed for that type
			if ( ! pattern.test($(this).attr('data-applies-to'))){
				$(this).hide();
			}
			
		});

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
					pyro.files.$last_r_click.attr('data-id')
				)
			break;

			case 'upload':
				$(window).trigger('open-upload');
			break;

			case 'new-folder':
				pyro.files.new_folder(pyro.files.current_level);
			break;

			case 'rename':
				pyro.files.rename();
			break;

			case 'delete':
				if ( ! confirm(pyro.lang.dialog_message)) return;
				pyro.files.delete_item(pyro.files.current_level);
			break;
		}
	});

	/***************************************************************************
	 * Select folders including with the control key. #TODO: shift key         *
	 ***************************************************************************/

	$('.folders-right').on('click', '[data-id]', function(e){
		e.stopPropagation();
		var selected = $('.folders-right').find('.selected').length > 0;
		if ( ! e.ctrlKey && ! e.shiftKey) {
			if(selected) {
				$('[data-id]').removeClass('selected');
			}
		}
		$(this).toggleClass('selected');
	});

	// if they left click in the main area reset selected items or hide the context menu
	$('html').click(function(e){
		$('.folders-right li').removeClass('selected');
		$('.context-menu-source').fadeOut('fast');
	});

	/***************************************************************************
	 * File and folder sorting                                                 *
	 ***************************************************************************/

	$('.folders-right').sortable({
		cursor: 'move',
		delay: 100,
		update: function(e) {
			var order = { 'folder' : {}, 'file' : {} };
			$(this).find('li').each(function(index, data){
				var type = $(data).hasClass('folder') ? 'folder' : 'file';
				order[type][index] = $(this).attr('data-id');
			});

			$.post(SITE_URL + 'admin/files/order', { order : order }, function(data){
				var results = $.parseJSON(data);
				if (results.status) {
					// synchronize the left sidebar
					var after_id = $(e.target).prev('li').attr('data-id');
					var moved_id = $(e.target).attr('data-id');
					if (after_id === undefined && $(moved_id).parent('.folders-sidebar')) {
						$('.folders-sidebar [data-id="0"]')
							.after($('.folders-sidebar [data-id="'+moved_id+'"]'));
					} else if (after_id === undefined && $(moved_id).parent('ul')) {
						$(moved_id).parent('ul')
							.prepend($('.folders-sidebar [data-id="'+moved_id+'"]'));
					} else {
						$('.folders-sidebar [data-id="'+after_id+'"]')
							.after($('.folders-sidebar [data-id="'+moved_id+'"]'));
					}

				}
				$(window).trigger('show-message', results);
			});
		}

	});

	/***************************************************************************
	 * Files uploader section                                                  *
	 ***************************************************************************/

	$(window).on('open-upload', function(){
		$.colorbox({
			scrolling	: false,
			inline		: true,
			href		: '#files-uploader',
			width		: '800',
			height		: '80%',
			opacity		: 0.3,
			onComplete	: function(){
				$('#files-uploader-queue').empty();
				$.colorbox.resize();
			},
			onCleanup : function(){
				// we don't reload unless they are inside the folder that they uploaded to
				if (pyro.files.upload_to === pyro.files.current_level) {
					pyro.files.folder_contents(pyro.files.upload_to);
				}
			}
		});
	});

	$('#files-uploader form').fileUploadUI({
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
					'<button class="button start ui-helper-hidden-accessible"><span>' + pyro.lang.start + '</span></button>'+
					'<button class="button cancel"><span>' + pyro.lang.cancel + '</span></button>' +
					'</div>' +
					'</li>');
		},
		buildDownloadRow: function(results){
			if (results.message)
			{
				$(window).trigger('show-message', results);
			}
		},
		beforeSend: function(event, files, index, xhr, handler, callBack){
			handler.uploadRow.find('button.start').click(function(){

				// we use the current level if they clicked in the open area
				if (pyro.files.$last_r_click.attr('data-id') > '') {
					pyro.files.upload_to = pyro.files.$last_r_click.attr('data-id');
				} else {
					pyro.files.upload_to = pyro.files.current_level;
				}

				handler.formData = {
					name: handler.uploadRow.find('input.file-name').val(),
					folder_id: pyro.files.upload_to
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

		// add an editable one to the right pane
		$('.new-folder').clone()
			.appendTo('.folders-right')
			.removeClass('new-folder')
			.addClass('folder folder-' + new_class);

		$('.no_data').fadeOut('fast');

		var data
		var post = { parent : parent, name : name };

		$.post(SITE_URL + 'admin/files/new_folder', post, function(data){
			var results = $.parseJSON(data);

			if (results.status) {

				// add the id in so we know who he is
				$('.folder-' + new_class).attr('data-id', results.data.id);

				// update the text and remove the temporary class
				$('.folder-' + new_class + ' .name-text')
					.html(results.data.name)
					.removeClass('folder-' + new_class);

				$parent_li = $('.folders-sidebar [data-id="'+parent+'"]');
				if (parent === 0) {
					// this is a top level folder, we'll insert it after Places. Not really its parent
					$parent_li.after('<li class="folder" data-id="'+results.data.id+'" data-name="'+results.data.name+'"><a href="#">'+results.data.name+'</a></li>');
				} else if ($parent_li.has('ul').length > 0) {
					// it already has children so we'll just append this li to its ul
					$parent_li.children('ul')
						.append('<li class="folder" data-id="'+results.data.id+'" data-name="'+results.data.name+'"><a href="#">'+results.data.name+'</a></li>');
				} else {
					// it had no children, we'll have to add the <ul> and the icon class also
					$parent_li.append('<ul><li class="folder" data-id="'+results.data.id+'" data-name="'+results.data.name+'"><a href="#">'+results.data.name+'</a></li></ul>');
					$parent_li.addClass('close');			
				}

				// now they will want to rename it
		 		pyro.files.$last_r_click = $('[data-id="'+results.data.id+'"]');
		 		$('.context-menu-source [data-menu="rename"]').trigger('click');

		 		$(window).trigger('show-message', results);
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
		var results = {};
		results.message = pyro.lang.fetching;
		$(window).trigger('show-message', results);

		$.post(SITE_URL + 'admin/files/folder_contents', post, function(data){
			var results = $.parseJSON(data);

			if (results.status) {

				// iterate over all items so we can build a cache
				$('.folders-right li').each(function(index){
					var folder = {}
					var file = {}

					if ($(this).hasClass('folder')) {
						folder.id = $(this).attr('data-id');
						folder.name = $(this).attr('data-name');
						folders[index] = folder;
					} else {
						file.id = $(this).attr('data-id');
						file.name = $(this).attr('data-name');
						files[index] = file;
					}
				});

				// ok now we have a copy of what *was* there
				pyro.files.history[level] = { 'folder' : folders, 'file' : files }

				// so let's wipe it clean...
				$('.folders-right li').fadeOut('fast').remove();

				// iterate over array('folder' => $folders, 'file' => $files)
				$.each(results.data, function(type, data){

					$.each(data, function(index, item){

						// if it's an image then we set the thumbnail as the content
						if (item.type && item.type == 'i') {
							var li_content = '<img src="'+SITE_URL+'files/thumb/'+item.id+'/75/50/fill" alt="'+item.name+'"/>'+
												'<span class="name-text">'+item.name+'</span>';
						} else {
							var li_content = '<span class="name-text">'+item.name+'</span>'
						}

						$('.folders-right').append(
							'<li class="'+type+' '+(type == 'file' ? 'type-'+item.type : '')+'" data-id="'+item.id+'" data-name="'+item.name+'">'+
								li_content+
							'</li>'
						)
					})

				});

				// Toto, we're not in Kansas anymore
				pyro.files.current_level = folder_id;

				// show the children in the left sidebar
				$('.folders-sidebar [data-id="'+folder_id+'"] > ul:hidden').parent().trigger('click');

				// and we succeeded
				results.message = pyro.lang.fetch_completed;
				$(window).trigger('show-message', results);
			}
		});
	 }

	 pyro.files.rename = function()
	 {
	 	// what type of item are we renaming?
	 	var type = pyro.files.$last_r_click.hasClass('folder') ? 'folder' : 'file';

	 	// if they have one selected already then undo it
	 	$('[name="rename"]').parent().html($('[name="rename"]').val());

	 	var $item = pyro.files.$last_r_click.find('.name-text');
	 	$item.html('<input name="rename" value="'+$item.html()+'"/>')

	 	var $input  = $item.find('input');
	 	$input.select();

	 	$input.keyup(function(e){
	 		if(e.which == 13) {
	 			$input.trigger('blur');
	 		}
	 	})

	 	$input.blur(function(){
	 		var post = {}
	 		post[type+'_id'] = $item.parent('li').attr('data-id');
 			post['name'] = $input.val();

	 		$.post(SITE_URL + 'admin/files/rename_'+type, post, function(data){
	 			var results = $.parseJSON(data);
	 			$(window).trigger('show-message', results);

	 			// remove the input and place the text back in the span
	 			$('[name="rename"]').parent().html(results.data.name);
	 			$('.folders-sidebar [data-id="'+post.folder_id+'"] a').html(results.data.name);
	 			$('.folder[data-id="'+post[type+'_id']+'"]').attr('data-name', results.data.name);
	 		})
	 	})
	 }

	 pyro.files.delete_item = function(current_level)
	 {
	 	var type = pyro.files.$last_r_click.hasClass('folder') ? 'folder' : 'file';
	 	var post = {};
	 		post[type+'_id'] = pyro.files.$last_r_click.attr('data-id');

 		$.post(SITE_URL + 'admin/files/delete_'+type, post, function(data){
 			var results = $.parseJSON(data);
 			$(window).trigger('show-message', results);
 			if (results.status) {
 				$('[data-id="'+post[type+'_id']+'"]').remove();

 				if (type == 'folder') {
					$('[data-id="'+current_level+'"] ul:empty').remove();
					$('[data-id="'+current_level+'"]').removeClass('open close');
 				}
 			}
 		})
	 }
});