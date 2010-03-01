/**
* tinycimm_image.js
* @author badsyntax.co.uk & pyrocms
*/

String.prototype.toId = function(){
        var id = 
	/get/.test(this) ? this.replace(/.*get\/([0-9]+)\/?([0-9]+)?\/?([0-9]+)?\/?/, '$1') : 
	(/\//.test(this) ? this.replace(/.*\/([0-9]+).*$/, '$1') : 
	this.replace(/([0-9]+).*$/, '$1'));
	return isNaN(id) ? 0 : id;
};

String.prototype.extension = function(){
	return this.replace(/.*\.(\w+)$/, '$1');
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

function extend(object, methods) {
	methods = methods || objMethods;
	for(var method in methods) {
		object[method] = methods[method];
	}
	return object;
}

function select(selector){
	// is the selector a DOM object?
	if (typeof selector == "object" && typeof selector.nodeName == "string") {
		return extend(selector);
	} 
	// use sizzle to find our DOM object and extend it
	else {
		var object = tinyMCEPopup.dom.select(selector);
		return (object.length) ? extend(object[0]) : extend(object);
	}
}

// custom object methods that are used in extending DOM objects
var objMethods = {

	fade : function(dir, speed, callback){
		dir = dir || 'in';
		speed = speed || 500;

		var self = this, step = 0, interval = 10;

		for(var timer=interval; timer<=speed; timer+=interval) {
			setTimeout(function(){
				('out' == dir)
				? self.opacity(((speed-((step*interval)+interval))/speed)*100)
				: self.opacity(((((step*interval)/speed))*100)+interval/2);
				step++;
			}, timer);
		}
		setTimeout(function(){(callback) && callback(self);}, timer+interval);
	},

	fadeIn : function(speed, callback){
		this.fade('in', speed, callback);
	},

	fadeOut : function(speed, callback){
		this.fade('out', speed, callback);
	},

	opacity : function(val){
		if (val != undefined) {
			this.style.opacity = (val/100);
			this.style.MozOpacity = (val/100);
			this.style.KhtmlOpacity = (val/100);
			this.style.filter = "alpha(opacity="+val+")"; 
		} else {
			return this.style.opacity;
		}
	},

	hide : function(){
		this.opacity(0);
		return this;
	},

	show : function(inline){
		this.opacity(100);
		if (this.style.display == 'none') {
			this.style.display = 'block';
		}
		return this;
	},

	html : function(html){
		this.innerHTML = html;
		return this;
	},

	multiFileUpload : function(config){
		config = config || {
			allowedTypes: document.getElementById('allowedtypes').innerHTML.trim().split(', ')
		};
		this.onchange = function(){
			var self = this, 
			container = document.createElement('div'), 
			removeanchor = document.createElement('a'), 
			newinput = document.createElement('input');

			// check extension against allowed types
			if (!config.allowedTypes.inArray(this.value.replace(/^.*\.([a-zA-Z]+)$/, '$1').toLowerCase())) {
				tinyMCEPopup.editor.windowManager.alert('Allowed types: '+config.allowedTypes.join(', '));
				this.value = '';
				return false;
			}

			// define new file input
			newinput.setAttribute('type', 'file');
			newinput.setAttribute('name', this.name+Math.floor(Math.random()*2));
			newinput.setAttribute('class', 'fileupload');
					
			// strip path segments from file name and add to container
			container.innerHTML = this.value.replace(/\\/g, "/").replace(/.*\//, "")+" ";
			container.className = 'fileuploadinput';

			// create and insert the 'remove' anchor
			removeanchor.href = '#';
			removeanchor.onclick = function(e){
				select(container).fadeOut(500, function(){
					container.parentNode.removeChild(container);
					self.parentNode.removeChild(self);
				});
				return false;
			};
			removeanchor.innerHTML = '[remove]';

			// add anchor elemnt to container
			container.appendChild(removeanchor);
		
			// insert new file input element and file name container
			this.parentNode.insertBefore(newinput, this);
			this.parentNode.insertBefore(container, this);	

			// show the file name
			select(container).fadeIn();

			// 'hide' the current file input (safari doesn't like display:none)
			this.style.position = 'absolute';
			this.style.left = '-1000px';
			
			// bind multi-file-uplood change event to new file input element
			select(newinput).multiFileUpload();
		};
		return this;
	},

	editInPlace : function(saveFunctionCallback){
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
	}
};
