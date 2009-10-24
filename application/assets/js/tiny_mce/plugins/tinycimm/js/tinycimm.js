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

String.prototype.text = function(){
	var str = this;
	try { str = decodeURIComponent(str); } catch(e) {}
	str = (str && str.length) ? str.replace(/<\S[^><]*>/g, '').trim() : '';
	return str;
};

String.prototype.safeEscape = function(){
	return encodeURIComponent(this.trim().replace(/[\/\\]/g, '')).replace(/%20/g, '+').toString();
};

Array.prototype.inArray = function(val) {
	for(var i=0;i<this.length;i++) if (this[i] === val) return true; return false;
};

Object.prototype.multiFileUpload = function(config){
	config = config || {
		allowedTypes: document.getElementById('allowedtypes').innerHTML.trim().split(', ')
	};
	this.onchange = function(){
		var self = this, 
		container = document.createElement('div'), 
		removeanchor = document.createElement('a'), 
		newinput = document.createElement('input');

		// check extension against allowed types
		if (!config.allowedTypes.inArray(this.value.replace(/^.*\.([a-zA-Z]+)$/, '$1'))) {
			tinyMCEPopup.editor.windowManager.alert('Allowed types: '+config.allowedTypes.join(', '));
			this.value = '';
			return false;
		}

		// define new file input
		newinput.setAttribute('type', 'file');
		newinput.setAttribute('name', this.name+Math.floor(Math.random()*2));
		newinput.setAttribute('class', 'fileupload');
		// bind multi-file-uplood change event to new file input element
		newinput.multiFileUpload();

		// insert new file input element
		this.parentNode.insertBefore(newinput, this);
				
		// strip path segments from file name
		container.innerHTML = this.value.replace(/\\/g, "/").replace(/.*\//, "")+" ";
		container.className = 'fileuploadinput';

		// create and insert the 'remove' anchor
		removeanchor.href = '#';
		removeanchor.onclick = function(e){
			e.preventDefault();
			container.parentNode.removeChild(container);
			self.parentNode.removeChild(self);
		};
		removeanchor.innerHTML = '[remove]';

		container.appendChild(removeanchor);
		this.parentNode.appendChild(container);

		// 'hide' the current file input (safari doesn't like display:none)
		this.style.position = 'absolute';
		this.style.left = '-1000px';
	};
	return this;
};

Object.prototype.editInPlace = function(saveFunctionCallback){
	var self = this, editItem = document.getElementById('edit-item-'+this.id);
	// if the editing container exists, then just show it
	if (editItem) {
		editItem.style.display = 'block';
		this.style.display = 'none';
		return;
	}
	var 
	input = document.createElement('input'),
	saveImg = new Image(), cancelImg = new Image(),
	editContainer = document.createElement('div');
	editContainer.setAttribute('id', 'edit-item-'+this.id);
	
	// prepare the input element
	input.value = this.innerHTML.text().replace(/\/$/, '');
	input.className = 'edit-folder-caption';

	// prepare the save image
	saveImg.className = 'edit-folder state-out';
	saveImg.src = 'img/save.gif';
	saveImg.title = 'save';
	saveImg.onmouseover = function(){
		this.className = this.className.replace(/state-out/, "state-over");
	};
	saveImg.onmouseout = function(){
		this.className = this.className.replace(/state-over/, "state-out");
	};
	saveImg.onclick = function(){
		saveFunctionCallback(input.value.safeEscape());
		self.style.display = 'block';
		editContainer.style.display = 'none';
	};

	// prepare the cancel image
	cancelImg.className = 'edit-folder state-out';
	cancelImg.src = 'img/cancel.png';
	cancelImg.title= 'cancel';
	cancelImg.onmouseover = function(){
		this.className = this.className.replace(/state-out/, "state-over");
	};
	cancelImg.onmouseout = function(){
		this.className = this.className.replace(/state-over/, "state-out");
	};
	cancelImg.onclick = function(){
		self.style.display = 'block';
		editContainer.style.display = 'none';
	};

	// append elements to container
	editContainer.appendChild(input);
	editContainer.appendChild(saveImg);
	editContainer.appendChild(cancelImg);

	// insert container into the dom
	this.parentNode.insertBefore(editContainer, this);
	this.style.display = 'none';
	input.focus();
	return this;
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
		url : this.baseURL(this.settings.tinycimm_controller+'get_'+this.type+'/'+asset_id),
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
		url : this.baseURL(this.settings.tinycimm_controller+'get_browser/'+folder+'/'+offset+'/'+search_query),
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
		url : this.baseURL(this.settings.tinycimm_controller+'get_manager/'+asset_id),
		type : "GET",
		error : function(reponse) {
			tinyMCEPopup.editor.windowManager.alert('Sorry, there was an error retrieving the assets.');
		},
		success : function(data) {
			(callback) && callback(data);
		}
	});

};

TinyCIMM.prototype.getUploader = function(callback) {
	tinymce.util.XHR.send({
		url : this.baseURL(this.settings.tinycimm_controller+'get_uploader_form'),
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
	
TinyCIMM.prototype.deleteAsset = function(asset_id) {
	var self = this;
	tinyMCEPopup.editor.windowManager.confirm('Are you sure you want to delete this '+this.type+'?', function(s) {
		if (!s) {return false;}
		tinymce.util.XHR.send({
			url : self.baseURL(self.settings.tinycimm_controller+'delete_'+self.type+'/'+asset_id),
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

TinyCIMM.prototype.updateAsset = function(asset_id, folder_id, description, name) {
	var self = this;
	tinymce.util.XHR.send({
		url : self.baseURL(self.settings.tinycimm_controller+'update_asset/'+asset_id),
 		content_type : 'application/x-www-form-urlencoded',
		type : "POST",
		data : 	'folder_id='+folder_id+'&description='+description+'&name='+name,
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

TinyCIMM.prototype.saveFolder = function(folder_id, folder_name, callback) {
	var self = this;
	tinymce.util.XHR.send({
		url : self.baseURL(self.settings.tinycimm_controller+'save_folder/'+folder_id),
 		content_type : 'application/x-www-form-urlencoded',
		type : "POST",
		data : 	'folder_name='+folder_name,
		error : function(response) {
			tinyMCEPopup.editor.windowManager.alert('There was an error processing the request.');
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
	foldername = encodeURIComponent(tinyMCEPopup.dom.get('add-folder-caption').value.replace(/^\s+|\s+$/g, '')),
	requesturl = this.baseURL(this.settings.tinycimm_controller+'save_folder/'+foldername+'/'+type);

	this.saveFolder(0, foldername, function(response){
		if (response.outcome) {
			tinyMCEPopup.dom.get('add-folder').style.display = 'none';
			tinyMCEPopup.dom.get('add-folder-caption').value = '';
			self.getFoldersHTML(function(folderHTML){
				tinyMCEPopup.dom.setHTML('folderlist', folderHTML)
			});
		}
	});
};

TinyCIMM.prototype.editFolder = function(folder_id){
	var self = this, folder = document.getElementById('folder-'+folder_id);

	folder.editInPlace(function(input_value){
		self.saveFolder(folder_id, input_value, function(){
			self.getFoldersHTML(function(folderHTML){
				tinyMCEPopup.dom.setHTML('folderlist', folderHTML)
			});
		});
	});
};

TinyCIMM.prototype.deleteFolder = function(folder_id) {
	var self = this;
	tinyMCEPopup.editor.windowManager.confirm('Are you sure you want to delete this folder?', function(s){
		if (!s) { return false; }
		var requesturl = self.baseURL(self.settings.tinycimm_controller+'delete_folder/'+folder_id);
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
					self.showBrowser(0, 0, true);
	 			}
			}
		});
	});
};			

TinyCIMM.prototype.getFoldersSelect = function(folder, type) {
	folder = folder || 0;
	type = type || 'image';
	tinymce.util.XHR.send({
		url : this.baseURL(this.settings.tinycimm_controller+'get_folders/select/'+folder),
		type : "GET",
		error : function(text) {
			tinyMCEPopup.editor.windowManager.alert('There was an error retrieving the select list.');
		},
		success : function(data) {
			tinyMCEPopup.dom.get('folder-select-list').innerHTML = data;
		}
	});
};

TinyCIMM.prototype.getFoldersHTML = function(callback) {
	var self = this;
	tinymce.util.XHR.send({
		url : this.baseURL(this.settings.tinycimm_controller+'get_folders/list'),
		type : "GET",
		error : function(response) {
	 		tinyMCEPopup.editor.windowManager.alert('There was an error processing the request.');
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
