/*
 *
 * tinycimm_media.js
 * Copyright (c) 2009 Richard Willis
 * MIT license  : http://www.opensource.org/licenses/mit-license.php
 * Project      : http://tinycimm.googlecode.com/
 * Contact      : willis.rh@gmail.com : http://badsyntax.co.uk
 *
 */

function MediaDialog(){}
MediaDialog.prototype = new TinyCIMM('media');
MediaDialog.prototype.constructor = MediaDialog;

MediaDialog.prototype.preInit = function() {
	var images = ['../img/ajax-loader.gif', '../img/ajax-loader-sm.gif', '../img/progress.gif'];
	this.cacheImages(images);
}

MediaDialog.prototype.getImage = function(imageid, callback) {
	this.get(imageid, callback);
};

MediaDialog.prototype.fileBrowser = function(folder, offset, load, el, search_query){
	if (!load) {return;}
	search_query = search_query || '';
	if (typeof el == 'object') {
		tinyMCE.activeEditor.dom.select('img', el)[0].src = 'img/ajax-loader.gif';
	}
	this.getBrowser(folder, offset, search_query);
}

MediaDialog.prototype.loadUploader = function() {
	if (!tinyMCEPopup.dom.get('upload_target_ajax').src) {
		tinyMCEPopup.dom.get('upload_target_ajax').src = this.baseURL(this.settings.tinycimm_controller+'media/get_uploader_form');
	}
	// refresh the select drop down 
	this.loadSelect(0, 'media');
	tinyMCEPopup.resizeToInnerSize();
};

var TinyCIMMMedia = new MediaDialog();
TinyCIMMMedia.preInit();
tinyMCEPopup.onInit.add(TinyCIMMMedia.init, TinyCIMMMedia);
