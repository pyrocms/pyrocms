jQuery(function($){

	pyro.files.cache = {};
	pyro.files.history = {};
	pyro.files.timeout = {};
	pyro.files.current_level = 0;

	/***************************************************************************
	 * Activity sidebar message handler                     			       *
	 ***************************************************************************/
 	$(window).on('show-message', function(e, results){

 		if (results.message > '') {
 			switch (results.status) {
 				case true:
					li_status_class = 'success';
 					status_class = 'icon-ok-sign';
 				break;
 				case false:
					li_status_class = 'failure';
 					status_class = 'icon-remove-sign';
 				break;
 				default:
					li_status_class = 'info';
 					status_class = 'icon-info-sign';
 				break;
 			}

	 		$('.console-title').after('<li class="'+li_status_class+'">'+
	 										'<i class="'+status_class+'"></i>'+results.message+
	 								  '</li>');
 		}
 	});

 	/***************************************************************************
	 * Sidebar search functionality                           			       *
	 ***************************************************************************/
 	$('.console #file-search').keyup(function(e){
 		// sumit on Enter
 		if (e.which == 13) {
 			$('.console .search-results').empty();

 			$.post(SITE_URL+'admin/files/search', { search : $('.console #file-search').val() }, function(data){
 				var results = $.parseJSON(data);
 				if (results.status) {
 					$.each(results.data, function(type, item){
 						if (item.length > 0){
 							$.each(item, function(i, result){
 								$('.console .search-results').append(
 									'<li>'+
 										'<div class="'+type+'"></div>'+
 										'<a data-parent="'+(type == 'folder' ? result.parent_id : result.folder_id)+'" href="'+SITE_URL+'admin/files#">'+result.name+'</a>'+
 									'</li>');
 							});
 						}
 					});
 				} else {
					$('.console .search-results').append(
						'<li>'+
							'<div class="info"></div>'+
							results.message+
						'</li>'); 							
				}
 			})
	 	} else {
	 		$('.console .search-results').empty();
	 	}
 	});

 	$('.console .search-results').on('click', 'a', function(e){
 		e.preventDefault();
 		var id = $(this).attr('data-parent');
 		var text = $(this).html();
 		pyro.files.folder_contents(id);

 		// after the folder contents have loaded highlight the results
 		$(window).on('load-completed', function(e, results){
 			$('.folders-center :contains('+text+')').parent('li').addClass('selected');
 		});
 	});

 	/***************************************************************************
	 * Open folders                                                            *
	 ***************************************************************************/
 	$('.folders-center').on('dblclick', '.folder', function(e){
 		// store element so it can be accessed the same as if it was right clicked
 		pyro.files.$last_r_click = $(e.target).closest('li');

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
 			$clicked.parent('li').children('ul').slideToggle(50);
 			$clicked.parent('li').toggleClass('open close');
 		}
 	});

	/***************************************************************************
	 * Context menu management                                                 *
	 ***************************************************************************/

	// open a right click menu on items in the main area
	$('.item').on('contextmenu', '.folders-center, .folders-center li', function(e){
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
				var folder = true;
			} else if ($(e.target).hasClass('pane') && pyro.files.current_level == 0){
				var pattern = new RegExp('root-pane');
			} else {
				var pattern = new RegExp('pane');
			}

			// now hide this item if it's not allowed for that type
			if ( ! pattern.test($(this).attr('data-applies-to'))){
				$(this).hide();
			}

			// and hide it if they don't have permission for it
			if ($(this).attr('data-role') && $.inArray($(this).attr('data-role'), pyro.files.permissions) < 0) {
				$(this).hide();
			}

			// one final check for the oddball "synchronize". If it's a local folder we hide it anyway
			if (folder && $(this).attr('data-role') == 'synchronize') {
				// fetch the item's data so we can check what its location is
				$item = $(window).data('folder_'+pyro.files.$last_r_click.attr('data-id'));
				// sorry buddy, no cloud for you
				if ($item.location == 'local') {
					$(this).hide();
				}
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
				$('.no_data').fadeOut(100);
				// jQuery insists on adding the folder before no_data is removed. So we force it to wait
				setTimeout(function(){
					pyro.files.new_folder(pyro.files.current_level)
				}, 150);
			break;

			case 'rename':
				pyro.files.rename();
			break;

			case 'download':
				var $item = $(window).data('file_'+pyro.files.$last_r_click.attr('data-id'));
				log($item);
				if ($item.type == 'i' && $item.location !== 'local') {
					window.open(SITE_URL+'files/download/'+$item.id);
				} else {
					window.location = SITE_URL+'files/download/'+$item.id;
				}
			break;

			case 'synchronize':
				pyro.files.synchronize();
			break;

			case 'delete':
				if ( ! confirm(pyro.lang.dialog_message)) return;
				pyro.files.delete_item(pyro.files.current_level);
			break;

			case 'details':
				pyro.files.details();
			break;
		}
	});

	/***************************************************************************
	 * Select files including with the control and shift keys                  *
	 ***************************************************************************/

	$('.folders-center').on('click', '.file[data-id]', function(e){
		e.stopPropagation();
		var first;
		var last;

		var selected = $('.folders-center').find('.selected').length;
		if ( ! e.ctrlKey && ! e.shiftKey) {
			if(selected > 0) {
				$('[data-id]').removeClass('selected');
			}
		}
		$(this).toggleClass('selected');

		// select 
		if (e.shiftKey){
			$('.folders-center .selected:last')
				.prevAll('.folders-center .selected:first ~ *')
				.addClass('selected');
		}
	});

	// if they left click in the main area reset selected items or hide the context menu
	$('html').click(function(e){
		$('.folders-center li').removeClass('selected');
		$('.context-menu-source').fadeOut('fast');
	});

	/***************************************************************************
	 * File and folder sorting                                                 *
	 ***************************************************************************/

	$('.folders-center').sortable({
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
					// synchronize the folders in the left sidebar
					var after_id = $(e.target).prevAll('li.folder').attr('data-id');
					var moved    = '[data-id="'+$(e.target).attr('data-id')+'"]';

					if (after_id === undefined && $(moved).parent().is('.folders-sidebar')) {
						$('.folders-sidebar [data-id="0"]')
							.after($('.folders-sidebar '+moved));
					} else if (after_id === undefined && $(moved).parent().is('ul')) {
						$('.folders-sidebar '+moved).parent('ul')
							.prepend($('.folders-sidebar '+moved));
					} else {
						$('.folders-sidebar [data-id="'+after_id+'"]')
							.after($('.folders-sidebar '+moved));
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

		// we use the current level if they clicked in the open area
		if (pyro.files.$last_r_click.attr('data-id') > '') {
			pyro.files.upload_to = pyro.files.$last_r_click.attr('data-id');
		} else {
			pyro.files.upload_to = pyro.files.current_level;
		}

		var folder = $(window).data('folder_'+pyro.files.upload_to);

		$.colorbox({
			scrolling	: false,
			inline		: true,
			href		: '#files-uploader',
			width		: '920',
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

	pyro.init_upload = function($form){
		$form.find('form').fileUploadUI({
			fieldName       : 'file',
			uploadTable     : $('#files-uploader-queue'),
			downloadTable   : $('#files-uploader-queue'),
			previewSelector : '.file_upload_preview div',
	        cancelSelector  : '.file_upload_cancel div.cancel-icon',
			buildUploadRow	: function(files, index, handler){
				var resize = '';
				var type = files[index]['type'];
				// if it isn't an image then they can't resize it
				if (type.search('image') >= 0) {
					resize = 	'<label>'+pyro.lang.width+'</label>'+
								'<select name="width" class="skip"><option value="0">'+pyro.lang.full_size+'</option><option value="100">100px</option><option value="200">200px</option><option value="300">300px</option><option value="400">400px</option><option value="500">500px</option><option value="600">600px</option><option value="700">700px</option><option value="800">800px</option><option value="900">900px</option><option value="1000">1000px</option><option value="1100">1100px</option><option value="1200">1200px</option><option value="1300">1300px</option><option value="1400">1400px</option><option value="1500">1500px</option><option value="1600">1600px</option><option value="1700">1700px</option><option value="1800">1800px</option><option value="1900">1900px</option><option value="2000">2000px</option></select>'+
								'<label>'+pyro.lang.height+'</label>'+
								'<select name="height" class="skip"><option value="0">'+pyro.lang.full_size+'</option><option value="100">100px</option><option value="200">200px</option><option value="300">300px</option><option value="400">400px</option><option value="500">500px</option><option value="600">600px</option><option value="700">700px</option><option value="800">800px</option><option value="900">900px</option><option value="1000">1000px</option><option value="1100">1100px</option><option value="1200">1200px</option><option value="1300">1300px</option><option value="1400">1400px</option><option value="1500">1500px</option><option value="1600">1600px</option><option value="1700">1700px</option><option value="1800">1800px</option><option value="1900">1900px</option><option value="2000">2000px</option></select>'+
								'<label>'+pyro.lang.ratio+'</label>'+
								'<input name="ratio" type="checkbox" value="1"/>';
				}
				// build the upload html for this file
				return $('<li>'+
							'<div class="file_upload_preview ui-corner-all"><div class="ui-corner-all preview-container"></div></div>' +
							'<div class="filename"><label for="file-name">' + files[index].name + '</label>' +
								'<input class="file-name" type="hidden" name="name" value="'+files[index].name+'" />' +
							'</div>' +
							'<div class="file_upload_progress"><div></div></div>' +
							'<div class="file_upload_cancel">' +
								resize+
								'<div title="'+pyro.lang.start+'" class="start-icon ui-helper-hidden-accessible"></div>'+
								'<div title="'+pyro.lang.cancel+'" class="cancel-icon"></div>' +
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
				handler.uploadRow.find('div.start-icon').click(function(){
					handler.formData = {
						name: handler.uploadRow.find('input.file-name').val(),
						width: handler.uploadRow.find('[name="width"]').val(),
						height: handler.uploadRow.find('[name="height"]').val(),
						ratio: handler.uploadRow.find('[name="ratio"]').val(),
						folder_id: pyro.files.upload_to,
						csrf_hash_name: $.cookie('csrf_cookie_name')
					};
					callBack();
				});
			},
			onComplete: function (event, files, index, xhr, handler){
				if (files.length == index + 1) {
					$('#files-uploader a.cancel-upload').click();
				}
			}
		});

		$form.on('click', '.start-upload', function(e){
			e.preventDefault();
			$('#files-uploader-queue div.start-icon').click();
		});

		$form.on('click', '.cancel-upload', function(e){
			e.preventDefault();
			$('#files-uploader-queue div.cancel-icon').click();
			$.colorbox.close();
		});

	}

	pyro.init_upload($('#files-uploader'));


	/***************************************************************************
	 * All functions that are part of the pyro.files namespace                 *
	 ***************************************************************************/
	 pyro.files.new_folder = function(parent, name)
	 {
	 	if (typeof(name) === 'undefined') name = pyro.lang.untitled_folder;
	 	var new_class = Math.floor(Math.random() * 1000);

		// add an editable one to the right pane
		$('.new-folder').clone()
			.appendTo('.folders-center')
			.removeClass('new-folder')
			.addClass('folder folder-' + new_class);

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

				$parent_li = $('.folders-sidebar .folder[data-id="'+parent+'"]');
				if (parent === 0 || $parent_li.hasClass('places')) {
					// this is a top level folder, we'll insert it after Places. Not really its parent
					$parent_li.after('<li class="folder" data-id="'+results.data.id+'" data-name="'+results.data.name+'"><div></div><a href="#">'+results.data.name+'</a></li>');
				} else if ($parent_li.has('ul').length > 0) {
					// it already has children so we'll just append this li to its ul
					$parent_li.children('ul')
						.append('<li class="folder" data-id="'+results.data.id+'" data-name="'+results.data.name+'"><div></div><a href="#">'+results.data.name+'</a></li>');
				} else {
					// it had no children, we'll have to add the <ul> and the icon class also
					$parent_li.append('<ul><li class="folder" data-id="'+results.data.id+'" data-name="'+results.data.name+'"><div></div><a href="#">'+results.data.name+'</a></li></ul>');
					$parent_li.addClass('close');			
				}

				// save its data locally
				$(window).data('folder_'+results.data.id, results.data);

				// now they will want to rename it
		 		pyro.files.$last_r_click = $('.folder[data-id="'+results.data.id+'"]');
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
				$('.folders-center li').each(function(index){
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
				$('.folders-center li').fadeOut('fast').remove();

				// iterate over array('folder' => $folders, 'file' => $files)
				$.each(results.data, function(type, data){

					$.each(data, function(index, item){

						// if it's an image then we set the thumbnail as the content
						if (item.type && item.type == 'i') {
							var li_content = '<img src="'+SITE_URL+'files/cloud_thumb/'+item.id+'" alt="'+item.name+'"/>'+
												'<span class="name-text">'+item.name+'</span>';
						} else {
							var li_content = '<span class="name-text">'+item.name+'</span>'
						}

						$('.folders-center').append(
							'<li class="'+type+' '+(type == 'file' ? 'type-'+item.type : '')+'" data-id="'+item.id+'" data-name="'+item.name+'">'+
								li_content+
							'</li>'
						);
						// save all its details for other uses. The Details window for example
						$(window).data(type+'_'+item.id, item);
					})

				});

				// Toto, we're not in Kansas anymore
				pyro.files.current_level = folder_id;

				// show the children in the left sidebar
				$('.folders-sidebar [data-id="'+folder_id+'"] > ul:hidden').parent('li').children('div').trigger('click');

				// add the current indicator to the correct folder
				$('.folders-sidebar li').removeClass('current');
				$('.folders-sidebar [data-id="'+folder_id+'"]:not(.places)').addClass('current');

				// and we succeeded
				results.message = pyro.lang.fetch_completed;
				$(window).trigger('show-message', results);
				$(window).trigger('load-completed');
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
	 		} else {
	 			if ($(this).val().length > 49) {
	 				$(this).val($(this).val().slice(0, 50));
	 			}
	 		}
	 	})

	 	$input.blur(function(){
	 		var post = {}
	 		var item_data;
	 		post[type+'_id'] = $item.parent('li').attr('data-id');
 			post['name'] = $input.val();
 			var item_data = $(window).data(type+'_'+post['folder_id']);

 			if (item_data == undefined || item_data.name !== post['name']) {
 				if (item_data == undefined) {
 					var item_data = {};
 				}

		 		$.post(SITE_URL + 'admin/files/rename_'+type, post, function(data){
		 			var results = $.parseJSON(data);
		 			$(window).trigger('show-message', results);

		 			// update the local data
		 			item_data.name = results.data.name;
		 			item_data.slug = results.data.slug;
		 			$(window).data(type+'_'+item_data.id, item_data);

		 			// remove the input and place the text back in the span
		 			$('[name="rename"]').parent().html(results.data.name);
		 			$('.folders-sidebar').find('[data-id="'+post.folder_id+'"] > a').html(results.data.name);
		 			$('.'+type+'[data-id="'+post[type+'_id']+'"]').attr('data-name', results.data.name);
		 		})
	 		}

	 		$('[name="rename"]').parent().html($('[name="rename"]').val());
	 	})
	 }

	 pyro.files.delete_item = function(current_level)
	 {
	 	var post = {};
	 	var items = $('.selected[data-id]');
	 	// if there are selected items then they have to be files
	 	var type = items.length > 0 ? 'file' : 'folder';

	 	// file or folder?
	 	if (items.length > 0 || pyro.files.$last_r_click.hasClass('file')){
	 		type = 'file';

	 		// they've clicked on a file but it isn't selected. Grab it and stuff it into "items"
	 		if (items.length === 0){
		 		items = pyro.files.$last_r_click;
		 	}

	 		items.each(function(index, item){
	 			post.file_id = $(item).attr('data-id');
	 			// delete remotely
	 			do_delete(post.file_id, 'file');
	 		})
	 	} else {
	 		items = pyro.files.$last_r_click;
	 		// gotta be a folder
	 		type = 'folder';
	 		items.each(function(index, item){
	 			post.folder_id = $(item).attr('data-id');
	 			// delete remotely
	 			do_delete(post.folder_id, 'folder');
	 		})
	 	}

 		function do_delete(id, type){
	 		$.post(SITE_URL + 'admin/files/delete_'+type, post, function(data){
	 			var results = $.parseJSON(data);
	 			$(window).trigger('show-message', results);
	 			if (results.status && type == 'file') {
		 			// delete locally
		 			$(window).removeData('file_'+id);
	 				$('.folders-center .file[data-id="'+id+'"]').remove();
	 			}
	 			if (results.status && type == 'folder') {
		 			// delete locally
		 			$(window).removeData('folder_'+id);
		 			// remove it from the left and right panes
	 				$('.folder[data-id="'+id+'"]').remove();
	 				// adjust the parents
					$('.folder[data-id="'+current_level+'"] ul:empty').remove();
					$('.folder[data-id="'+current_level+'"]').removeClass('open close');

					// if they are trying it out and created a folder and then removed it
					// then we show the no data messages again
					if ($('.folders-center li').length == 0) {
						$('.no_data').fadeIn('fast');
					}
	 			}
	 		});
		}
	 }

	 pyro.files.details = function()
	 {
	 	var timer;
	 	var location;
	 	// file or folder?
	 	var type = pyro.files.$last_r_click.hasClass('file') ? 'file' : 'folder';
	 	// figure out the ID from the last clicked item
	 	var $item_id = pyro.files.$last_r_click.attr('data-id') > 0 ? pyro.files.$last_r_click.attr('data-id') : 0;
	 	// retrieve all the data that was stored when the item was initially loaded
	 	var $item = $(window).data(type+'_'+$item_id);
	 	var $select = $('.item-details .location');

	 	// hide all the unused elements
	 	$('.item-details li').hide();

	 	if ($item) {
		 	if ($item.name) 			$('.item-details .name')			.html($item.name).parent().show();
		 	if ($item.slug) 			$('.item-details .slug')			.html($item.slug).parent().show();
		 	if ($item.path) 			$('.item-details .path')			.val($item.path).parent().show();
		 	if ($item.formatted_date) 	$('.item-details .added')			.html($item.formatted_date).parent().show();
		 	if ($item.width > 0) 		$('.item-details .width')			.html($item.width+'px').parent().show();
		 	if ($item.height > 0) 		$('.item-details .height')			.html($item.height+'px').parent().show();
		 	if ($item.filesize) 		$('.item-details .filesize')		.html(($item.filesize < 1000 ? $item.filesize+'Kb' : $item.filesize / 1000+'MB')).parent().show();
		 	if ($item.download_count) 	$('.item-details .download_count')	.html($item.download_count).parent().show();
		 	if ($item.filename) 		$('.item-details .filename')		.html($item.filename).parent().show();
		 	if (type == 'file') 		$('.item-details .description')		.val($item.description).parent().show();

		 	// they can only change the cloud provider if the folder is empty and they have permission
		 	if (type == 'folder' && $item.file_count == 0 && $.inArray('set_location', pyro.files.permissions) >= 0){
		 		// update the value and trigger an update on Chosen
		 		$select.val($item.location).find('option[value="'+$item.location+'"]').attr('selected', true);
		 		$select.trigger('liszt:updated').parents().show();
		 	} else if (type == 'folder') {
		 		// show the location
		 		$('.item-details .location-static').html($item.location).parent().show();
		 		// show the bucket/container also if it has one
		 		if ($item.remote_container > '') {
			 		$('.item-details .container-static').html($item.remote_container).parent().show();		 		
				}
		 	}

		 	// show/hide the bucket/container name field on change
		 	$select.change(function(e){
		 		location = $(e.target).val();
		 		$('.item-details .container').parent().hide();
		 		$('.'+location).parent().show();
		 	});

		 	// check if a container with that name exists
		 	$('.container-button').on('click', function(e){
	 			var post = { 'name' : $(this).siblings('.container').val(), 'location' : location };
	 			$.post(SITE_URL + 'admin/files/check_container', post, function(data){
		 			var results = $.parseJSON(data);
		 			$(window).trigger('show-message', results);
	 			});
 			});

			$.colorbox({
				scrolling	: false,
				inline		: true,
				href		: 'div.item-details',
				width		: '500',
				height		: type == 'file' ? '575' : '380',
				opacity		: 0
			});

			// save on click, then close the modal
			$('.item-details .buttons').on('click', function(){
				if (type == 'file'){
					pyro.files.save_description($item);
				} else {
					pyro.files.save_location($item);
				}
				$.colorbox.close();

				$(this).off('click');
			});
		}
	 }

	 pyro.files.save_description = function(item)
	 {
	 	var new_description = $('.item-details textarea.description').val();

	 	// only save it if it's different than the old one
	 	if (item.description != new_description){

		 	post = { 'file_id' : item.id, 'description' : new_description };

	 		$.post(SITE_URL + 'admin/files/save_description', post, function(data){
	 			var results = $.parseJSON(data);
	 			$(window).trigger('show-message', results);

	 			// resave it locally
	 			item.description = new_description;
	 			$(window).data('file_'+item.id, item);
	 		});
	 	}
	 }

	 pyro.files.save_location = function(item)
	 {
	 	var new_location = $('.item-details .location').val();
	 	var container = $('.item-details .'+new_location).val();

	 	post = { 'folder_id' : item.id, 'location' : new_location, 'container' : container };

 		$.post(SITE_URL + 'admin/files/save_location', post, function(data){
			var results = $.parseJSON(data);
			$(window).trigger('show-message', results);
			if (results.status) {
				// resave it locally
				item.location = new_location;
				item.remote_container = container;
		 		$(window).data('folder_'+item.id, item);
			}
 		});
 	}

 	pyro.files.synchronize = function()
 	{
 		$(window).trigger('show-message', { status : null, message : pyro.lang.synchronization_started });

 		folder_id = pyro.files.$last_r_click.attr('data-id');

 	 	post = { 'folder_id' : folder_id };

 		$.post(SITE_URL + 'admin/files/synchronize', post, function(data){
 			var results = $.parseJSON(data);
 			$(window).trigger('show-message', results);
 			if (results.status) {
 				pyro.files.folder_contents(folder_id);
 			}
 		});		
 	}

 	/***************************************************************************
	 * And off we go... load the root folder                                   *
	 ***************************************************************************/
	if ($('.folders-center').find('.no_data').length == 0) {
		pyro.files.folder_contents(0);
	}
});