(function($)
{
	$(function() {
		
		// Widget Area add / remove --------------
		
		$('a#add-area').click(function(){
			$('div#add-area-box').slideDown('slow');
			return false;
		});
		
		$('div#add-area-box form').submit(function(){

			title = $('input[name="title"]', this);
			slug = $('input[name="slug"]', this);
			
			if(!title.val() || !slug.val()) return false;
			
			$.post(BASE_URI + 'widgets/ajax/add_widget_area', {
				area_title: title.val(), area_slug: slug.val()
			}, function(data) {
				$('div#mid-col').append(data).children('div.box:hidden').slideDown();
				
				title.val('');
				slug.val('');
				
				$('div#add-area-box').slideUp();
			});
			
			return false;
		});

		$('a.delete-area').live('click', function(){
			
			// all div.box have an id="area-slug"
			box = $('div#' + this.id.replace('delete-', ''));
			console.debug(box);
			box.slideUp();
			
			return false;
		});
		
		// Widget controls -----------------------
		
		$("#available-widgets li").draggable({
			revert: 'invalid',
			cursor: 'move',
			helper: 'clone'
		});
		
		$(".widget-area").droppable({
			drop: function(event, ui) {
				alert('dropped!');
			}
		});

	});


})(jQuery);