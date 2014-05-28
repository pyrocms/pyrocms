(function ($) {
	$(function () {

		$('a#category-shortcut').colorbox({
			srollable: false,
			innerWidth: 600,
			innerHeight: 280,
			href: SITE_URL + 'admin/blog/categories/create_ajax',
			onComplete: function () {
				$.colorbox.resize();
                pyro.generate_slug('#cboxLoadedContent input[name="title"]', '#cboxLoadedContent input[name="slug"]');
                
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
								var $select = $('#category select');
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