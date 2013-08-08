(function ($) {
	$(function () {

		$('.js-perm-module').change(function (e) {
			$(e.target)
				.parents('tr')
				.find('input[type=checkbox].js-perm-role')
				.attr('checked', e.target.checked);
		});

		// This adjusts the state of the checkbox in the first column
		var _check_disable_first_checkbox = function(el) {
			
			var enabled = 0,
				$this = $(el),
				$row_checkbox = $this.parents('tr').find('input[type=checkbox].js-perm-module');

			// Get a list of the enabled role checkboxes
			$this.parents('td').find('input[type=checkbox].js-perm-module').each(function(index, ele) {
				if(ele.checked) {
					enabled++;
				}
			});
			
			// If there is none selected
			if(enabled === 0) {
				// Don't disable nor check the first column checkbox
				$row_checkbox.attr({disabled: false});
			}
			// If there is at least one
			else if (enabled >= 1) {
				// Disable and check the first column checkbox
				$row_checkbox.attr({checked: true, disabled: true});
			}
		};
		
		// On rule checkbox click
		$('input[type=checkbox].js-perm-role').change( function(e) {
			_check_disable_first_checkbox(e.target);
		});
		
		// On DOM ready
		$('input.js-perm-role').each(function(i,v) {
			_check_disable_first_checkbox(this);
		});

	});
})(jQuery);