jQuery(function ($) {

	pyro.addons_widgets = {

		init: function () {
			$('#widgets-list').find('tbody').livequery(function () {
				$(this).sortable({
					handle: 'span.move-handle',
					stop: function () {
						var $table_body = $('#widgets-list').find('tbody');
						$table_body.children('tr').removeClass('alt');
						$table_body.children('tr:nth-child(even)').addClass('alt');

						var order = [];

						$table_body.children('tr').find('input[name="action_to[]"]').each(function () {
							order.push(this.value);
						});

						order = order.join(',');

						$.post(SITE_URL + 'addons/ajax/widget_update_order/widget', { order: order });
					}
				});
			});

		}
	};

	pyro.addons_widgets.init();

});