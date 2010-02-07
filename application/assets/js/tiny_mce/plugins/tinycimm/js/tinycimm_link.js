/**
* tinycimm_image.js
* @author badsyntax.co.uk & pyrocms
*/

function LinkDialog(){}
LinkDialog.prototype = new TinyCIMM('link');
LinkDialog.prototype.constructor = LinkDialog;

LinkDialog.prototype.preInit = function() {
	var images = ['../img/ajax-loader.gif', '../img/ajax-loader-sm.gif', '../img/progress.gif'];
	this.cacheImages(images);
	this.settings.tinycimm_controller = this.settings.tinycimm_link_controller;
};

LinkDialog.prototype.fileBrowser = function(folder, offset, load, el, search_query){
	var self = this;

	this.getBrowser(folder, offset, search_query, function(){

		// show the first level list
		tinyMCEPopup.dom.select('#link_wrapper_panel ul')[0].style.display = 'block';
			
		// bind click event to anchors
		var pages = tinyMCEPopup.dom.select('#link_wrapper_panel ul a');
		for(var page in pages) {
			pages[page].onclick = function(e){
				e.preventDefault();
				var url = "{page_url("+this.rel.replace(/^page-/, '')+")}";
				self.insertLink(url, this.title);
			};
		}
	
		// bind click event to hit areas	
		var hitareas = tinyMCEPopup.dom.select('#link_wrapper_panel ul .hitarea');
		for(var i in hitareas) {
			hitareas[i].onclick = function(e){
				if (/hitarea-closed/.test(this.className)) {
					this.parentNode.getElementsByTagName('ul')[0].style.display = "block";
					this.className = this.className.replace(/hitarea-closed/, 'hitarea-open');
				} else if (/hitarea-open/.test(this.className)) {
					this.parentNode.getElementsByTagName('ul')[0].style.display = "none";
					this.className = this.className.replace(/hitarea-open/, 'hitarea-closed');
				}
			};
		}
	});
};

LinkDialog.prototype.insertLink = function(url, title){
	var win = tinyMCEPopup.getWindowArg("window");
        // insert the url into the link dialog window
	 if (win) {
		win.document.getElementById('href').value = url;
		win.document.getElementById('title').value = title;
		tinyMCEPopup.close();
	}
};

var TinyCIMMLink = new LinkDialog();
TinyCIMMLink.preInit();
tinyMCEPopup.onInit.add(TinyCIMMLink.init, TinyCIMMLink);
