<script type="text/javascript">

	$(document).ready(function() {

		var selectize = $('#<?php echo $form_slug; ?>');

		selectize.selectize({
			maxItems: 1,
			valueField: '<?php echo $value_field; ?>',
			labelField: '<?php echo $label_field; ?>',
			searchField: '<?php echo $search_field; ?>',
			options: [],
			create: false,
			render: {
				/*item: function(item, escape) {
					return '<div>' +
						(item.name ? '<span class="name">' + escape(item.name) + '</span>' : '') +
						(item.email ? '<span class="email">' + escape(item.email) + '</span>' : '') +
					'</div>';
				},*/
				option: function(item, escape) {
					return '<div>' + item.<?php echo $label_field; ?> + '</div>';
				}
			},
			load: function(query, callback) {
				if (!query.length) return callback();
				
				$('#<?php echo $form_slug; ?>').parent('div').find('.selectize-control').addClass('loading');

				$.ajax({
					url: SITE_URL + 'streams_core/public_ajax/field/relationship/search/<?php echo $stream_namespace; ?>/<?php echo $stream_param; ?>/<?php echo $field_slug; ?>?query=' + encodeURIComponent(query),
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

		// Add our loader
		$('#<?php echo $form_slug; ?>').parent('div').find('.selectize-control').append('<?php echo Asset::img('loaders/808080.png', null, array('class' => 'animated spin spinner')); ?>');
	});
</script>