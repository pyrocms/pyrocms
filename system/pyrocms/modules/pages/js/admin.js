(function($) {
		
	$(function() {
		
		// add another page chunk
		$('.add-page-chunk').live('click', function(e){
			e.preventDefault();
			$('#page-content ul li:last').before('<li class="page-chunk">' +
					'<input type="text" name="chunk_slug[]"/>' +
					'<input type="text" name="chunk_type[]"/>' +
					'<textarea class="wysiwyg-simple" rows="50" cols="90" name="chunk_body[]"></textarea>' +
				'</li>');
			
			// initialize the editor using the view from fragments/wysiwyg.php
			pyro.init_ckeditor();
		});
	});
  
})(jQuery);