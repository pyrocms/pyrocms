/*
 *
 * tinycimm_file.js
 * Copyright (c) 2009 Richard Willis
 * MIT license  : http://www.opensource.org/licenses/mit-license.php
 * Project      : http://tinycimm.googlecode.com/
 * Contact      : willis.rh@gmail.com : http://badsyntax.co.uk
 *
 */

function FileDialog(){}
FileDialog.prototype = new TinyCIMM('file');
FileDialog.prototype.constructor = FileDialog;

FileDialog.prototype.preInit = function() {
	var images = ['../img/ajax-loader.gif', '../img/ajax-loader-sm.gif', '../img/progress.gif'];
	this.cacheImages(images);
}

FileDialog.prototype.getImage = function(imageid, callback) {
	this.get(imageid, callback);
};

FileDialog.prototype.fileBrowser = function(folder, offset, load, el, search_query){
	if (!load) {return;}
	search_query = search_query || '';
	if (typeof el == 'object') {
		tinyMCE.activeEditor.dom.select('img', el)[0].src = 'img/ajax-loader.gif';
	}
	this.getBrowser(folder, offset, search_query);
}

var TinyCIMMFile = new FileDialog();
TinyCIMMFile.preInit();
tinyMCEPopup.onInit.add(TinyCIMMFile.init, TinyCIMMFile);
