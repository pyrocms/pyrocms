jQuery(function($){

	// open a right click menu on items and the main area
	$('.item li, .item .one_half').bind('contextmenu', function(e){
		e.preventDefault();
		$('.context-menu-source').fadeIn('fast');
		// jquery UI position the context menu by the mouse
		$('.context-menu-source').position({
			my:			"left top",
			at:			"left bottom",
			of:			e,
			collision:	"fit"
		});
	});

	// grab the value from the clicked menu item
	$('[data-menu]').click(function(e){
		var menu = $(this).attr('data-menu');

		switch (menu){
			case 'upload':
				console.log(menu);
			break;
		}
	});

	// select folders; including use of control key
	$('.folders-right [data-slug]').click(function(e){
		e.stopPropagation();
		var selected = $('.folders-right').find('.selected').length > 0;
		if ( ! e.ctrlKey && ! e.shiftKey) {
			if(selected) {
				$('[data-slug]').removeClass('selected');
			}
		}
		$(this).toggleClass('selected');
	});

	// if they click in the main area reset selected items or hide the context menu
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
				order.push( $(this).attr('data-slug') );
			});
			order = order.join(',');

			$.post(SITE_URL + 'admin/files/order_folders', { order: order });
		}

	});

	/***************************************************************************
	 * Files uploading section                                                 *
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
				pyro.add_notification(response.message, {
					clear: false
				});
			}
			if (response.status == 'success')
			{
				return $('<li><div>' + response.file.name + '</div></li>');
			}
			return;
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