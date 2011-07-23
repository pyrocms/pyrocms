jQuery(function($){
	// General -----------------------------------------------------

	// Apply sexy style to input fields with uniform
	$('select, textarea, input[type=text], input[type=file], input[type=submit]')
		.livequery(function(){
			$(this).not('.no-uniform').uniform().addClass('no-uniform');
	});

	// Folder ------------------------------------------------------

	$('.cancel.close-cbox').livequery('click', function(){
		$.colorbox.close();
	});

	$('.delete.confirmation').livequery(function(){
		var self	= $(this),
			form	= self.parents('form'),
			url		= form.attr('action'),
			data	= '';

		self.click(function(e){
			e.preventDefault();

			data = 'btnAction=delete&' + form.serialize();

			$.post(url, data, function(data){
				if (data.status == 'success')
				{
					var callback_adjust_and_close = function(){
						$.colorbox.resize();
						$(window).hashchange();
						$.colorbox.close();
					};

					pyro.add_notification(data.message, {ref: '#cboxLoadedContent', method: 'prepend'}, callback_adjust_and_close);

				}
				else if (data.status == 'error')
				{
					pyro.add_notification(data.message, {ref: '#cboxLoadedContent', method: 'prepend'}, $.colorbox.resize);
				}
			}, 'json');
		});
	});

	// delete confirm
	$('.delete.confirm', '#folders_list').livequery(function(){
		var self	= $(this).removeClass('confirm'),
			form	= self.parents('form'),
			url		= self.is('a') ? self.attr('href') : form.attr('action'),
			data	= '';

		self.click(function(e){
			e.preventDefault();

			self.is('button') && (data = 'btnAction=delete&' + form.serialize());

			$.post(url, data, function(data){
				if (data.status == 'success')
				{
					self.colorbox({
						open	: true,
						html	: data.html,
						width	: 600,
						maxHeight	: '90%',
						onComplete: function(){
							$.colorbox.resize();
						}
					});
					return;
				}

				pyro.add_notification(data.html);
			}, 'json');
		});
	});

	// Create and Edit folder
	$('.folder-create, .folder-edit').livequery(function(){
		var self = $(this),
			self_action = self.is('.edit') ? 'edit' : 'create';

		self.colorbox({
			scrolling	: false,
			width		:'600',
			height		:'400',
			onComplete	: function(){

				var form = $('form#folders_crud'),
					$loading = $('#cboxLoadingOverlay, #cboxLoadingGraphic'),
					btn_action;

				$.colorbox.resize();

				form.find(':submit').click(function(e){
					btn_action = $(this).val();
				});

				form.find('input[name=name]').bind('keyup blur', $.debounce(300, function(){
					if ($(this).val().length > 0)
					{
						var $title		= $(this),
							$slug		= $('input[name=slug]', $title.parents('form')),
							title		= $title.val(),
							cache		= $title.data('cache_slug') || $title.data('cache_slug', {});

						if (cache[title])
						{
							$slug.val(cache[title]);
						}
						else
						{
							$.post(SITE_URL + 'ajax/url_title', { title: title }, function(slug){
								$slug.val(slug);

								cache[title] = slug;
								$title.data('cache_slug', cache);
							});
						}
					}
				})).focus();

				form.find(':input:last').keypress(function(e){
					if (e.keyCode == 9 && ! e.shiftKey)
					{
						e.preventDefault();
						form.find(':input:first').focus();
					}
				});

				form.find(':input:first').keypress(function(e){
					if (e.keyCode == 9 && e.shiftKey)
					{
						e.preventDefault();
						form.find(':input:last').focus();
					}
				});

				form.submit(function(e){

					e.preventDefault();

					form.parent().fadeOut(function(){

						$loading.show();

						pyro.clear_notifications();

						$.post(form.attr('action'), form.serialize(), function(data){
							// Prepare the html notification


							// Update title
							data.title && $('#cboxLoadedContent h3:eq(0)').text(data.title);

							$('#folders-dropdown').load(SITE_URL + 'admin/files/folders/html_dropdown', function(html){
								$(this).html(html);
							});

							if (data.status == 'success')
							{
								$(window).hashchange();

								if (self_action == 'create')
								{
									// Clear form
									form.get(0).reset();
								}

								// Close the colorbox
								if (self_action == 'edit' || btn_action == 'save_exit')
								{
								// TODO: If self_action is edit: Create a countdown with an option to cancel before close
									setTimeout(function(){
										$.colorbox.close();
									}, 1800);
								}
							}

							$loading.hide();

							form.parent().fadeIn(function(){

								// Show notification & resize colorbox
								pyro.add_notification(data.message, {ref: '#cboxLoadedContent', method: 'prepend'}, $.colorbox.resize);

							});

						}, 'json');

					});
				});					
			},
			onClosed :function(){
			}
		});
	});

	// Bind an event to window.onhashchange that, when the hash changes, gets the
	// hash and adds reload contents
	$(window).hashchange(function(){
		var hash = location.hash.substr(2),
			uri,
			path = '';

		if (hash.match('path='))
		{
			uri = (hash == '' || ( ! (path = hash.match(/path=(.+?)(&.*|)$/)) && ! (hash = ''))) ? 'index' : 'contents/';
		}
		else
		{
			uri		= 'index';
			hash	= 'path=';
			path	= null;

			$('#shortcuts li.files-uploader').addClass('hidden');
		}

		$.get(SITE_URL + 'admin/files/folders/' + uri, hash, function(data){

			if (data.status == 'success')
			{
				data.navigation && $('#files-browser-nav').html(data.navigation);
				data.content && $('#files-browser-contents').html(data.content);

				$('#shortcuts li.files-uploader')[(path ? 'remove' : 'add') + 'Class']('hidden');
			}
			else if (data.status == 'error')
			{
				$('#shortcuts li.files-uploader').addClass('hidden');
				parent.location.hash = null;
				pyro.add_notification(data.message);
			}

		}, 'json');
	});

	// Since the event is only triggered when the hash changes, we need to trigger
	// the event now, to handle the hash the page may have loaded with.
	$(window).hashchange();

	// Updating folders by anchors
	$('a.folder-hash').livequery(function(){

		var anchor;

		$(this).click(function(e){

			e.preventDefault();

			anchor = $(this);

			parent.location.hash = '!path=' + anchor.attr('data-path');

		}).each(function(){

			anchor = $(this);
			anchor
				.data('href', anchor.attr('href'))
				.attr('href', '#!path=' + anchor.attr('data-path'));

		});

	});

	// Updating file folder/sub-folder and filter type
	$('select.folder-hash').livequery('change', $.debounce(300, function(){
		parent.location.hash = '!path=' + $('select#folder_path').val() + '&filter=' + $('select#filter').val();
	}));

	// Files -------------------------------------------------------

	$(".edit_file").livequery(function(){
		$(this).colorbox({
			scrolling	: false,
			width		: '600',
			height		: '480',
			onComplete: function(){
				var form = $('form#files_crud'),
					$loading = $('#cboxLoadingOverlay, #cboxLoadingGraphic');

				$.colorbox.resize();

				form.find(':input:last').keypress(function(e){
					if (e.keyCode == 9 && ! e.shiftKey)
					{
						e.preventDefault();
						form.find(':input:first').focus();
					}
				});

				form.find(':input:first').keypress(function(e){
					if (e.keyCode == 9 && e.shiftKey)
					{
						e.preventDefault();
						form.find(':input:last').focus();
					}
				});

				form.submit(function(e){

					e.preventDefault();

					form.parent().fadeOut(function(){

						$loading.show();

						pyro.clear_notifications();

						$.post(form.attr('action'), form.serialize(), function(data){

							// Update title
							data.title && $('#cboxLoadedContent h2:eq(0)').text(data.title);

							if (data.status == 'success')
							{
								$(window).hashchange();

								// TODO: Create a countdown with an option to cancel before close
								setTimeout(function(){
									$.colorbox.close();
								}, 1800);
							}

							$loading.hide();

							form.parent().fadeIn(function(){

								// Show notification & resize colorbox
								pyro.add_notification(data.message, {ref: '#cboxLoadedContent', method: 'prepend'}, $.colorbox.resize);

							});

						}, 'json');

					});
				});
			},
			onClosed: function(){}
		});
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
				$(window).hashchange();
			}
		});
	});

	var upload_form = $('#files-uploader form'),
		upload_vars	= upload_form.data('fileUpload');

	upload_form.fileUploadUI({
		fieldName		: 'userfile',
		uploadTable		: $('#files-uploader-queue'),
		downloadTable	: $('#files-uploader-queue'),
		previewSelector	: '.file_upload_preview div',
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
		buildDownloadRow: function(data){
			if (data.status == 'success')
			{
				return $('<li><div>' + data.file.name + '</div></li>');
			}
			return false;
		},
		beforeSend: function(event, files, index, xhr, handler, callBack){
			handler.uploadRow.find('button.start').click(function(){
				handler.formData = {
					name: handler.uploadRow.find('input.file-name').val(),
					folder_id: $('input[name=folder_id]', '#files-toolbar').val()
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

	$('a[rel="colorbox"]').livequery(function(){
		$(this).colorbox({
			maxWidth	: '80%',
			maxHeight	: '80%'
		});
	});

	$('#grid').livequery(function(){
		if ($.cookie('file_view') != 'grid')
		{
			$('#grid').hide();
		}
		else
		{
			$('#list').hide();
			$('#grid').fadeIn();
			$('a.active-view').removeClass('active-view');
			$("a[title='grid']").addClass('active-view');
		}
	});

	$('a.toggle-view').livequery('click', function(e){
		e.preventDefault();

		var view = $(this).attr('title');

		// remember the user's preference
		$.cookie('file_view', view);

		$('a.active-view').removeClass('active-view');
		$(this).addClass('active-view');

		if (view == 'grid')
		{
			hide_view = 'list';
		}
		else
		{
			hide_view = 'grid';
		}

		$('#'+hide_view).fadeOut(50, function() {
			$('#'+view).fadeIn(500);   
		});            
	});
});