/**
* tinycimm_image.js
* @author badsyntax.co.uk & pyrocms
*/

function TinyCIMM(type){
	this.type = type || null;
	this.recache = false;
	this.settings = tinyMCEPopup.editor.settings;
	this.lang = this.getLang();
}

TinyCIMM.prototype.getLang = function(){
	var lang = {};
	//messy, fixme
	for(var key in tinymce.EditorManager.i18n) {
		if (/tinycimm/.test(key)) {
			lang[key.replace(/^.*?tinycimm\.tinycimm_dialog_(.*)$/, "$1")] = tinymce.EditorManager.i18n[key];
		}
	}
	return lang;
};

TinyCIMM.prototype.init = function(ed){
	var self = this, node = ed.selection.getNode();
	this.getDialogBody(function(response){
		select('#body').html(response);
		if (tinyMCEPopup.params.resize) {
			self.loadResizer(node.src.toId()+'.'+node.src.extension(), false, node.width);
		} else {
			self.showBrowser(0, 0, true);
		}
	});
};

TinyCIMM.prototype.baseURL = function(url) {
	return tinyMCEPopup.editor.documentBaseURI.toAbsolute(url);
};

TinyCIMM.prototype.cacheImages = function(images){
	for(var img in images){
		new Image().src = images[img];
	}
};

TinyCIMM.prototype.get = function(asset_id, callback){
	var self = this;
	tinymce.util.XHR.send({
		url : this.baseURL(this.settings.tinycimm_controller+'get_'+this.type+'/'+asset_id),
		type : "GET",
		error : function(response) {
			tinyMCEPopup.editor.windowManager.alert(self.lang.msg_xhr_error_asset+".");
			return false;
		},
		success : function(response) {
			var obj = tinymce.util.JSON.parse(response);
			if (!obj.outcome) {
				tinyMCEPopup.editor.windowManager.alert(obj.message);
			} else {
				(callback) && callback(obj);
			}
		}
	});
};

TinyCIMM.prototype.getDialogBody = function(callback){
	var self = this;
	tinymce.util.XHR.send({
		url : this.baseURL(this.settings.tinycimm_controller+'get_dialog_body'),
		type : "GET",
		error : function(response){ 
			tinyMCEPopup.editor.windowManager.alert(self.lang.msg_xhr_error_dialog+".");
			return false;
		},
		success : function(response){
			(callback) && callback(response);
		}
	});
};

TinyCIMM.prototype.showBrowser = function(folder, offset, load, el) {
	folder = folder || 0;
	offset = offset || 0;
	el = el || false;

	if (window.TinyCIMMImage && TinyCIMMImage.recache) {
		load = true;
		TinyCIMMImage.recache = false;
	} else {
		load = select('#filelist') ? (load || false) : true;
	}

	mcTabs.displayTab('browser_tab','browser_panel');

	// fix me
	if (window.TinyCIMMImage && select('#resize_tab').length) {
		select('#resize_tab').style.display = 'none';
		select('#manager_tab').style.display = 'none';
	}

	(load) && (this.fileBrowser) && this.fileBrowser(folder, offset, load, el);
};

TinyCIMM.prototype.showUploader = function() {
	mcTabs.displayTab('upload_tab','upload_panel');
	select('#manager_tab').style.display = 'none';

	(this.loadUploader) && this.loadUploader();
};

// load list of folders and files via json request
TinyCIMM.prototype.getBrowser = function(folder, offset, search_query, callback) {
	var self = this;
	folder = folder || 0;
	offset = offset || 0;
	search_query = search_query || '';

	if (!select('#img-'+folder)) {
		tinyMCEPopup.dom.setHTML('filebrowser', '<span id="loading">loading</span>');
	}
	(this.type) && tinymce.util.XHR.send({
		url : this.baseURL(this.settings.tinycimm_controller+'get_browser/'+folder+'/'+offset+'/'+search_query),
		type : "GET",
		error : function(reponse) {
			tinyMCEPopup.editor.windowManager.alert(self.lang.msg_xhr_error_assets+".");
		},
		success : function(response) {
			if (!document) return;
			// insert the html
			tinyMCEPopup.dom.setHTML('filebrowser', response);
			// bind click event to pagination links
			var pagination_anchors = tinyMCEPopup.dom.select('div.pagination a');
			for(var anchor in pagination_anchors) {
				pagination_anchors[anchor].onclick = function(e){
					e.preventDefault();
					self.fileBrowser(folder, this.href.toId().toString(), true, false);
				};
			}
			(callback) && callback();
		}
	});
};

TinyCIMM.prototype.getManager = function(asset_id, callback) {
	asset_id = asset_id || 0;
	var self = this;
	tinymce.util.XHR.send({
		url : this.baseURL(this.settings.tinycimm_controller+'get_manager/'+asset_id),
		type : "GET",
		error : function(reponse) {
			tinyMCEPopup.editor.windowManager.alert(self.lang.msg_xhr_error_assets+".");
		},
		success : function(data) {
			(callback) && callback(data);
		}
	});

};

TinyCIMM.prototype.getUploader = function(callback) {
	var self = this;
	tinymce.util.XHR.send({
		url : this.baseURL(this.settings.tinycimm_controller+'get_uploader_form'),
		type : "GET",
		error : function(reponse) {
			tinyMCEPopup.editor.windowManager.alert(self.lang.msg_xhr_error_assets+".");
		},
		success : function(data) {
			(callback) && callback(data);
		}
	});

};

TinyCIMM.prototype.insert = function(asset_id) {
	var self = this;
	this.get(asset_id, function(asset){
		self.insertAndClose(asset);
	});
};
	
TinyCIMM.prototype.deleteAsset = function(asset_id, callback) {
	var self = this;
	tinyMCEPopup.editor.windowManager.confirm(self.lang.msg_question_delete+' '+this.type+'?', function(s) {
		if (!s) {return false;}
		tinymce.util.XHR.send({
			url : self.baseURL(self.settings.tinycimm_controller+'delete_'+self.type+'/'+asset_id),
			type : "GET",
			error : function(response) {
				tinyMCEPopup.editor.windowManager.alert(self.lang.msg_xhr_error_general+".");
			},
			success : function(response) {
				var obj = tinymce.util.JSON.parse(response);
				if (!obj.outcome) {
					tinyMCEPopup.editor.windowManager.alert('Error: '+obj.message);
				} else {
					self.showBrowser(obj.folder, 0, true);
					self.showFlashMsg(obj.message);
				}
			}
		});
	});
};

TinyCIMM.prototype.updateAsset = function(asset_id, folder_id, description, filename) {
	var self = this;
	tinymce.util.XHR.send({
		url : self.baseURL(self.settings.tinycimm_controller+'update_asset/'+asset_id),
 		content_type : 'application/x-www-form-urlencoded',
		type : "POST",
		data : 	'folder_id='+folder_id+'&description='+description+'&filename='+filename,
		error : function(response) {
			tinyMCEPopup.editor.windowManager.alert(self.lang.msg_xhr_error_general+".");
		},
		success : function(response) {
			if (response) {	
				var obj = tinymce.util.JSON.parse(response);
				self.showFlashMsg(obj.message);
			}
		}
	});
};

TinyCIMM.prototype.saveFolder = function(folder_id, folder_name, callback) {
	var self = this;
	tinymce.util.XHR.send({
		url : self.baseURL(self.settings.tinycimm_controller+'save_folder/'+folder_id),
 		content_type : 'application/x-www-form-urlencoded',
		type : "POST",
		data : 	'folder_name='+folder_name,
		error : function(response) {
			tinyMCEPopup.editor.windowManager.alert(self.lang.msg_xhr_error_general+".");
		},
		success : function(response) {
			var obj = tinymce.util.JSON.parse(response);
			if (!obj.outcome) {
				tinyMCEPopup.editor.windowManager.alert('Error: '+obj.message);
			} else {
				(callback) && (callback(obj));
			}
		}
	});
};

TinyCIMM.prototype.addFolder = function(type) {
	type = type || 'image';
	var self = this, 
	foldername = encodeURIComponent(select('#add-folder-caption').value.replace(/^\s+|\s+$/g, '')),
	requesturl = this.baseURL(this.settings.tinycimm_controller+'save_folder/'+foldername+'/'+type);

	this.saveFolder(0, foldername, function(response){
		if (response.outcome) {
			select('#add-folder').style.display = 'none';
			select('#add-folder-caption').value = '';
			self.showFlashMsg(self.lang.msg_folder_saved+"!");
			self.getFoldersHTML(function(folderHTML){
				tinyMCEPopup.dom.setHTML('folderlist', folderHTML)
			});
		}
	});
};

TinyCIMM.prototype.editFolder = function(folder_id){
	var self = this;
	select('#folder-'+folder_id).editInPlace(function(input_value){
		self.saveFolder(folder_id, input_value, function(){
			self.showFlashMsg(self.lang.msg_folder_saved+"!");
			self.getFoldersHTML(function(folderHTML){
				tinyMCEPopup.dom.setHTML('folderlist', folderHTML)
			});
		});
	});
};

TinyCIMM.prototype.deleteFolder = function(folder_id) {
	var self = this;
	tinyMCEPopup.editor.windowManager.confirm(self.lang.msg_question_delete_folder+'?', function(s){
		if (!s) { return false; }
		var requesturl = self.baseURL(self.settings.tinycimm_controller+'delete_folder/'+folder_id);
		tinymce.util.XHR.send({
			url : requesturl,
			type : "GET",
			error : function(response) {
	 			tinyMCEPopup.editor.windowManager.alert(self.lang.msg_xhr_error_general+".");
			},
			success : function(response) {
	 			var obj = tinymce.util.JSON.parse(response);
				if (!obj.outcome) {
					tinyMCEPopup.editor.windowManager.alert('Error: '+obj.message);
	 			} else {
					self.showBrowser(0, 0, true);
					self.showFlashMsg(self.lang.msg_folder_deleted+"!");
	 			}
			}
		});
	});
};			

TinyCIMM.prototype.getFoldersSelect = function(folder, type) {
	folder = folder || 0;
	type = type || 'image';
	var self = this;
	tinymce.util.XHR.send({
		url : this.baseURL(this.settings.tinycimm_controller+'get_folders/select/'+folder),
		type : "GET",
		error : function(text) {
			tinyMCEPopup.editor.windowManager.alert(self.lang.msg_xhr_error_selectlist+'.');
		},
		success : function(data) {
			select('folder-select-list').innerHTML = data;
		}
	});
};

TinyCIMM.prototype.getFoldersHTML = function(callback) {
	var self = this;
	tinymce.util.XHR.send({
		url : this.baseURL(this.settings.tinycimm_controller+'get_folders/list'),
		type : "GET",
		error : function(response) {
	 		tinyMCEPopup.editor.windowManager.alert(self.lang.msg_xhr_error_general+".");
		},
		success : function(response) {
			(callback) && callback(response.toString());	
		}
	});
};
	
TinyCIMM.prototype.changeView = function(view) {
	var self = this;
	// show loading image
	tinyMCEPopup.dom.setHTML('filebrowser', '<span id="loading">loading</span>');
	tinymce.util.XHR.send({
		url : this.baseURL(this.settings.tinycimm_controller+'change_view/'+view),
		type : "GET",
		error : function(text) {
			tinyMCEPopup.editor.windowManager.alert(self.lang.msg_xhr_error_general+".");
		},
		success : function() {
			self.showBrowser(0, 0, true);	
		}
	});
};

TinyCIMM.prototype.doSearch = function(e, el){
	if (e.keyCode == 13) {
		select('search-loading').style.display = 'inline-block';
		this.fileBrowser(0, 0, true, false, el.value.safeEscape());
	}
};
	
// reload dialog window to initial state
TinyCIMM.prototype.reload = function() {
	select('info_tab_link').className = 'rightclick';
	setTimeout(function() {
		window.location.reload();
		tinyMCEPopup.resizeToInnerSize();
	}, 300);
};

TinyCIMM.prototype.removeOverlay = function(){
	var dim = document.getElementById("overlay"), img = document.getElementById("overlayimg");
	(dim) && dim.parentNode.removeChild(dim);
	(img) && img.parentNode.removeChild(img);
};

TinyCIMM.prototype.showOverlay = function() {
	var dim = document.createElement("div"), img = document.createElement("div"), bodyRef = document.getElementById("upload_panel");
	dim.setAttribute("id", "overlay");
	img.setAttribute("id", "overlayimg");
	img.innerHTML = '<div><img src="img/progress.gif" /></div>';
	bodyRef.appendChild(dim);
	bodyRef.appendChild(img);
};

TinyCIMM.prototype.showFlashMsg = function(message){
	var self = this;
	setTimeout(function(){
		select('#flash-msg').hide().html(message).fadeIn(450, function(self){
			setTimeout(function(){
				self.fadeOut(400);
			}, 3000);
		});
	}, 200);
};
