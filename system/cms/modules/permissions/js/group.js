(function ($) {
	$(function () {
		$('.select-row').change(function () {
			if( this.checked ){
				$(this).parent().siblings('td').eq(1).find('input[type=checkbox]').click();
			}
		});
	});
})(jQuery);