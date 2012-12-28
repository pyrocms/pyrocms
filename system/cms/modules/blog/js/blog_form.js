(function ($) {
	$(function () {

		// generate a slug when the user types a title in
		pyro.generate_slug('#blog-content-tab input[name="title"]', 'input[name="slug"]');

		// needed so that Keywords can return empty JSON
		$.ajaxSetup({
			allowEmpty: true
		});

		$('#keywords').tagsInput({
			autocomplete_url: 'admin/keywords/autocomplete'
		});

		// editor switcher
		$('select[name^=type]').live('change', function () {
			var chunk = $(this).closest('li.editor'),
					textarea = $('textarea', chunk),
					newType = this.value,
					oldType = textarea.attr('class'),
					editor = textarea.data('editor');
					
			// clear text area classes and add the new one
			textarea.attr('class',this.value);
			// Destroy old instance
			if (oldType == 'wysiwyg-simple' || oldType == 'wysiwyg-advanced') {
				var instance = CKEDITOR.instances[textarea.attr('id')];
				instance && instance.destroy();
			}
			if(editor !== undefined){
				editor.save();
				$('.CodeMirror').remove();
				textarea.data('editor',undefined);
			}
			// create new ones
			if (newType == 'wysiwyg-simple' || newType == 'wysiwyg-advanced') {
				pyro.init_ckeditor();
			}
			if(newType == 'html'){
				textarea.data('editor', pyro.createCodeMirror(textarea, 'text/html'));
			}
			if(newType == 'markdown'){
				textarea.data('editor', pyro.createCodeMirror(textarea, 'markdown'));
			}
		});

		$('#new-category').colorbox({
			srollable: false,
			innerWidth: 600,
			innerHeight: 280,
			href: SITE_URL + 'admin/blog/categories/create_ajax',
			onComplete: function () {
				$.colorbox.resize();

				var $form_categories = $('form#categories');
				pyro.generate_slug('#categories input[name="title"]', 'input[name="slug"]');
				$form_categories.removeAttr('action');
				$form_categories.live('submit', function (e) {

					var form_data = $(this).serialize();

					$.ajax({
						url: SITE_URL + 'admin/blog/categories/create_ajax',
						type: "POST",
						data: form_data,
						success: function (obj) {

							if (obj.status == 'ok') {

								//succesfull db insert do this stuff
								var $select = $('select[name=category_id]');
								//append to dropdown the new option
								$select.append('<option value="' + obj.category_id + '" selected="selected">' + obj.title + '</option>');
								$select.trigger("liszt:updated");
								//close the colorbox
								$.colorbox.close();
							} else {
								//no dice

								//append the message to the dom
								var $cboxLoadedContent = $(document.getElementById('cboxLoadedContent'));
								$cboxLoadedContent.html(obj.message + obj.form);
								$cboxLoadedContent.find('p').first().addClass('notification error').show();
							}
						}
					});
					e.preventDefault();
				});

			}
		});
	});
})(jQuery);