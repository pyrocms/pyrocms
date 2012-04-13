// Only do anything if jQuery isn't defined
if (typeof jQuery == 'undefined') {
	function getScript(url, success) {

		var script = document.createElement('script'),
			head = document.getElementsByTagName('head')[0],
			done = false;

		script.src = url;
		// Attach handlers for all browsers
		script.onload = script.onreadystatechange = function() {
			if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) {
				done = true;
				// callback function provided as param
				if (typeof success == 'function') success();
				script.onload = script.onreadystatechange = null;
				head.removeChild(script);
			}
		};
		head.appendChild(script);
	};

	getScript('http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', function() {

		if (typeof jQuery=='undefined') {
			// Super failsafe - still somehow failed...
		} else {

		}

	});

} else {
	// Run your jQuery Code
};
