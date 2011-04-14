// Cufon
if (typeof(Cufon) !== 'undefined')
{
	Cufon.replace('#header h1', {
		textShadow: '2px 1px 0px #000000'
	});
	Cufon.replace('.post h1, .post h2, .post h3, .post h4, .post h5, .post h6 #sidebar h1, #sidebar h2, #sidebar h3, #sidebar h4, #sidebar h5, #sidebar h6', {
		textShadow: '1px 1px 0px #ffffff'
	});

	$(function(){
		// rtl cufon hack
		if ($('html').attr('dir') === 'rtl')
		{
			$('cufon').each(function(){
				var self	= $(this),
					ltr_str	= self.attr('alt'),
					rtl_str	= ltr_str.split('').reverse().join(''),
					no_rtl_str = ltr_str.match(/[\w]+/g),
					rv_ltr_str = rtl_str.match(/[\w]+/g);
	
				if ((no_rtl_str && rv_ltr_str) && (no_rtl_str.length == rv_ltr_str.length))
				{
					for (i = 0; i < no_rtl_str.length; i++)
					{
						rtl_str = rtl_str.replace(rv_ltr_str[i], no_rtl_str[i]);
					}
				}
	
				if (ltr_str !== rtl_str)
				{
					self.addClass('rtl-hack');
				}
	
				self.attr('alt', rtl_str)
					.find('cufontext').text(rtl_str);
			});
	
			Cufon.refresh();
	
			$('cufon.rtl-hack canvas').each(function(){
				var self	= $(this),
					rtl_pos	= {left: self.css('right'), right: self.css('left')};
				self.css(rtl_pos);
			});
		}
	});
}

$(function($){

	// Scroll
	$.localScroll();

	// Link Nudge
	$('#sidebar #navigation li a').nudge();
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