/*
 * jQuery throttle / debounce - v1.1 - 3/7/2010
 * http://benalman.com/projects/jquery-throttle-debounce-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function(b,c){var $=b.jQuery||b.Cowboy||(b.Cowboy={}),a;$.throttle=a=function(e,f,j,i){var h,d=0;if(typeof f!=="boolean"){i=j;j=f;f=c}function g(){var o=this,m=+new Date()-d,n=arguments;function l(){d=+new Date();j.apply(o,n)}function k(){h=c}if(i&&!h){l()}h&&clearTimeout(h);if(i===c&&m>e){l()}else{if(f!==true){h=setTimeout(i?k:l,i===c?e-m:e)}}}if($.guid){g.guid=j.guid=j.guid||$.guid++}return g};$.debounce=function(d,e,f){return f===c?a(d,e,false):a(d,f,e!==false)}})(this);

(function($) {
	$(function(){

		form = $('form.crud');
		
		$('input[name="title"]', form).keyup($.debounce(300, function(){
		
			slug = $('input[name="slug"]', form);
			
			if(slug.val() == 'home' || slug.val() == '404')
			{
				return;
			}
			
			$.post(BASE_URI + 'index.php/ajax/url_title', { title : $(this).val() }, function(new_slug){
				slug.val( new_slug );
			});
		}));
		
		//compare revisions
		$('#btn_compare_revisions').click(function() {
			//first revision
			first = $('#compare_revision_1').val();
			second = $('#compare_revision_2').val();
			
			$.colorbox({
				width: "85%",
				height: "85%",
				href: BASE_URI + 'index.php/admin/pages/compare/' + first + '/' + second
			});
		});
		
		//view revision
		$('#btn_preview_revision').click(function() {
			revision = $('#use_revision_id').val();
			
			$.colorbox({
				width: "85%",
				height: "85%",
				href: BASE_URI + 'index.php/admin/pages/preview_revision/' + revision
			})
		});
		
	});
})(jQuery);
