(function($) {
	$(function(){

		// When adding / removing a column from the view
		$(document).on('change', 'input.show-column', function(){

			// Get started
			var columns = new Array();

			// If it's checked - we want it
			if ($(this).is(':checked'))
			{
				// If it's not in our desired columns.. remove it from sorting too
				$(this).closest('.modal-body').find('.dd.column-order').append('<li class="dd-item" data-column="' + $(this).data('column') + '"><div class="dd-handle">' + $(this).closest('label').text() + '</div><input type="hidden" name="' + $(this).closest('.modal-body').data('stream') + '-column[]" value="' + $(this).data('column') + '"/></li>');
			}
			else
			{
				// If it's not in our sorting - add it
				$(this).closest('.modal-body').find('li.dd-item[data-column^="' + $(this).data('column') + '"]').remove();
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
			$(this).closest('.modal-body').find('.stream-columns-input').val(columns.join('|'));

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

	});
})(jQuery);