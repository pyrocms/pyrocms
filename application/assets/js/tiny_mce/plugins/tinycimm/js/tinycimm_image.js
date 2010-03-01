/**
* tinycimm_image.js
* @author badsyntax.co.uk & pyrocms
*/

function ImageDialog(){}
ImageDialog.prototype = new TinyCIMM('image');
ImageDialog.prototype.constructor = ImageDialog;

ImageDialog.prototype.preInit = function() {
	this.cacheImages(['../img/ajax-loader.gif', '../img/ajax-loader-sm.gif', '../img/progress.gif']);
	this.settings.tinycimm_controller = this.settings.tinycimm_image_controller;
};

ImageDialog.prototype.getImage = function(imageid, callback) {
	this.get(imageid, callback);
};

ImageDialog.prototype.downloadImage = function(imageid) {
	window.parent.location = this.settings.tinycimm_controller+'get/'+imageid+'/0/0/0/0/1';
};

ImageDialog.prototype.fileBrowser = function(folder, offset, load, el, search_query){
	search_query = search_query || '';
	if (!load) {
		return;
	}
	if (typeof el == 'object') {
		tinyMCE.activeEditor.dom.select('img', el)[0].src = 'img/ajax-loader.gif';
	}

	this.getBrowser(folder, offset, search_query, function(){
			
		function mouseover(){
			var self = this;

			tinyMCE.activeEditor.dom.addClass(this, 'show');
			tinyMCE.activeEditor.dom.addClass(this, 'thumb-wrapper-over');

			// expandos are fine ;)
			this.over = true;
			this.timer = setTimeout(function(){
				tinyMCE.activeEditor.dom.addClass(self, 'show-controls');
			}, 100);
		}

		function mouseout(){
			var self = this;

			tinyMCE.activeEditor.dom.removeClass(this, 'show');
			tinyMCE.activeEditor.dom.removeClass(this, 'thumb-wrapper-over');
			tinyMCE.activeEditor.dom.addClass(this, 'thumb-wrapper');

			this.over = false;
			(this.timer) && clearTimeout(this.timer);
			
			// hovering over the controls causes mouseout
			// so the following takes cares of that
			setTimeout(function(){
				(!self.over) && tinyMCE.activeEditor.dom.removeClass(self, 'show-controls');
			});
		}

		// bind hover event to thumbnail
		var thumbs = tinyMCEPopup.dom.select('.thumb-wrapper');
		for(var image in thumbs) {
			thumbs[image].onmouseover = mouseover;
			thumbs[image].onmouseout = mouseout;
		}
	});
};

// inserts an image into the editor iframe
ImageDialog.prototype.insertAndClose = function(image, width, height) {
	var ed = tinyMCEPopup.editor, el = ed.selection.getNode(),
	args = {
		src : image.filename,
		alt : image.description,
		width : width,
		height : height
	};
	tinyMCEPopup.restoreSelection();

	// Fixes crash in Safari
	(tinymce.isWebKit) && ed.getWin().focus();

	if (el && el.nodeName == 'IMG') {
		// update the selected image
		ed.dom.setAttribs(el, args);
	} else {
		// insert a new image
		ed.execCommand('mceInsertContent', false, '<img id="__mce_tmp" />', {skip_undo : 1});
		ed.dom.setAttribs('__mce_tmp', args);
		ed.dom.setAttrib('__mce_tmp', 'id', '');
		ed.undoManager.add();
	}

	tinyMCEPopup.close();
};
	
ImageDialog.prototype.insertImage = function(thumbspan, image, width, height) {
	var win = tinyMCEPopup.getWindowArg("window"), url = image.filename;

	// insert the image into the image dialog window
	if (win) {
		// set the image URL and description fields
		win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = url;
		win.document.getElementById('alt').value = image.description;

		// update the image dialog window
		if (win.ImageDialog) {
			(win.ImageDialog.getImageData) && (win.ImageDialog.getImageData());
			(win.ImageDialog.showPreviewImage) && (win.ImageDialog.showPreviewImage(url));

		}
 		tinyMCEPopup.close();
	} else {
		// insert the image into the editor iframe
		this.insertAndClose(image, width, height);
	}
	return;
};

ImageDialog.prototype.insertResizeImage = function(){
	var self = this, 
	image_id = select('#slider_img').src.toId(), 
	width = select('#slider_width_val').innerHTML, 
	height = select('#slider_height_val').innerHTML.replace(/px$/, '');
	
	this.resizeImage(image_id, width, height, function(image){
		self.insertImage(null, image, width, height);
	});
};

ImageDialog.prototype.resizeImage = function(imageId, width, height, callback){
	var self, url = this.baseURL(this.settings.tinycimm_controller+'save_image_size/'+imageId+'/'+width+'/'+height+'/90/0');
	tinymce.util.XHR.send({
		url : url,
		error : function(response) {
			tinyMCEPopup.editor.windowManager.alert(self.lang.msg_xhr_error_general+".");
		},
		success : function(response) {
			var image = tinymce.util.JSON.parse(response);
			if (!image.outcome) {
				tinyMCEPopup.editor.windowManager.alert(image.message); 
			} else { 
				(callback) && callback(image);
			}
		}
	});
};

ImageDialog.prototype.insertThumbnail = function(anchor, imageId){
	var self = this, ed = tinyMCEPopup.editor, 
	el = ed.selection.getNode(),
	width = this.settings.tinycimm_thumb_width, 
	height = this.settings.tinycimm_thumb_height,
	url = this.baseURL(this.settings.tinycimm_controller+'save_image_size/'+imageId+'/'+width+'/'+height+'/90/0');

	// show spinner image
	if (typeof anchor == 'object' && anchor.nodeName == 'A') {
		anchor.style.background = 'url(img/ajax-loader-sm.gif) no-repeat center center';
	}

	this.resizeImage(imageId.toId(), width, height, function(image){
		// if an advimage dialog window is already open
		var origWin = tinyMCEPopup.getWindowArg("tinyMCEPopup");
		(origWin) && origWin.close();

		tinyMCEPopup.restoreSelection();

		// fixes crash in Safari
		(tinymce.isWebKit) && ed.getWin().focus();

		// if a thumbnail is selected then remove the thumb anchor
		var anchor_parent = ed.dom.getParent(ed.selection.getNode(), 'A');
		(anchor_parent) && tinyMCEPopup.dom.remove(anchor_parent);

		// image attributes
		var args = {
			src : self.baseURL(image.filename),
			alt : image.description,
			width : image.width,
			height : image.height,
			title : image.description
		};

		// replace/insert the image thumbnail with anchor
		ed.execCommand('mceInsertContent', false, 
			'<a class="'+self.settings.tinycimm_thumb_lightbox_class+'" '
			+'rel="'+self.settings.tinycimm_thumb_lightbox_gallery+'" '
			+'href="'+self.baseURL(self.settings.tinycimm_assets_path+image.id+image.extension)+'">'
			+'<img id="__mce_tmp" /></a>', {skip_undo : 1}
		);
		ed.dom.setAttribs('__mce_tmp', args);
		ed.dom.setAttrib('__mce_tmp', 'id', '');
		ed.undoManager.add();
		tinyMCEPopup.close();
	});
};

ImageDialog.prototype.showUploader = function(){
	mcTabs.displayTab('upload_tab','upload_panel');
	select('#resize_tab').style.display = 'none';
	select('#manager_tab').style.display = 'none';
	this.loadUploader();
};

ImageDialog.prototype.loadUploader = function() {
	var self = this;
	// load the uploader form
	if (!select('#uploadform').length) {
		this.getUploader(function(html){
			select('#upload_panel').innerHTML = html;
			select('#fileupload').multiFileUpload();
			select('#uploadform').onsubmit = function(e){
				self.showOverlay();
			};
			// refresh the select drop down 
			self.getFoldersSelect();
		});
	} else {
		document.forms.uploadform.reset();
		// refresh the select drop down 
		self.getFoldersSelect();
	}
	tinyMCEPopup.resizeToInnerSize();
};
	
// pre-cache resizer image before initiating the resizer
ImageDialog.prototype.loadResizer = function(filename, event) {
	// remove the resizer image from the dom : issue 12 http://code.google.com/p/tinycimm/issues/detail?id=12
	tinyMCEPopup.dom.remove('slider_img');

	var img = new Image(), self = this;
	img.onload = function(){
		self.showResizeImage(this);
	};
	img.onerror = function(){
		tinyMCEPopup.editor.windowManager.alert(self.lang.msg_error_imageload+".");
	};
	img.src = this.settings.tinycimm_assets_path+filename;
	if (!img.complete) {
		// show loading text if image not already cached
		mcTabs.displayTab('resize_tab','resize_panel');
		tinyMCEPopup.dom.setHTML('image-info-dimensions', '<span id="loading"> caching image..</span>');
	}
};
	
// show resizer image
ImageDialog.prototype.showResizeImage = function(image) {
	var
	image_width = image.width,
	image_height = image.height, 
	sliderVal = image_width < this.settings.tinycimm_resize_default_intial_width ? image_width : this.settings.tinycimm_resize_default_intial_width;

	image.setAttribute('id', 'slider_img');
	select('#image-info').appendChild(image);
		
	// display panel
	mcTabs.displayTab('resize_tab','resize_panel');
	select('#resize_tab').style.display = "block";
	select('#manager_tab').style.display = "none";

	// add image dimensions overlay
	tinyMCEPopup.dom.setHTML('image-info-dimensions', '<span id="slider_width_val"></span> x <span id="slider_height_val"></span>');
			
	new ScrollSlider(select('#image-slider'), {
		min : 0,
		max : image_width,
		value : sliderVal,
		size : 400,
		scroll : function(new_w) {
			var 
			slider_width = select('#slider_width_val'), 
			slider_height = select('#slider_height_val');

			if (slider_width && slider_height) {
				slider_width.innerHTML = (image.width = new_w);
				slider_height.innerHTML = (image.height = Math.round((parseInt(new_w)/parseInt(image_width))*image_height))+'px';
			}
		}
	});
};

ImageDialog.prototype.showManager = function(anchor, image_id) {
	var self = this;
	// show spinner image
	if (anchor && typeof anchor == 'object' && anchor.nodeName == 'A') {
		anchor.style.background = 'url(img/ajax-loader-sm.gif) no-repeat center center';
	}

	tinyMCEPopup.dom.setHTML('manager_panel', '');
	this.getManager(image_id, function(html){
		// display panel
		mcTabs.displayTab('manager_tab','manager_panel');
		select('#resize_tab').style.display = "none";
		select('#manager_tab').style.display = "block";
		// hide spinner image
		if (anchor && typeof anchor == 'object' && anchor.nodeName == 'A') {
			anchor.style.background = 'url(img/pencil_sm.png) no-repeat center center';
		}
		tinyMCEPopup.dom.setHTML('manager_panel', html);
		//  bind action events
		select('#update-image').onclick = function(e){
			self.updateAsset(
				image_id, 
				select('#folderselect').options[select('#folderselect').selectedIndex].value.toString(),
				select('#image-alttext').value.trim(),
				select('#image-filename').value.trim()
			);
			return false;
		};
		select('#manager-actions').onchange = function(e){
			switch(this.value) {
				case 'delete' : self.deleteImage(image_id); this.value=''; break;
				case 'insert' :  self.getImage(image_id, function(image){ self.loadResizer(image.id+image.extension); }); this.value=''; break;
				case 'download' : self.downloadImage(image_id); this.value=''; break;
			} 
		};
		select('#image-filename').onfocus = function(e){
			this.extension = this.value.extension();
			this.value = this.value.replace(new RegExp('\.'+this.extension+'$'), '');
		};
		select('#image-filename').onblur = function(e){
			this.value += '.'+this.extension;
		};

		// ensure the peview image is cached before showing the details
		var previewImg = new Image(), onload = function(){
			select('#loading').style.display = "none";
			select('#image-manager-details').style.display = "block";
		};
		previewImg.onload = onload;
		previewImg.onerror = onload;
		previewImg.src = select('#image-preview').src;

		// the image is cached before binding click event so that we can get
		// desired width and height of popup window based on image dimensions
		var previewImgLarge = new Image(), onload = function(){
			var img = this;
			select('#image-preview-popup').onclick = function(){
				tinyMCE.activeEditor.windowManager.open({
					url: self.settings.tinycimm_controller+'get/'+image_id+'/600/600',
					inline: true,
					width: img.width+18,
					height: img.height+18
				});
				return false;
			};	
		};
		previewImgLarge.onload = onload;
		previewImgLarge.onerror = onload;
		previewImgLarge.src = self.settings.tinycimm_controller+'get/'+image_id+'/600/600';
	});
}

// file successfully uploaded callback function
ImageDialog.prototype.assetUploaded = function(folder_id) {
	this.recache = true;
	var remove = [];
	// remove multiple file upload junk
	var divs = document.forms.uploadform.getElementsByTagName('div');
	for(var i=0;i<divs.length;i++) {
		(divs[i].className == 'fileuploadinput') && remove.push(divs[i]);
	}
	for(var i=0;i<remove.length;i++) {
		remove[i].parentNode.removeChild(remove[i]);
	}
	this.showBrowser(folder_id);
	this.showFlashMsg(this.lang.msg_uploaded_images+".");
}
	
ImageDialog.prototype.deleteImage = function(imageid) {
	this.deleteAsset(imageid);
};	

var TinyCIMMImage = new ImageDialog();
TinyCIMMImage.preInit();
tinyMCEPopup.onInit.add(TinyCIMMImage.init, TinyCIMMImage);
