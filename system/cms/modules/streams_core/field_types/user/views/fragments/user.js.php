<script type="text/javascript">

	$(document).ready(function() {

		var selectize = $('#<?php echo $form_slug; ?>');

		selectize.selectize({
			maxItems: <?php echo $max_selections; ?>,
			valueField: 'id',
			labelField: 'username',
			searchField: 'username',
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
					return '<div>' + item.username + '</div>';
				}
			},
			load: function(query, callback) {
				if (!query.length) return callback();
				$.ajax({
					url: SITE_URL + 'streams_core/public_ajax/field/user/search/<?php echo $stream_namespace; ?>/<?php echo $field_slug; ?>?query=' + encodeURIComponent(query),
					type: 'GET',
					error: function() {
						callback();
					},
					success: function(results) {
						callback(results.users);
					}
				});
			}
		});
	});
</script>