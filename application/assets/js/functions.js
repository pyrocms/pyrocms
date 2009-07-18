/* Global functions for use around the place */
function modal_confirm(message, callback) {
	$('#confirm').modal({
		close:false,
		position: ["20%",],
		overlayId:'confirmModalOverlay',
		containerId:'confirmModalContainer', 
		onShow: function (dialog) {
			dialog.data.find('.confirm-message').append(message);

			// if the user clicks "yes"
			dialog.data.find('.yes').click(function () {
				// call the callback
				if ($.isFunction(callback)) {
					callback.apply();
				}
				// close the dialog
				$.modal.close();
			});
		}
	});
}