(function($) {
	$(function(){

		// Listen for adding filter
		$('.advanced-filters').on('click', 'a.add-advanced-filter', function(){

			// Filter on!
			$(this).closest('.advanced-filters').find('input.filtering-flag').attr('name', 'filter-' + $(this).closest('.advanced-filters').data('stream-slug'));

			// Clone an empty row
			$(this).closest('.filters-wrapper').find('table.blank-row tr').clone().appendTo($(this).closest('table'));

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
			$(this).closest('tr').find('td.streams-field-filter-input').html($(this).closest('.filters-wrapper').find('.streams-' + $(this).val() + '-filter-data .input').clone().html());

			// Get the filter conditions
			$(this).closest('tr').find('td.streams-field-filter-conditions').html($(this).closest('.filters-wrapper').find('.streams-' + $(this).val() + '-filter-data .conditions').clone().html());
		});

	});
})(jQuery);