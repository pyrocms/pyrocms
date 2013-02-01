(function ($) {
	$(function () {

		// generate a slug when the user types a title in
		pyro.generate_slug('#blog-content-tab input[name="title"]', '#blog-content-tab input[name="slug"]');

		// needed so that Keywords can return empty JSON
		$.ajaxSetup({
			allowEmpty: true
		});

		$('#keywords').tagsInput({
			autocomplete_url: SITE_URL + 'admin/keywords/autocomplete'
		});

		// editor switcher
		$('select[name^=type]').live('change', function () {
			var chunk = $(this).closest('li.editor');
			var textarea = $('textarea', chunk);

			// Destroy existing WYSIWYG instance
			if (textarea.hasClass('wysiwyg-simple') || textarea.hasClass('wysiwyg-advanced')) {
				textarea.removeClass('wysiwyg-simple');
				textarea.removeClass('wysiwyg-advanced');

				var instance = CKEDITOR.instances[textarea.attr('id')];
				instance && instance.destroy();
			}
			// Set up the new instance
			textarea.addClass(this.value);
			pyro.init_ckeditor();
		});

		$(document.getElementById('blog-options-tab')).find('ul').find('li').first().find('a').colorbox({
			srollable: false,
			innerWidth: 600,
			innerHeight: 280,
			href: SITE_URL + 'admin/blog/categories/create_ajax',
			onComplete: function () {
				$.colorbox.resize();
				var $form_categories = $('form#categories');
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
								// TODO work this out? //uniform workaround
								$(document.getElementById('blog-options-tab')).find('li').first().find('span').html(obj.title);

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