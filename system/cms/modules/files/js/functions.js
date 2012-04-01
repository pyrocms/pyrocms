jQuery(function($){

	pyro.files.cache = {};
	pyro.files.history = {};
	pyro.files.timeout = {};
	pyro.files.current_level = 0;

	/***************************************************************************
	 * Activity sidebar message handler                                        *
	 ***************************************************************************/
	$(window).on('show-message', function(e, results) {

		if (results.message > '') {

			var li_status_class = 'info';
			var status_class = 'icon-info-sign';

			switch (results.status) {
				case true:
					li_status_class = 'success';
					status_class = 'icon-ok-sign';
				break;

				case false:
					li_status_class = 'failure';
					status_class = 'icon-remove-sign';
				break;
			}

			$('<li class="' + li_status_class + '"><i class="' + status_class + '"></i>' + results.message + '</li>').prependTo('#console');
		}
	});

	/***************************************************************************
	 * Sidebar search functionality                                            *
	 ***************************************************************************/
	var $search_results = $('ul#search-results');

	$('input#file-search').keyup(function(e){

		$search_results.empty();

		// submit on Enter
		if (e.which === 13) {

			 $.post(SITE_URL+'admin/files/search', { search : $(e.target).val() }, function(data){
				var results = $.parseJSON(data);
				if (results.status) {
					$.each(results.data, function(type, item){
						if (item.length > 0){
							$.each(item, function(i, result){
								 $('<li>'+
										 '<div class="'+type+'"></div>'+
										 '<a data-parent="'+(type === 'folder' ? result.parent_id : result.folder_id)+'" href="'+SITE_URL+'admin/files#">'+result.name+'</a>'+
									'</li>').appendTo('ul#search-results');
							});
						}
					});
				} else {
					 $('<li><div class="info"></div>' + results.message + '</li>').appendTo('ul#search-results');
				}
			});

	 	}
	});

	$search_results.on('click', 'a', function(e){
		e.preventDefault();

		var $el = $(this);
		var id = $el.attr('data-parent');
		var text = $el.html();

		pyro.files.folder_contents(id);

		// after the folder contents have loaded highlight the results
		$(window).on('load-completed', function(e, results){
			$('.folders-center :contains('+text+')').parent('li').addClass('selected');
		});
	});

	/***************************************************************************
	 * Open folders                                                            *
	 ***************************************************************************/
	var $folders_center = $('.folders-center');

	$folders_center.on('dblclick', '.folder', function(e){
		// store element so it can be accessed the same as if it was right clicked
		pyro.files.$last_r_click = $(e.target).closest('li');

		$('.context-menu-source [data-menu="open"]').trigger('click');
	});

	$('ul#folders-sidebar').find('li').has('ul').addClass('open');

	// use a single left click in the left sidebar
	$('ul#folders-sidebar').on('click', '.folder', function(e){
		e.preventDefault();
		e.stopPropagation();

		var $clicked = $(e.target);

		// did they click on the link or the icon
		if ($clicked.is('a')) {
	 		// store element so it can be accessed the same as if it was right clicked
	 		pyro.files.$last_r_click = $clicked.parent('li');
	 		$('.context-menu-source [data-menu="open"]').trigger('click');
		} else {
			$clicked
				.parent('li').toggleClass('open close')
				.children('ul').slideToggle(50);
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

		var $context_menu_source = $('.context-menu-source');

		$context_menu_source.find('li')
			// reset in case they've right clicked before
			.show()
			// what did the user click on? folder, pane, or file
			.filter(function(index){
				
				var folder;
				var pattern = new RegExp('pane');

				// make an exception cause the image thumbnail itself may be the target
				if ($(e.target).hasClass('file') || $(e.target).is('img')){
					pattern = new RegExp('file');
				} else if ($(e.target).hasClass('folder')){
					pattern = new RegExp('folder');
					folder = true;
				} else if ($(e.target).hasClass('pane') && pyro.files.current_level == 0){
					pattern = new RegExp('root-pane');
				}

				// now hide this item if it's not allowed for that type
				if ( ! pattern.test($(this).attr('data-applies-to'))){
					$(this).hide();
				}

				// and hide it if they don't have permission for it
				if ($(this).attr('data-role') && pyro.files.permissions.indexOf($(this).attr('data-role')) < 0) {
					$(this).hide();
				}

				// one final check for the oddball "synchronize". If it's a local folder we hide it anyway
				if (folder && $(this).attr('data-role') === 'synchronize') {
					// fetch the item's data so we can check what its location is
					$item = $(window).data('folder_'+pyro.files.$last_r_click.attr('data-id'));
					// sorry buddy, no cloud for you
					if ($item.location === 'local') {
						$(this).hide();
					}
				}
				
			});

		// jquery UI position the context menu by the mouse
		$context_menu_source
			.fadeIn('fast')
			.position({
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
				pyro.files.folder_contents( pyro.files.$last_r_click.attr('data-id') );
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
				if ($item.type === 'i' && $item.location !== 'local') {
					window.open(SITE_URL+'files/download/'+$item.id);
				} else {
					window.location = SITE_URL+'files/download/'+$item.id;
				}
			break;

			case 'synchronize':
				pyro.files.synchronize();
			break;

			case 'delete':
				if ( ! confirm(pyro.lang.dialog_message)) {
					return;
				}
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

	$folders_center.on('click', '.file[data-id]', function(e){
		e.stopPropagation();

		var first;
		var last;
		var $selected_files = $folders_center.find('.selected');

		if ( ! e.ctrlKey && ! e.shiftKey) {
			if($selected_files.length > 0) {
				$('[data-id]').removeClass('selected');
			}
		}
		$(this).toggleClass('selected');

		// select 
		if (e.shiftKey) {
			$folders_center
				.find('.selected')
				.last()
				.prevAll('.selected:first ~ *')
				.addClass('selected');
		}
	});

	// if they left click in the main area reset selected items or hide the context menu
	$('html').on('click', function(e){
		$folders_center.find('li').removeClass('selected');
		$('.context-menu-source').fadeOut('fast');
	});

	/***************************************************************************
	 * File and folder sorting                                                 *
	 ***************************************************************************/

	$folders_center.sortable({
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
						$('ul#folders-sidebar [data-id="0"]')
							.after($('ul#folders-sidebar '+moved));
					} else if (after_id === undefined && $(moved).parent().is('ul')) {
						$('ul#folders-sidebar '+moved).parent('ul')
							.prepend($('ul#folders-sidebar '+moved));
					} else {
						$('ul#folders-sidebar [data-id="'+after_id+'"]')
							.after($('ul#folders-sidebar '+moved));
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
				var $progress_div = handler.uploadRow.find('.file_upload_progress');

				// check if the server can handle it
				if (files[index].size > pyro.files.max_size_possible) {
					$progress_div.html(pyro.lang.exceeds_server_setting);
					return false;
				} else if (files[index].size > pyro.files.max_size_allowed) {
					$progress_div.html(pyro.lang.exceeds_allowed);
					return false;
				}

				// is it an allowed type?
				var regexp = new RegExp(pyro.files.valid_extensions);
				// Using the filename extension for our test,
				// as legacy browsers don't report the mime type
				if (!regexp.test(files[index].name)) {
					$progress_div.html(pyro.lang.file_type_not_allowed);
					return false;
				}

				handler.uploadRow.find('div.start-icon').on('click', (function() {
					handler.formData = {
						name: handler.uploadRow.find('input.file-name').val(),
						width: handler.uploadRow.find('[name="width"]').val(),
						height: handler.uploadRow.find('[name="height"]').val(),
						ratio: handler.uploadRow.find('[name="ratio"]').val(),
						folder_id: pyro.files.upload_to,
						csrf_hash_name: $.cookie('csrf_cookie_name')
					};
					callBack();
				}));
			},

			onComplete: function (event, files, index, xhr, handler){
				if (files.length === index + 1) {
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

	};

	pyro.init_upload($('#files-uploader'));


	/***************************************************************************
	 * All functions that are part of the pyro.files namespace                 *
	 ***************************************************************************/

	// todo: maybe we should not save the folder until the user has put a name, fake the folder creation until then?
	pyro.files.new_folder = function(parent, name) {

		if (typeof(name) === 'undefined') {
			name = pyro.lang.new_folder_name;
		}

		var new_class = Math.floor(Math.random() * 1000);

		// add an editable one to the right pane
		$('.new-folder').clone()
			.removeClass('new-folder')
			.appendTo('.folders-center')
			.addClass('folder folder-' + new_class);


		var post_data = { parent : parent, name : name };

		$.post(SITE_URL + 'admin/files/new_folder', post_data, function(data){
			var results = $.parseJSON(data);

			if (results.status) {

				// add the id in so we know who he is
				$('.folder-' + new_class).attr('data-id', results.data.id);

				// update the text and remove the temporary class
				$('.folder-' + new_class + ' .name-text')
					.html(results.data.name)
					.removeClass('folder-' + new_class);

				$parent_li = $('ul#folders-sidebar .folder[data-id="'+parent+'"]');
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
	 };

	pyro.files.folder_contents = function(folder_id) {

	 	var level = pyro.files.current_level;
		var folders = [];
		var files = [];
		
		// let them know we're getting the stuff, it may take a second
		$(window).trigger('show-message', {message: pyro.lang.fetching});

		var post_data = { parent : folder_id }
		$.post(SITE_URL + 'admin/files/folder_contents', post_data, function(data){
			var results = $.parseJSON(data);

			if (results.status) {

				// iterate over all items so we can build a cache
				$folders_center.find('li').each(function(index){
					var folder = {};
					var file = {};

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
				pyro.files.history[level] = {
					folder : folders,
					file : files
				};

				// so let's wipe it clean...
				$('.folders-center ').find('li').fadeOut('fast').remove();

				// iterate over array('folder' => $folders, 'file' => $files)
				$.each(results.data, function(type, data){

					$.each(data, function(index, item){

						// if it's an image then we set the thumbnail as the content
						var li_content = '<span class="name-text">'+item.name+'</span>';
						if (item.type && item.type === 'i') {
							li_content = '<img src="'+SITE_URL+'files/cloud_thumb/'+item.id+'" alt="'+item.name+'"/>'+li_content;
						}

						$folders_center.append(
							'<li class="'+type+' '+(type === 'file' ? 'type-'+item.type : '')+'" data-id="'+item.id+'" data-name="'+item.name+'">'+
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
				$('ul#folders-sidebar [data-id="'+folder_id+'"] > ul:hidden').parent('li').children('div').trigger('click');

				// add the current indicator to the correct folder
				$('ul#folders-sidebar').find('li').removeClass('current');
				$('ul#folders-sidebar [data-id="'+folder_id+'"]').not('.places').addClass('current');

				// and we succeeded
				results.message = pyro.lang.fetch_completed;
				$(window).trigger('show-message', results);
				$(window).trigger('load-completed');
			}
		});
	 };

	pyro.files.rename = function() {

		// what type of item are we renaming?
		var type = pyro.files.$last_r_click.hasClass('folder') ? 'folder' : 'file';

		// if they have one selected already then undo it
		$('[name="rename"]').parent().html($('[name="rename"]').val());

		var $item = pyro.files.$last_r_click.find('.name-text');
		$item.html('<input name="rename" value="'+$item.html()+'"/>');

		var $input  = $item.find('input');
		$input.select();

		$input.keyup(function(e){
			if(e.which === 13) {
				$input.trigger('blur');
			} else {
				if ($(this).val().length > 49) {
					$(this).val($(this).val().slice(0, 50));
				}
			}
		});

		$input.blur(function(){
			var item_data;
			var post = { name: $input.val() };

			post[type+'_id'] = $item.parent('li').attr('data-id');

			item_data = ($(window).data(type+'_'+post[type+'_id']) || {});

			if ( $.isEmptyObject(item_data) || item_data.name !== post['name']) {

				$.post(SITE_URL + 'admin/files/rename_'+type, post, function(data){

					var results = $.parseJSON(data);
					$(window).trigger('show-message', results);

		 			// update the local data
					$.extend(item_data, results.data);

					$(window).data(type+'_'+item_data.id, item_data);

		 			// remove the input and place the text back in the span
		 			$('input[name="rename"]').parent().html(results.data.name);
		 			$('ul#folders-sidebar').find('[data-id="'+post.folder_id+'"] > a').html(results.data.name);
		 			$('.'+type+'[data-id="'+post[type+'_id']+'"]').attr('data-name', results.data.name);
		 		})
	 		}

	 		$('input[name="rename"]').parent().html($('input[name="rename"]').val());
	 	})
	};

	pyro.files.delete_item = function(current_level) {

	 	// only files can be multi-selected
	 	var items = $('.selected[data-id]');

	 	// if there are selected items then they have to be files
		var type = items.length > 0 ? 'file' : 'folder';

		// multiple files or a single file
	 	if (type === 'file' || pyro.files.$last_r_click.hasClass('file')) {
			// nothing multi-selected so we use the item clicked on
			// and make sure the `type` is file
			if (items.length === 0) {
				items = pyro.files.$last_r_click;
				type = 'file';
			}
		} else {
			// it's a folder so we use the item clicked
			items = pyro.files.$last_r_click;
		}

		items.each(function (index, item) {

			var id = $(item).attr('data-id');
			var post_data = {};
			post_data[type + '_id'] = id;

			$.post(SITE_URL + 'admin/files/delete_' + type, post_data, function (data) {
				var results = $.parseJSON(data);

				if (results.status) {
					// delete locally
					$(window).removeData(type + '_' + id);

					switch (type) {
						case 'file':
							$('.folders-center .file[data-id="' + id + '"]').remove();
						break;

						case 'folder':
							// remove it from the left and right panes
							$('.folder[data-id="' + id + '"]').remove();
							// adjust the parents
							$('.folder[data-id="' + current_level + '"] ul:empty').remove();
							$('.folder[data-id="' + current_level + '"]').removeClass('open close');

						break;
					}

					// if they are trying it out and created a folder and then removed it
					// then we show the no data messages again
					if ($folders_center.find('li').length === 0) {
						$('.no_data').fadeIn('fast');
					}
					
					$(window).trigger('show-message', results);
				}
			});
		});
	 };

	var $item_details = $('div#item-details');

	pyro.files.details = function() {

	 	var timer, location;
			// file or folder?
		var type = pyro.files.$last_r_click.hasClass('file') ? 'file' : 'folder';
			// figure out the ID from the last clicked item
		var $item_id = pyro.files.$last_r_click.attr('data-id') > 0 ? pyro.files.$last_r_click.attr('data-id') : 0;
			// retrieve all the data that was stored when the item was initially loaded
		var $item = $(window).data(type+'_'+$item_id);
		var $select = $item_details.find('.location');

	 	// hide all the unused elements
	 	$item_details.find('li').hide();

	 	if ($item) {
		 	if ($item.name) 			$item_details.find('.name')				.html($item.name).parent().show();
		 	if ($item.slug) 			$item_details.find('.slug')				.html($item.slug).parent().show();
		 	if ($item.path) 			$item_details.find('.path')				.val($item.path).parent().show();
		 	if ($item.formatted_date) 	$item_details.find('.added')			.html($item.formatted_date).parent().show();
		 	if ($item.width > 0) 		$item_details.find('.width')			.html($item.width+'px').parent().show();
		 	if ($item.height > 0) 		$item_details.find('.height')			.html($item.height+'px').parent().show();
		 	if ($item.filesize) 		$item_details.find('.filesize')			.html(($item.filesize < 1000 ? $item.filesize+'Kb' : $item.filesize / 1000+'MB')).parent().show();
		 	if ($item.download_count) 	$item_details.find('.download_count')	.html($item.download_count).parent().show();
		 	if ($item.filename) 		$item_details.find('.filename')			.html($item.filename).parent().show();
		 	if (type === 'file') 		$item_details.find('.description')		.val($item.description).parent().show();

		 	// they can only change the cloud provider if the folder is empty and they have permission
		 	if (type === 'folder' && $item.file_count === 0 && pyro.files.permissions.indexOf('set_location') > -1){
		 		// update the value and trigger an update on Chosen
		 		$select.val($item.location).find('option[value="'+$item.location+'"]').attr('selected', true);
		 		$select.trigger('liszt:updated').parents().show();
		 	} else if (type === 'folder') {
		 		// show the location
		 		$item_details.find('.location-static').html($item.location).parent().show();
		 		// show the bucket/container also if it has one
		 		if ($item.remote_container > '') {
			 		$item_details.find('.container-static').html($item.remote_container).parent().show();		 		
				}
		 	}

		 	// show/hide the bucket/container name field on change
		 	$select.change(function(e){
		 		location = $(e.target).val();
		 		$item_details.find('.container').parent().hide();
		 		$('.'+location).parent().show();
		 	});

		 	// check if a container with that name exists
		 	$('.container-button').on('click', function(e){
	 			var post_data = {
					name : 		$(this).siblings('.container').val(), 
					location : 	location 
				};
				$.post(SITE_URL + 'admin/files/check_container', post_data, function(data) {
		 			var results = $.parseJSON(data);
		 			$(window).trigger('show-message', results);
	 			});
 			});

			$.colorbox({
				scrolling	: false,
				inline		: true,
				href		: 'div#item-details',
				width		: '500',
				height		: (type === 'file') ? '575' : '380',
				opacity		: 0
			});

			// save on click, then close the modal
			$item_details.find('.buttons').on('click', function() {
				if (type === 'file'){
					pyro.files.save_description($item);
				} else {
					pyro.files.save_location($item);
				}
				$.colorbox.close();

				$(this).off('click');
			});
		}
	 };

	pyro.files.save_description = function(item) {

		var new_description = $item_details.find('textarea.description').val();
		var post_data = {
			file_id : item.id,
			description : new_description
		};

		// only save it if it's different than the old one
		if (item.description != new_description){

			$.post(SITE_URL + 'admin/files/save_description', post_data, function(data){

				var results = $.parseJSON(data);
				$(window).trigger('show-message', results);

				// resave it locally
				item.description = new_description;
				$(window).data('file_'+item.id, item);
			});
		}
	};

	pyro.files.save_location = function(item) {

		var new_location = $item_details.find('.location').val();
		var container = $('div#item-details .'+new_location).val();
		var post_data = {
			folder_id: 	item.id,
			location:  	new_location,
			container: 	container
		};

 	    $.post(SITE_URL + 'admin/files/save_location', post_data, function(data) {
			var results = $.parseJSON(data);
			$(window).trigger('show-message', results);
			if (results.status) {
				// resave it locally
				item.location = new_location;
				item.remote_container = container;
		 		$(window).data('folder_'+item.id, item);
			}
 		});
 	};

 	pyro.files.synchronize = function() {

		$(window).trigger('show-message', { status : null, message : pyro.lang.synchronization_started });

		var folder_id = pyro.files.$last_r_click.attr('data-id');
		var post_data = { folder_id: folder_id };

		$.post(SITE_URL + 'admin/files/synchronize', post_data, function(data){
			var results = $.parseJSON(data);
			$(window).trigger('show-message', results);
			if (results.status) {
				pyro.files.folder_contents(folder_id);
			}
		});

	};

 	/***************************************************************************
	 * And off we go... load the root folder                                   *
	 ***************************************************************************/
	if ($('.folders-center').find('.no_data').length === 0) {
		pyro.files.folder_contents(0);
	}
});