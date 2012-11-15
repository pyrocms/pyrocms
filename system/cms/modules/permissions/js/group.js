(function ($) {
	$(function () {

		$('.select-row').change(function (e) {
			$(e.target)
				.parents('tr')
				.find('input[type=checkbox].select-rule')
				.attr('checked', e.target.checked);
		});

		// This adjusts the state of the checkbox in the first column
		var _check_disable_first_checkbox = function(el) {
			
			var enabled = 0,
				$this = $(el),
				$row_checkbox = $this.parents('tr').find('input[type=checkbox].select-row');

			// Get a list of the enabled rule checkboxes
			$this.parents('td').find('input[type=checkbox].select-rule').each(function(index, ele) {
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
		$('input[type=checkbox].select-rule').change( function(e) {
			_check_disable_first_checkbox(e.target);
		});
		
		// On DOM ready
		$('input.select-rule').each(function(i,v) {
			_check_disable_first_checkbox(this);
		});
		
		// On form submission
		$('form#edit-permissions').on('submit', function(e){
			// We need to remove the disabled state for every checkbox,
			// it will not go through to the POST.
			$('input[type=checkbox]').each(function() {
				if (this.disabled === true) {
					this.disabled = false;
				}
			})
		});
	});
})(jQuery);