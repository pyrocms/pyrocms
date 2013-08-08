(function($) {
	$(function(){

		// When adding / removing a column from the view
		$('input.show-column').on('change', function(){

			// Get started
			var columns = new Array();

			// If it's checked - we want it
			if ($(this).is(':checked'))
			{
				// If it's not in our desired columns.. remove it from sorting too
				$(this).closest('form').find('.dd.column-order').append('<li class="dd-item" data-column="' + $(this).data('column') + '"><div class="dd-handle">' + $(this).closest('label').text() + '</div><input type="hidden" name="column[]" value="' + $(this).data('column') + '"/></li>');
			}
			else
			{
				// If it's not in our sorting - add it
				$(this).closest('form').find('li.dd-item[data-column^="' + $(this).data('column') + '"]').remove();
			}

			// No need to change the value - the below snippet will do that when the list "changes"
			$('.dd.column-order').trigger('change');
		});


		// Make the columns sortable
		$('.dd.column-order').nestable({maxDepth: 0});
		$('.dd.column-order').on('change', function() {

			// Ready..
			var columns = new Array();

			$('.dd li:not(.empty)').each(function(){

				// Load er up
				columns.push($(this).data('column'));

			});

			// Update the value
			$(this).closest('form').find('.stream-columns-input').val(columns.join('|'));

			// Show / hide the empty li
			if (columns.length > 0)
			{
				$('.dd li.empty').hide();
			}
			else
			{
				$('.dd li.empty').show();
			}
		});


		// Listen for adding filter
		$('.advanced-filters').on('click', 'a.add-advanced-filter', function(){

			// Filter on!
			$(this).closest('.advanced-filters').find('input.filtering-flag').attr('name', 'filter-' + $(this).closest('.advanced-filters').data('stream-slug'));
			
			// Clone an empty row
			$(this).closest('.view-form').find('table.blank-row tr').clone().appendTo($(this).closest('table'));

			return false;
		});


		// Listen for removing filter
		$('.advanced-filters').on('click', 'a.remove-advanced-filter', function(){

			// Filter on or off?
			if ($(this).closest('table').find('tr').length == 2)
			{
				// We're removing our last filter - no more filtering
				$(this).closest('.advanced-filters').find('input.filtering-flag').removeAttr('name');
			}
			

			// Clone an empty row
			$(this).closest('tr').remove();

			return false;
		});


		// Listen for selecting a filter field
		$('.advanced-filters').on('change', 'select.streams-field-filter-on', function(){

			// Get the filter input
			$(this).closest('tr').find('td.streams-field-filter-input').html($(this).closest('.view-form').find('.streams-' + $(this).val() + '-filter-data .input').clone().html());

			// Get the filter conditions
			$(this).closest('tr').find('td.streams-field-filter-conditions').html($(this).closest('.view-form').find('.streams-' + $(this).val() + '-filter-data .conditions').clone().html());
		});

	});
})(jQuery);
