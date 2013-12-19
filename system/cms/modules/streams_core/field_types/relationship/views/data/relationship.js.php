<script type="text/javascript">

	
	// Ready
	$(document).ready(function() {

		var $select = $(this);
		
		$select.selectize({

			// Relationship is 1 to 1
			maxItems: 1,

			// Let's always use this..
			valueField: 'id',

			// What is the default label field?
			// Note that label_format will override this
			labelField: '<?php echo $field_type->getParameter('label_field', ($field_type->stream->title_column ? $field_type->stream->title_column : 'id')); ?>',

			// Search these
			// This is JS - it will limit the dropdown despite what's passed back w/JSON
			// We want to pass it all back though for formatting if applicable
			searchField: '<?php echo str_replace('|', "','", $field_type->getParameter('search_fields', ($field_type->stream->title_column ? $field_type->stream->title_column : 'id'))); ?>',

			// The value as an entry
			<?php if ($entry): ?>
			options: <?php echo $entry; ?>,
			<?php endif; ?>

			// Don't allow creation of new shiz
			create: false,

			/**
			 * Customize how shit is rendered
			 * @type {object}
			 */
			render: {

				/**
				 * This defines how a selectable item is formatted
				 * @param  {object} item
				 * @param  {[type]} escape
				 * @return {string}
				 */
				/*item: function(item, escape) {
					return '<div>' +
						(item.name ? '<span class="name">' + escape(item.name) + '</span>' : '') +
						(item.email ? '<span class="email">' + escape(item.email) + '</span>' : '') +
					'</div>';
				},*/

				/**
				 * This defines how the selected option is formatted
				 * @param  {object} item
				 * @param  {[type]} escape
				 * @return {string}
				 */
				option: function(item, escape) {
					return '<div class="b-g-c-red">' + item['<?php echo $field_type->getParameter('label_field', ($field_type->stream->title_column ? $field_type->stream->title_column : 'id')); ?>'] + '</div>';
				}
			},

			/**
			 * Load from our AJAX public feed
			 * @param  {object}   query
			 * @param  {function} callback
			 * @return {mixed}
			 */
			load: function(query, callback) {

				// If the query is less than 3 chars - skip it
				// this will help reduce server load ya'll
				if (query.length < 3) return callback();
				
				// We're loading..
				$select.parent('div').find('.selectize-control').addClass('loading');

				// Search!
				$.ajax({

					// Keep this public so we can use this on the front end
					url: SITE_URL + 'streams_core/public_ajax/field/relationship/search/<?php echo $field_type->form_slug; ?>?query=' + encodeURIComponent(query),

					// Might as well..
					type: 'POST',

					// Error
					error: function() {
						callback(); // Don't do shit
					},

					// Sucksess
					success: function(results) {

						// Return our entries array for formatting.. or maybe not
						callback(results.entries);
					},
				});
			}
		});

		// Set the value
		<?php if ($entry): ?>
		//$select[0].selectize.setValue($select.attr('data-value'));
		<?php endif; ?>

		// Inject our loader
		$select.parent('div').find('.selectize-control').append('<?php echo Asset::img('loaders/808080.png', null, array('class' => 'animated spin spinner')); ?>');

	});


</script>