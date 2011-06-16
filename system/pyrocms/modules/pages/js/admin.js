(function($) {
		
	$(function() {
		
		// add another page chunk
		$('.add-page-chunk').live('click', function(e){
			e.preventDefault();
			$('#page-content ul li:last').before('<li class="page-chunk">' +
				'<input type="text" name="chunk_slug[]"/>' +
				'<select name="chunk_type[]" class="no-uniform">' +
				'<option value="html">html</option>' +
				'<option value="wysiwyg-simple">wysiwyg-simple</option>' +
				'<option selected="selected" value="wysiwyg-advanced">wysiwyg-advanced</option>' +
				'</select>' +
				'<textarea class="wysiwyg-simple" rows="50" cols="90" name="chunk_body[]"></textarea>' +
			'</li>');
			
			// initialize the editor using the view from fragments/wysiwyg.php
			pyro.init_ckeditor();
		});
	});
  
})(jQuery);