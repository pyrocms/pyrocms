(function($) {
	$(function(){

		// Make the fields sortable
		$('.form-editor-wrapper .tab-pane.dd').nestable({maxDepth: 0});

		// And when they change
		$('.form-editor-wrapper .tab-pane.dd').on('change', function(){

			// Columns
			var columns = new Array();

			// Get the fields and their order
			$(this).find('li').each(function(){
				columns.push($(this).data('field'));
			});

			$.post(
				SITE_URL + 'streams_core/ajax/update_tab_assignments_order',
				{
					columns: columns,
					stream_id: $(this).closest('.form-editor-wrapper').data('stream'),
					form_id: $(this).closest('.form-editor-wrapper').data('form'),
					tab_id: $(this).data('tab'),
				}
			);
		});



		// Make tabs sortable
		$('.form-editor-wrapper .sortable.nav.nav-tabs').sortable({
			onDrop: function ($item, container, _super) {

				// Default
				$item.removeClass("dragged").removeAttr("style")
				$("body").removeClass("dragging")
				// /Default

				// Columns
				var tabs = new Array();

				// Get the order
				$item.closest('.sortable.nav.nav-tabs').find('li').each(function(){
					if($(this).data('tab') != undefined) tabs.push($(this).data('tab'));
				});

				$.post(
					SITE_URL + 'streams_core/ajax/update_tabs_order',
					{
						tabs: tabs,
					}
				);	
			}
		});
	});
})(jQuery);
