
jQuery.fn.slug = function(options) {
	var settings = {
		slug: 'slug', // Class used for slug destination input and span. The span is created on $(document).ready()
		hide: true	 // Boolean - By default the slug input field is hidden, set to false to show the input field and hide the span.
	};

	if(options) {
		jQuery.extend(settings, options);
	}

	$this = jQuery(this);

	jQuery(document).ready( function() {
		if (settings.hide) {
			jQuery('input.' + settings.slug).after("<span class="+settings.slug+"></span>");
			jQuery('input.' + settings.slug).hide();
		}
	});

	makeSlug = function() {
			var slugcontent = jQuery.trim($this.val());
			var slugcontent_hyphens = slugcontent.replace(/\s/g,'-');
			var finishedslug = slugcontent_hyphens.replace(/[^a-zA-Z0-9\-]/g,'-');
			finishedslug = finishedslug.replace(/(^[-])|([-]$)/g,'');
			jQuery('input.' + settings.slug).val(finishedslug.toLowerCase());
			jQuery('span.' + settings.slug).text(finishedslug.toLowerCase());

		}

	jQuery(this).keyup(makeSlug);

	return $this;
};
