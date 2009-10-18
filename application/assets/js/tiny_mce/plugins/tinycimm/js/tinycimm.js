/*
 *
 * tinycimm.js
 * Copyright (c) 2009 Richard Willis
 * MIT license  : http://www.opensource.org/licenses/mit-license.php
 * Project      : http://tinycimm.googlecode.com/
 * Contact      : willis.rh@gmail.com
 *
 */

String.prototype.toId = function(){
        var id = 
	/get/.test(this) ? this.replace(/.*get\/([0-9]+)\/?([0-9]+)?\/?([0-9]+)?\/?/, '$1') : 
	(/\//.test(this) ? this.replace(/.*\/([0-9]+).*$/, '$1') : 
	this.replace(/([0-9]+).*$/, '$1'));
	return isNaN(id) ? 0 : id;
};
String.prototype.extension = function(){
	return this.replace(/.*\.([a-z]+)$/, '$1');
};
String.prototype.ucfirst = function(){
	return this.substr(0, 1).toUpperCase()+this.substr(1, this.length-1).toLowerCase();
};
String.prototype.trim = function(){
	return this.replace(/^\s*|\s*$/g, '');
};
String.prototype.safeEscape = function(){
	return encodeURIComponent(this.trim().replace(/[\/\\]/g, '')).replace(/%20/g, '+').toString();
};

function TinyCIMM(type){
	this.type = type || null;
	this.recache = false;
	this.settings = tinyMCEPopup.editor.settings;
}

TinyCIMM.prototype.init = function(ed){
	var node = ed.selection.getNode();
	if (tinyMCEPopup.params.resize) {
		this.loadResizer(node.src.toId()+'.'+node.src.extension(), false, node.width);
	} else {
		this.showBrowser(0, 0, true);
	}
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
	tinymce.util.XHR.send({
		url : this.baseURL(this.settings.tinycimm_controller+this.type+'/get_'+this.type+'/'+asset_id),
		type : "GET",
		error : function(response) {
			tinyMCEPopup.editor.windowManager.alert('There was an error retrieving the asset info.');
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

TinyCIMM.prototype.showBrowser = function(folder, offset, load, el) {
	if (TinyCIMMImage.recache) {
		load = true;
		TinyCIMMImage.recache = false;
	} else {
		load = tinyMCEPopup.dom.get('filelist') ? (load || false) : true;
	}
	folder = folder || 0;
	offset = offset || 0;
	el = el || false;
	mcTabs.displayTab('browser_tab','browser_panel');
	tinyMCEPopup.dom.get('resize_tab').style.display = 'none';
	tinyMCEPopup.dom.get('manager_tab').style.display = 'none';
	(load) && (this.fileBrowser) && this.fileBrowser(folder, offset, load, el);
};

TinyCIMM.prototype.showUploader = function() {
	mcTabs.displayTab('upload_tab','upload_panel');
	tinyMCEPopup.dom.get('manager_tab').style.display = 'none';
	(this.loadUploader) && this.loadUploader();
};

// load list of folders and files via json request
TinyCIMM.prototype.getBrowser = function(folder, offset, search_query, callback) {
	var self = this;
	folder = folder || 0;
	offset = offset || 0;
	search_query = search_query || '';
	if (tinyMCEPopup.dom.get('img-'+folder) == null) {
		tinyMCEPopup.dom.setHTML('filebrowser', '<span id="loading">loading</span>');
	}
	(this.type) && tinymce.util.XHR.send({
		url : this.baseURL(this.settings.tinycimm_controller+this.type+'/get_browser/'+folder+'/'+offset+'/'+search_query),
		type : "GET",
		error : function(reponse) {
			tinyMCEPopup.editor.windowManager.alert('Sorry, there was an error retrieving the assets.');
		},
		success : function(response) {
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
	tinymce.util.XHR.send({
		url : this.baseURL(this.settings.tinycimm_controller+this.type+'/get_manager/'+asset_id),
		type : "GET",
		error : function(reponse) {
			tinyMCEPopup.editor.windowManager.alert('Sorry, there was an error retrieving the assets.');
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
	
TinyCIMM.prototype.loadSelect = function(folder, type) {
	folder = folder || 0;
	type = type || 'image';
	tinymce.util.XHR.send({
		url : this.baseURL(this.settings.tinycimm_controller+type+'/get_folders_select/'+folder),
		type : "GET",
		error : function(text) {
			tinyMCEPopup.editor.windowManager.alert('There was an error retrieving the select list.');
		},
		success : function(data) {
			setTimeout(function(){
				var d = window.upload_target_ajax.document.getElementById('folder_select_list');
				if (d) {
					d.innerHTML = data;
				} else {
					tinyMCEPopup.dom.get('folder_select_list').innerHTML = data;
				}
			}, 500);
		}
	});
};

TinyCIMM.prototype.addFolder = function(type) {
	type = type || 'image';
	var foldername = encodeURIComponent(tinyMCEPopup.dom.get('add-folder-caption').value.replace(/^\s+|\s+$/g, ''));
	var requesturl = this.baseURL(this.settings.tinycimm_controller+this.type+'/add_folder/'+foldername+'/'+type);
	(foldername.length) && tinymce.util.XHR.send({
		url : requesturl,
		type : "GET",
		error : function(response) {
			tinyMCEPopup.editor.windowManager.alert('There was an error processing the request.');
		},
		success : function(response) {
			var obj = tinymce.util.JSON.parse(response);
			if (!obj.outcome) {
					tinyMCEPopup.editor.windowManager.alert('Error: '+obj.message);
			} else {
				tinyMCEPopup.dom.setHTML('folderlist', response)
				tinyMCEPopup.dom.get('add-folder').style.display = 'none';
				tinyMCEPopup.dom.get('add-folder-caption').value = '';
			}
		}
	});
};

TinyCIMM.prototype.deleteFolder = function(folder_id) {
	var self = this;
	tinyMCEPopup.editor.windowManager.confirm('Are you sure you want to delete this folder?', function(s){
		if (!s) { return false; }
		var requesturl = self.baseURL(self.settings.tinycimm_controller+self.type+'/delete_folder/'+folder_id);
		tinymce.util.XHR.send({
			url : requesturl,
			type : "GET",
			error : function(response) {
	 			tinyMCEPopup.editor.windowManager.alert('There was an error processing the request.');
			},
			success : function(response) {
	 			var obj = tinymce.util.JSON.parse(response);
				if (!obj.outcome) {
					tinyMCEPopup.editor.windowManager.alert('Error: '+obj.message);
	 			} else {
					self.getFoldersHTML(function(folderHTML){
						tinyMCEPopup.dom.setHTML('folderlist', folderHTML)
					});
					if (obj.images_affected > 0) {
						tinyMCEPopup.editor.windowManager.alert(obj.images_affected+" images were moved to the root directory.");
						self.showBrowser(0, 0, true);
					}
	 			}
			}
		});
	});
};			
	
// get folders as html string
TinyCIMM.prototype.getFoldersHTML = function(callback) {
	var self = this;
	tinymce.util.XHR.send({
		url : this.baseURL(this.settings.tinycimm_controller+self.type+'/get_folders_html'),
		type : "GET",
		error : function(response) {
	 		tinyMCEPopup.editor.windowManager.alert('There was an error processing the request.');
		},
		success : function(response) {
			(callback) && callback(response.toString());	
		}
	});
};
	
TinyCIMM.prototype.deleteAsset = function(asset_id) {
	var self = this;
	tinyMCEPopup.editor.windowManager.confirm('Are you sure you want to delete this '+this.type+'?', function(s) {
		if (!s) {return false;}
		tinymce.util.XHR.send({
			url : self.baseURL(self.settings.tinycimm_controller+self.type+'/delete_'+self.type+'/'+asset_id),
			type : "GET",
			error : function(response) {
				tinyMCEPopup.editor.windowManager.alert('There was an error processing the request.');
			},
			success : function(response) {
				var obj = tinymce.util.JSON.parse(response);
				if (!obj.outcome) {
					tinyMCEPopup.editor.windowManager.alert('Error: '+obj.message);
				} else {
			 		self.showBrowser(obj.folder, 0, true);
					// self.showFlashMsg(obj.message);
				}
			}
		});
	});
};

TinyCIMM.prototype.updateAsset = function(asset_id) {
	var self = this;
	tinymce.util.XHR.send({
		url : self.baseURL(self.settings.tinycimm_controller+self.type+'/update_asset/'+asset_id),
 		content_type : 'application/x-www-form-urlencoded',
		type : "POST",
		data : 	'folder_id='+tinyMCEPopup.dom.get('folderselect').value+
			'&description='+tinyMCEPopup.dom.get('image-alttext').innerHTML+
			'&name='+tinyMCEPopup.dom.get('image-name').value,
		error : function(response) {
			tinyMCEPopup.editor.windowManager.alert('There was an error processing the request.');
		},
		success : function(response) {
			if (response) {	
				var obj = tinymce.util.JSON.parse(response);
				tinyMCEPopup.editor.windowManager.alert(obj.message);
			}
		}
	});
};
	
TinyCIMM.prototype.changeView = function(view) {
	var self = this;
	// show loading image
	tinyMCEPopup.dom.setHTML('filebrowser', '<span id="loading">loading</span>');
	tinymce.util.XHR.send({
		url : this.baseURL(this.settings.tinycimm_controller+'image/change_view/'+view),
		type : "GET",
		error : function(text) {
			tinyMCEPopup.editor.windowManager.alert('There was an error processing the request.');
		},
		success : function() {
			self.showBrowser(0, 0, true);	
		}
	});

};
	
TinyCIMM.prototype.changeView = function(view) {
	var self = this;
	// show loading image
	tinyMCEPopup.dom.setHTML('filebrowser', '<span id="loading">loading</span>');
	tinymce.util.XHR.send({
		url : this.baseURL(this.settings.tinycimm_controller+'image/change_view/'+view),
		type : "GET",
		error : function(text) {
			tinyMCEPopup.editor.windowManager.alert('There was an error processing the request.');
		},
		success : function() {
			self.showBrowser(0, 0, true);	
		}
	});
};

TinyCIMM.prototype.doSearch = function(e, el){
	if (e.keyCode == 13) {
		tinyMCEPopup.dom.get('search-loading').style.display = 'inline-block';
		this.fileBrowser(0, 0, true, false, el.value.safeEscape());
	}
};
	
// reload dialog window to initial state
TinyCIMM.prototype.reload = function() {
	tinyMCEPopup.dom.get('info_tab_link').className = 'rightclick';
	setTimeout(function() {
		window.location.reload();
		tinyMCEPopup.resizeToInnerSize();
	}, 300);
};
