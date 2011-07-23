// Cufon
if (typeof(Cufon) !== 'undefined')
{
	Cufon.replace('header h1', {
		textShadow: '2px 1px 0px #000000'
	});
	Cufon.replace('.post h1, .post h2, .post h3, .post h4, .post h5, .post h6, aside h1, aside h2, aside h3, aside h4, aside h5, aside h6', {
		textShadow: '1px 1px 0px #ffffff'
	});

	$(function(){
		// rtl cufon hack
		if ($('html').attr('dir') === 'rtl') // todo: select by attr dir value rtl -> find cufon -> foreach results...
		{
			var cache = {};
			$('cufon').each(function(){
				var self	= $(this),
					container = self.parent(),

					ltr_str	= container.text(),
					rtl_str	= ltr_str.split('').reverse().join(''),

					// http://www.i18nguy.com/temp/rtl.html
					// http://www.regularexpressions.info/unicode.html#block
					// match (non) Arabic, Hebrew
					regex = RegExp(/[^\u0600-\u06FF\u0590-\u05FF]+/g),
					no_rtl_str = ltr_str.match(regex),
					rv_ltr_str = rtl_str.match(regex);

				if (ltr_str in cache) return;

				cache[ltr_str] = rtl_str; // todo: change cache .. container context

				if ((no_rtl_str && rv_ltr_str) && (no_rtl_str.length == rv_ltr_str.length))
				{
					for (i = 0; i < no_rtl_str.length; i++)
					{
						rtl_str = rtl_str.replace(rv_ltr_str[i], '<bdo dir="ltr">' + no_rtl_str[i] + '</bdo>');
					}
				}

				if (ltr_str !== rtl_str)
				{

					container.html(rtl_str);

					Cufon.refresh();

					$('> cufon', container).each(function(){
						var canvas = $('canvas', this);
						canvas.css({
							left	: canvas.css('right'),
							right	: canvas.css('left')
						});
					});
				}
			});
		}
	});
}

$(function($){

	// Scroll
	$.localScroll();

	// Link Nudge
	$('#navigation li a').nudge();
});

jQuery.fn.nudge = function(params) {
	//set default parameters
	params = jQuery.extend({
		amount: 15,				//amount of pixels to pad / marginize
		duration: 300,			//amount of milliseconds to take
		property: 'padding', 	//the property to animate (could also use margin)
		direction: 'left',		//direction to animate (could also use right)
		toCallback: function() {},	//function to execute when MO animation completes
		fromCallback: function() {}	//function to execute when MOut animation completes
	}, params);
	//For every element meant to nudge...
	this.each(function() {
		//variables
		var jQueryt = jQuery(this);
		var jQueryp = params;
		var dir = jQueryp.direction;
		var prop = jQueryp.property + dir.substring(0,1).toUpperCase() + dir.substring(1,dir.length);
		var initialValue = jQueryt.css(prop);
		/* fx */
		var go = {};
		go[prop] = parseInt(jQueryp.amount) + parseInt(initialValue);
		var bk = {};
		bk[prop] = initialValue;

		//Proceed to nudge on hover
		jQueryt.hover(function() {
			jQueryt.stop().animate(go, jQueryp.duration, '', jQueryp.toCallback);
		}, function() {
			jQueryt.stop().animate(bk, jQueryp.duration, '', jQueryp.fromCallback);
		});
	});
	return this;
};