<script type="text/javascript">

	
	// Ready
	$(document).ready(function() {

		// Trigger em all
		$('select.relationship-field-type').each(function() {

			var $select = $(this);
			
			//var options = $select.attr('data-options') == 'null' ? null : $.parseJSON($select.attr('data-options'));

			$select.selectize({
				maxItems: 1,
				valueField: 'id',
				labelField: '<?php echo $field_type->getParameter('label_field', ($field_type->stream->title_column ? $field_type->stream->title_column : 'id')); ?>',
				searchField: ['<?php str_replace('|', "','", $field_type->getParameter('search_fields', ($field_type->stream->title_column ? $field_type->stream->title_column : 'id'))); ?>'],

				options: <?php echo $entry; ?>,

				// Don't allow creation of new shiz
				create: false,

				// Render customization
				render: {
					/*item: function(item, escape) {
						return '<div>' +
							(item.name ? '<span class="name">' + escape(item.name) + '</span>' : '') +
							(item.email ? '<span class="email">' + escape(item.email) + '</span>' : '') +
						'</div>';
					},*/
					option: function(item, escape) {
						return '<div class="b-g-c-red">' + item['<?php echo $field_type->getParameter('label_field', ($field_type->stream->title_column ? $field_type->stream->title_column : 'id')); ?>'] + '</div>';
					}
				},
				load: function(query, callback) {
					if (!query.length) return callback();
					
					$select.parent('div').find('.selectize-control').addClass('loading');

					$.ajax({
						url: SITE_URL + 'streams_core/public_ajax/field/relationship/search/' + $select.attr('data-stream_namespace') + '/' + $select.attr('data-stream_param') + '/' + $select.attr('data-field_slug') + '?query=' + encodeURIComponent(query),
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
				$select[0].selectize.setValue($select.attr('data-value'));
			}

			// Add our loader
			$select.parent('div').find('.selectize-control').append('<?php echo Asset::img('loaders/808080.png', null, array('class' => 'animated spin spinner')); ?>');
		});

	});


</script>