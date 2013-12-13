<script type="text/javascript">

	$(document).ready(function() {

		// Trigger em all
		$('select.selectize-relationship').each(function() {

			var input = $(this);
			var options = input.attr('data-options') == 'null' ? null : $.parseJSON(input.attr('data-options'));

			input.selectize({
				maxItems: input.attr('data-max_selections'),
				valueField: input.attr('data-value_field'),
				labelField: input.attr('data-label_field'),
				searchField: input.attr('data-search_field'),

				options: options,

				create: false,
				render: {
					/*item: function(item, escape) {
						return '<div>' +
							(item.name ? '<span class="name">' + escape(item.name) + '</span>' : '') +
							(item.email ? '<span class="email">' + escape(item.email) + '</span>' : '') +
						'</div>';
					},*/
					option: function(item, escape) {
						return '<div>' + item[input.attr('data-label_field')] + '</div>';
					}
				},
				load: function(query, callback) {
					if (!query.length) return callback();
					
					input.parent('div').find('.selectize-control').addClass('loading');

					$.ajax({
						url: SITE_URL + 'streams_core/public_ajax/field/relationship/search/' + input.attr('data-stream_namespace') + '/' + input.attr('data-stream_param') + '/' + input.attr('data-field_slug') + '?query=' + encodeURIComponent(query),
						type: 'GET',
						error: function() {
							callback();
						},
						success: function(results) {
							callback(results.entries);
						}
					});
				}
			});

			// Set the value
			if (options) {
				input[0].selectize.setValue(input.attr('data-value'));
			}

			// Add our loader
			input.parent('div').find('.selectize-control').append('<?php echo Asset::img('loaders/808080.png', null, array('class' => 'animated spin spinner')); ?>');
		});
	});
</script>