jQuery(function($){
	var $search_results,
		$folders_center,
		$item_details;
		// end function global vars

	pyro.files.cache = {};
	pyro.files.history = {};
	pyro.files.timeout = {};
	pyro.files.current_level = 0;

	// custom tooltips
	$('.files-tooltip').tipsy({
		gravity: 'n',
		fade: true,
		html: true,
		live: true,
		delayIn: 800,
		delayOut: 300,
		title: function() { 
			var text = $(this).find('span').html();
			if (text.length > 15) {
				return text;
			}
			return '';
		}
	});

	// Default button set
	$('.item .folders-center').trigger('click');


	/***************************************************************************
	 * Activity sidebar message handler                                        *
	 ***************************************************************************/
	$(window).on('show-message', function(e, results) {

		if (typeof(results.message) !== "undefined" && results.message > '') {

			var li_status_class = 'info',
				status_class = 'icon-info-sign';

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

			$('#activity').find('span').fadeOut();
			$('#activity').html('<span class="' + li_status_class + '"><i class="' + status_class + '"></i> ' + results.message + '</span>');
		}
	});

	/***************************************************************************
	 * Sidebar search functionality                                            *
	 ***************************************************************************/
	$search_results = $('ul#search-results');

	$('.sidebar-right').find('.close').on('click', function() {
		$search_results.empty();
		$('.sidebar-right').removeClass('fadeInRight').addClass('fadeOutRight');
		$('.side, .center').removeClass('three_column');
	});

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
				$('.sidebar-right').show().removeClass('fadeOutRight').addClass('fadeInRight');
				$('.side, .center').addClass('three_column');
			});

		}
	});

	$search_results.on('click', 'a', function(e){
		e.preventDefault();

		var $el = $(this),
			id = $el.attr('data-parent'),
			text = $el.html();

		pyro.files.folder_contents(id);

		// after the folder contents have loaded highlight the results
		$(window).on('load-completed', function(e, results){
			$('.folders-center').find('li').removeClass('selected');
			$('.folders-center :contains('+text+')').parent('li').addClass('selected');
		});
	});

	/***************************************************************************
	 * Open folders                                                            *
	 ***************************************************************************/
	$folders_center = $('.folders-center');

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

	// and use a single left click on the breadcrumbs
	$('#file-breadcrumbs').on('click', 'a', function(e){
		e.preventDefault();
		e.stopPropagation();

		// store element so it can be accessed the same as if it was right clicked
		pyro.files.$last_r_click = $(e.target);
		$('.context-menu-source [data-menu="open"]').trigger('click');
	});

	/***************************************************************************
	 * Context / button menu management                                        *
	 ***************************************************************************/

	// open a right click menu on items in the main area
	$('.item').on('contextmenu click', '.folders-center, .folders-center li', function(e){
		e.preventDefault();
		e.stopPropagation();

		// make the right clicked element easily accessible
		pyro.files.$last_r_click = $(this);

		var $menu_sources = $('.context-menu-source, .button-menu-source');
		var $context_menu_source = $('.context-menu-source');
		var $button_menu_source = $('.button-menu-source');

		// make sure the button menu is shown (it's hidden by css to prevent flash)
		$button_menu_source.fadeIn();

		$menu_sources.find('li')
			// reset in case they've right clicked before
			.show()
			// what did the user click on? folder, pane, or file
			.filter(function(index){

				var folder,
					pattern = new RegExp('pane'),
					// if they happen to click right on the name span then we need to shift to the parent
					$target = $(e.target).is('span') ? $(e.target).parent('li') : $(e.target);

				// make an exception cause the image thumbnail itself may be the target
				if ($target.hasClass('file') || $target.is('img')){
					pattern = new RegExp('file');
				} else if ($target.hasClass('folder')){
					pattern = new RegExp('folder');
					folder = true;
				} else if ($target.hasClass('pane') && pyro.files.current_level == '0'){
					pattern = new RegExp('root-pane');
				}

				// now hide this item if it's not allowed for that type
				if ( ! pattern.test($(this).attr('data-applies-to'))){
					$(this).hide();
				}

				// and hide it if they don't have permission for it
				if ( $(this).attr('data-role') && pyro.files.has_permissions( $(this).attr('data-role') ) === false ) {
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

		// IF this is a click on a folder
		// show the folder as selected
		// otherwise unselect any folder
		if ( $(e.target).hasClass('folder') )
		{
			// Remove selected files
			$('.folders-center li.selected').removeClass('selected');

			// Highlight folder
			$(e.target).addClass('highlight');
		}
		else
		{
			$('.folders-center li.highlight').removeClass('highlight');
		}

		// jquery UI position the context menu by the mouse IF e.type IS contextmenu
		if ( e.type == 'contextmenu' )
		{
			$('.tipsy').remove();

			$context_menu_source
				.fadeIn('fast')
				.position({
					my:			'left top',
					at:			'left bottom',
					of:			e,
					collision:	'fit'
				});
		}
		// otherwise they clicked off the context menu
		else
		{
			$context_menu_source.hide();
		}
	});

	// call the correct function for the menu item they have clicked
	$('.context-menu-source, .button-menu-source').on('click', '[data-menu]', function(e){

		var menu = $(this).attr('data-menu'),
			item;

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
					pyro.files.new_folder(pyro.files.current_level);
				}, 150);
			break;

			case 'rename':
				pyro.files.rename();
			break;

			case 'download':
				$item = $(window).data('file_'+pyro.files.$last_r_click.attr('data-id'));

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

				// "Click" on the resulting folder
				$('.item .folders-center').trigger('click');
			break;

			case 'replace':
				pyro.files.replace();
			break;

			case 'details':
				pyro.files.details();
			break;

			case 'refresh':
				pyro.files.folder_contents( pyro.files.current_level );
			break;
		}
	});

	/***************************************************************************
	 * Select files including with the control and shift keys                  *
	 ***************************************************************************/

	$folders_center.on('click', '.file[data-id]', function(e){

		var first,
			last,
			$selected_files = $folders_center.find('.selected');

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
				var results = $.parseJSON(data),
					after_id, moved;
				if (results.status) {
					// synchronize the folders in the left sidebar
					after_id = $(e.target).prevAll('li.folder').attr('data-id');
					moved = '[data-id="'+$(e.target).attr('data-id')+'"]';

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

		var folder;

		// we use the current level if they clicked in the open area or if they want to replace a file
		if ( ! pyro.files.$last_r_click.hasClass('file') && pyro.files.$last_r_click.attr('data-id') > '') {
			pyro.files.upload_to = pyro.files.$last_r_click.attr('data-id');
		} else {
			pyro.files.upload_to = pyro.files.current_level;
		}

		folder = $(window).data('folder_'+pyro.files.upload_to);

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

				$('#files-uploader').find('form').fileUploadUI('option', 'maxFiles', 0);
				//not really an option, but the only way to reset it from here
				$('#files-uploader').find('form').fileUploadUI('option', 'currentFileCount', 0);
				$("#file-to-replace").hide();
			},
			onLoad : function(){
				//onLoad is currently only used when replacing a file
				if( ! 'mode' in pyro.files || pyro.files.mode != 'replace' ) {
					return;
				}

				// the last thing that has been right clicked should be a file, so this might not be neccessary
				if ( pyro.files.$last_r_click.hasClass('file') )
				{
					$("#file-to-replace").find('span.name').text(pyro.files.$last_r_click.attr('data-name')).end().show();
					//set max file upload to 1
					$('#files-uploader').find('form').fileUploadUI('option', 'maxFiles', 1);
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
				var resize = '',
					type = files[index]['type'];
				// if it isn't an image then they can't resize it
				if (type && type.search('image') >= 0) {
					resize = 	'<label id="width">'+pyro.lang.width+'</label>'+
								'<select name="width" class="skip"><option value="0">'+pyro.lang.full_size+'</option><option value="100">100px</option><option value="200">200px</option><option value="300">300px</option><option value="400">400px</option><option value="500">500px</option><option value="600">600px</option><option value="700">700px</option><option value="800">800px</option><option value="900">900px</option><option value="1000">1000px</option><option value="1100">1100px</option><option value="1200">1200px</option><option value="1300">1300px</option><option value="1400">1400px</option><option value="1500">1500px</option><option value="1600">1600px</option><option value="1700">1700px</option><option value="1800">1800px</option><option value="1900">1900px</option><option value="2000">2000px</option></select>'+
								'<label id="height">'+pyro.lang.height+'</label>'+
								'<select name="height" class="skip"><option value="0">'+pyro.lang.full_size+'</option><option value="100">100px</option><option value="200">200px</option><option value="300">300px</option><option value="400">400px</option><option value="500">500px</option><option value="600">600px</option><option value="700">700px</option><option value="800">800px</option><option value="900">900px</option><option value="1000">1000px</option><option value="1100">1100px</option><option value="1200">1200px</option><option value="1300">1300px</option><option value="1400">1400px</option><option value="1500">1500px</option><option value="1600">1600px</option><option value="1700">1700px</option><option value="1800">1800px</option><option value="1900">1900px</option><option value="2000">2000px</option></select>'+
								'<label id="ratio">'+pyro.lang.ratio+'</label>'+
								'<input name="ratio" type="checkbox" value="1" checked="checked"/>'+
								'<label id="alt">'+pyro.lang.alt_attribute+'</label>'+
								'<input type="text" name="alt_attribute" class="alt_attribute" />';
				}
				// build the upload html for this file
				return $('<li>'+
							'<div class="file_upload_preview ui-corner-all"><div class="ui-corner-all preview-container"></div></div>' +
							'<div class="filename"><label for="file-name">' + files[index].name + '</label>' +
								'<input class="file-name" type="hidden" name="name" value="'+files[index].name+'" />' +
							'</div>' +
							'<div class="file_upload_progress"><div></div></div>' +
							'<div class="file_upload_cancel">' +
								'<div title="'+pyro.lang.start+'" class="start-icon ui-helper-hidden-accessible"></div>'+
								'<div title="'+pyro.lang.cancel+'" class="cancel-icon"></div>' +
							'</div>' +
							'<div class="image_meta">'+
								resize+
							'</div>'+
						'</li>');
			},
			buildDownloadRow: function(results){
				if (results.message)
				{
					$(window).trigger('show-message', results);
				}
			},
			beforeSend: function(event, files, index, xhr, handler, callBack){

				if( ! handler.uploadRow ) //happens if someone trys to upload more than he's allowed to, e.g. during file replace
				{
					return;
				}

				var $progress_div = handler.uploadRow.find('.file_upload_progress'),
					regexp;

				// check if the server can handle it
				if (files[index].size > pyro.files.max_size_possible) {
					$progress_div.html(pyro.lang.exceeds_server_setting);
					return false;
				} else if (files[index].size > pyro.files.max_size_allowed) {
					$progress_div.html(pyro.lang.exceeds_allowed);
					return false;
				}

				// is it an allowed type?
				regexp = new RegExp('\\.('+pyro.files.valid_extensions+')$', 'i');
				// Using the filename extension for our test,
				// as legacy browsers don't report the mime type
				if (!regexp.test(files[index].name.toLowerCase())) {
					$progress_div.html(pyro.lang.file_type_not_allowed);
					return false;
				}

				handler.uploadRow.find('div.start-icon').on('click', function() {
					handler.formData = {
						name: handler.uploadRow.find('input.file-name').val(),
						width: handler.uploadRow.find('[name="width"]').val(),
						height: handler.uploadRow.find('[name="height"]').val(),
						ratio: handler.uploadRow.find('[name="ratio"]').is(':checked'),
						alt_attribute: handler.uploadRow.find('[name="alt_attribute"]').val(),
						folder_id: pyro.files.upload_to,
						replace_id: 'mode' in pyro.files && pyro.files.mode == 'replace' ? pyro.files.$last_r_click.attr('data-id') : 0,
						csrf_hash_name: $.cookie(pyro.csrf_cookie_name)
					};
					callBack();
				});
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

	pyro.files.new_folder = function(parent, name) {
		var new_class = Math.floor(Math.random() * 1000),
			post_data;

		if (typeof(name) === 'undefined') {
			name = pyro.lang.new_folder_name;
		}

		// add an editable one to the right pane
		$('.new-folder').clone()
			.removeClass('new-folder')
			.appendTo('.folders-center')
			.addClass('folder folder-' + new_class);


		post_data = { parent : parent, name : name };

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
					$parent_li.append('<ul style="display:block"><li class="folder" data-id="'+results.data.id+'" data-name="'+results.data.name+'"><div></div><a href="#">'+results.data.name+'</a></li></ul>');
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

		var level = pyro.files.current_level,
			folders = [],
			files = [],
			post_data,
			i = 0,
			items = [],
			content_interval,
			current;

		// let them know we're getting the stuff, it may take a second
		$(window).trigger('show-message', {message: pyro.lang.fetching});

		post_data = { parent : folder_id };
		$.post(SITE_URL + 'admin/files/folder_contents', post_data, function(data){
			var results = $.parseJSON(data);

			if (results.status) {

				// iterate over all items so we can build a cache
				$folders_center.find('li').each(function(index){
					var folder = {},
						file = {};

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
				$('.folders-center').find('li').fadeOut('fast').remove();
				$('.tipsy').remove();

				// use the folder_id from results as we know that's numeric
				folder_id = results.data.parent_id;
				delete(results.data.parent_id);

				// iterate so that we have folders first, files second
				$.each(results.data, function(type, data){
					$.each(data, function(index, item){
						item.el_type = type;
						items.push(item);
					});
				});

				// we load all items with a small delay between, if we just appended all 
				// elements at once it effectively launches a DOS attack on the server
				content_interval = window.setInterval(function(){
					if (typeof(items[i]) == 'undefined') {
						clearInterval(content_interval);

						return;
					}

					var item = items[i];
					i++;

					// if it's an image then we set the thumbnail as the content
					var li_content = '<span class="name-text">'+item.name+'</span>';
					if (item.type && item.type === 'i') {                                 /* without this the thumb doesn't update with Replace */
						li_content = '<img src="'+SITE_URL+'files/cloud_thumb/'+item.id+'?'+new Date().getMilliseconds()+'" alt="'+item.name+'"/>'+li_content;
					}

					$folders_center.append(
						'<li class="files-tooltip '+item.el_type+' '+(item.el_type === 'file' ? 'type-'+item.type : '')+'" data-id="'+item.id+'" data-name="'+item.name+'">'+
							li_content+
						'</li>'
					);

					// save all its details for other uses. The Details window for example
					$(window).data(item.el_type+'_'+item.id, item);

				}, 150);

				// Toto, we're not in Kansas anymore
				pyro.files.current_level = folder_id;

				// remove the old breadcrumbs from the title
				$('#file-breadcrumbs').find('.folder-crumb').remove();

				// grab all the data for the current folder
				current = $(window).data('folder_'+folder_id);
				var url = '';

				// build all the parent crumbs in reverse order starting with current
				while(typeof(current) !== 'undefined') {
					$('#file-breadcrumbs').find('#crumb-root').after('<span class="folder-crumb"> &nbsp;/&nbsp; <a data-id="'+current.id+'" href="#">'+current.name+'</a></span>');
					url = current.slug + '/' + url;
					current = $(window).data('folder_'+current.parent_id);
				}

				if (url.length > 0) {
					window.location.hash = '#'+url;
				}

				// show the children in the left sidebar
				$('ul#folders-sidebar [data-id="'+folder_id+'"] > ul:hidden').parent('li').children('div').trigger('click');

				// add the current indicator to the correct folder
				$('ul#folders-sidebar').find('li').removeClass('current');
				$('ul#folders-sidebar [data-id="'+folder_id+'"]').not('.places').addClass('current');

				// and we succeeded
				results.message = pyro.lang.fetch_completed;
				$(window).trigger('show-message', results);
				$(window).trigger('load-completed');

				// Show the applicable buttons.
				$('.item .folders-center').trigger('click');
			}
		});
	 };

	pyro.files.rename = function() {

		// what type of item are we renaming?
		var type = pyro.files.$last_r_click.hasClass('folder') ? 'folder' : 'file',
			$item = pyro.files.$last_r_click.find('.name-text');

		// if they have one selected already then undo it
		$('[name="rename"]').parent().html($('[name="rename"]').val());

		$item.html('<input name="rename" value="'+$item.html()+'"/>');

		$input  = $item.find('input');

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
			var item_data,
				post = { name: $input.val() };

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
				});
			}

			$('input[name="rename"]').parent().html($('input[name="rename"]').val());
		});

		// Prevent form from submitting
		// if used outside of module
		// ie: form input for streams
		$input.keydown(function(e){
			if ( e.which == '13' )
			{
				$(this).blur(); // trigger the save
				return false; //don't submit form
			}
		});
	};

	pyro.files.replace = function() {
		pyro.files.mode = 'replace';

		$(window).trigger('open-upload');
	};

	pyro.files.delete_item = function(current_level) {

		// only files can be multi-selected
		var items = $('.selected[data-id]'),

			// if there are selected items then they have to be files
			type = items.length > 0 ? 'file' : 'folder'; // end var

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

			var id = $(item).attr('data-id'),
				post_data = {};
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
					if ($folders_center.find('li').length === 0 && pyro.files.current_level === 0) {
						$('.no_data').fadeIn('fast');
					}

					$(window).trigger('show-message', results);
				}
			});
		});
	 };

	$item_details = $('div#item-details');

	pyro.files.details = function() {

		var timer, location,
			// file or folder?
			type = pyro.files.$last_r_click.hasClass('file') ? 'file' : 'folder',
			// figure out the ID from the last clicked item
			$item_id = pyro.files.$last_r_click.attr('data-id').length > 0 ? pyro.files.$last_r_click.attr('data-id') : pyro.files.current_level,
			// retrieve all the data that was stored when the item was initially loaded
			$item = $(window).data(type+'_'+$item_id),
			$select = $item_details.find('.location'); // end var

		// hide all the unused elements
		$item_details.find('li').hide();

		$item_details.find('.meta-data').hide();

		$item_details.find('.show-data > button').unbind().bind('click', function(){
			$item_details.find('.meta-data, .item-description').slideToggle();
		});

		if ($item) {
	 		if ($item.id) {				$item_details.find('.id')				.html($item.id).parent().show(); }
		 	if ($item.name) { 			$item_details.find('.name')				.html($item.name).parent().show(); }
		 	if ($item.slug) { 			$item_details.find('.slug')				.html($item.slug).parent().show(); }
		 	if ($item.path) { 			$item_details.find('.path')				.val($item.path).parent().show(); }
		 	if ($item.formatted_date) { $item_details.find('.added')			.html($item.formatted_date).parent().show(); }
		 	if ($item.width > 0) { 		$item_details.find('.width')			.html($item.width+'px').parent().show(); }
		 	if ($item.height > 0) { 	$item_details.find('.height')			.html($item.height+'px').parent().show(); }
		 	if ($item.filesize) { 		$item_details.find('.filesize')			.html(($item.filesize < 1000 ? $item.filesize+'Kb' : $item.filesize / 1000+'MB')).parent().show(); }
		 	if ($item.download_count) { $item_details.find('.download_count')	.html($item.download_count).parent().show(); }
		 	if ($item.filename) { 		$item_details.find('.filename')			.html($item.filename).parent().show(); }
		 	if (type === 'file') { 		$item_details.find('.description')		.val($item.description).parent().show(); }
		 	if (type === 'file') { 		$item_details.find('#keyword_input')	.val($item.keywords).parent().show(); }
		 	if (type === 'file') {		$item_details.find('.show-data')		.show(); }
		 	if ($item.type === 'i') {	$item_details.find('.alt_attribute')	.val($item.alt_attribute).parent().show(); }

			// they can only change the cloud provider if the folder is empty and they have permission
			if (type === 'folder' && $item.file_count === 0 && pyro.files.has_permissions('set_location') ){
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

			// needed so that Keywords can return empty JSON
			$.ajaxSetup({
				allowEmpty: true
			});

			// set up keywords
			$('#keyword_input').tagsInput({
				autocomplete_url:'admin/keywords/autocomplete'
			});

			// when the colorbox is closed kill the tag input
			$item_details.bind('cbox_closed', function(){
				$('#keyword_input_tagsinput').remove();

				// if we don't unbind it will stay bound even if we cancel
				$item_details.find('.buttons').off('click', 'button');
			});

			// show/hide the bucket/container name field on change
			$select.change(function(e){
				location = $(e.target).val();
				$item_details.find('.container').parent().hide();
				$('.'+location).parent().show();
			});

			// check if a container with that name exists
			$('.container-button').on('click', function(e){
				var post_data = {
					name :		$(this).siblings('.container').val(),
					location :	location
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
				width		: '520',
				height		: (type === 'file') ? '600' : '475',
				opacity		: 0
			});

			// save on click, then close the modal
			$item_details.find('.buttons').on('click', 'button', function() {
				if (type === 'file'){
					pyro.files.save_description($item);
				} else {
					pyro.files.save_location($item);
				}
				$.colorbox.close();
			});
		}
	};

	pyro.files.save_description = function(item) {

		var new_description = $item_details.find('textarea.description').val(),
			new_keywords = $item_details.find('#keyword_input').val(),
			new_alt_attribute = $item_details.find('input.alt_attribute').val(),
			post_data = {
				file_id : item.id,
				description : new_description,
				keywords : new_keywords,
				old_hash : item.keywords_hash,
				alt_attribute : new_alt_attribute
			}; // end var

		// only save it if it's different than the old one
		if (item.description !== new_description || item.keywords !== new_keywords || item.alt_attribute !== new_alt_attribute){

			$.post(SITE_URL + 'admin/files/save_description', post_data, function(data){

				var results = $.parseJSON(data);
				$(window).trigger('show-message', results);

				// resave it locally
				item.description = new_description;
				item.keywords = new_keywords;
				item.keywords_hash = results.data.keywords_hash;
				item.alt_attribute = new_alt_attribute;
				$(window).data('file_'+item.id, item);
			});
		}

	};

	pyro.files.save_location = function(item) {

		var new_location = $item_details.find('.location').val(),
			container = $('div#item-details .'+new_location).val(),
			post_data = {
				folder_id:	item.id,
				location:	new_location,
				container:	container
			}; // end var

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
		var folder_id = pyro.files.$last_r_click.attr('data-id'),
			post_data = { folder_id: folder_id };

		$(window).trigger('show-message', { status : null, message : pyro.lang.synchronization_started });

		$.post(SITE_URL + 'admin/files/synchronize', post_data, function(data){
			var results = $.parseJSON(data);
			$(window).trigger('show-message', results);
			if (results.status) {
				pyro.files.folder_contents(folder_id);
			}
		});

	};

	pyro.files.has_permissions = function(roles) {

		var actions = roles.split(' ');
		var max_actions = actions.length;

		for(var x = 0;x < max_actions;x++)
		{
			if( $.inArray(actions[x], pyro.files.permissions) === -1 )
			{
				return false;
			}
		}

		return true;
	}

	/***************************************************************************
	 * And off we go... load the desired folder                                *
	 ***************************************************************************/
	if ($('.folders-center').find('.no_data').length === 0) {
		if (window.location.hash) {
			pyro.files.folder_contents(window.location.hash);
		} else {
			// deprecated
			pyro.files.folder_contents(pyro.files.initial_folder_contents);
		}
	}
});
