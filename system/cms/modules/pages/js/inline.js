if( typeof pyro === 'undefined') var pyro = {};

// Busy indicator
(function(c){function b(a){this.options=c.extend({},b.defaults,a)}b.instances=[];b.repositionAll=function(){for(var a=0;a<b.instances.length;a++)if(b.instances[a]){var e=b.instances[a].options;(new b(e)).positionImg(c(b.instances[a].target),c.data(b.instances[a].target,"busy"),e.position)}};b.prototype.hide=function(a){a.each(function(){var a=c.data(this,"busy");a&&a.remove();c(this).css("visibility","");c.data(this,"busy",null);for(a=0;a<b.instances.length;a++)null!=b.instances[a]&&b.instances[a].target==
this&&(b.instances[a]=null)})};b.prototype.show=function(a){var e=this;a.each(function(){if(!c.data(this,"busy")){var a=c(this),d=e.buildImg();d.css("visibility","hidden");d.load(function(){e.positionImg(a,d,e.options.position);d.css("visibility","")});c("body").append(d);e.options.hide&&a.css("visibility","hidden");c.data(this,"busy",d);b.instances.push({target:this,options:e.options})}})};b.prototype.preload=function(){var a=this.buildImg();a.css("visibility","hidden");a.load(function(){c(this).remove()});
c("body").append(a)};b.prototype.buildImg=function(){var a="<img src='"+this.options.img+"' alt='"+this.options.alt+"' title='"+this.options.title+"'";this.options.width&&(a+=" width='"+this.options.width+"'");this.options.height&&(a+=" height='"+this.options.height+"'");return c(a+" />")};b.prototype.positionImg=function(a,b,c){var d=a.offset(),f=a.outerWidth(),a=a.outerHeight(),g=b.outerWidth(),h=b.outerHeight(),c="left"==c?d.left-g-this.options.offset:"right"==c?d.left+f+this.options.offset:d.left+
(f-g)/2,d=d.top+(a-h)/2;b.css("position","absolute");b.css("left",c+"px");b.css("top",d+"px")};b.defaults={img:"system/cms/modules/pages/img/busy.gif",alt:"Please wait...",title:"Please wait...",hide:!0,position:"center",zIndex:1001,width:null,height:null,offset:10};c.fn.busy=function(a,e){if(-1!=c.inArray(a,["clear","hide","remove"]))(new b(a)).hide(c(this));else if("defaults"==a)c.extend(b.defaults,e||{});else if("preload"==a)(new b(a)).preload();else if("reposition"==a)b.repositionAll();
else return(new b(a)).show(c(this)),c(this)}})(jQuery);

// Mobile friendly double tap/click
(function($){var isMobile=!1,agent=navigator.userAgent.toLowerCase();if(0<=agent.indexOf("iphone")||0<=agent.indexOf("ipad")||0<=agent.indexOf("android"))isMobile=!0; $.fn.doubletap=function(g,h,a){var i,e,a=null==a?500:a;i=isMobile?"touchend":"click";eventStart=isMobile?"touchstart":"mousedown";$(this).not("textarea").bind(eventStart,function(){});$(this).bind(i,function(f){f.preventDefault();var b=$(this),c=(new Date).getTime(),d=b.data("lastTouch")||c+1,d=c-d;clearTimeout(e);500>d&&0<d?$.isFunction(g)&&g.call(b,f):($(this).data("lastTouch",c),e=setTimeout(function(a){$.isFunction(h)&&h.call(b,a);clearTimeout(e)},a,[f]));b.data("lastTouch",c)})};})(jQuery);

$(function() {
	
	pyro.init_ckeditor = function(el, w, h, advanced) {
		w = w || 'auto';
		h = h || 'auto'; 
		var cfg = {
			height : h,
			width : w,
			extraPlugins : 'autocss',
			skin:'pyroeditor',
			startupFocus: true,
			customConfig:false,
			dialog_backgroundCoverColor : '#000',
			sharedSpaces: {top : 'inline-toolbar'},
			toolbarCanCollapse: false,
			defaultLanguage : 'en',
			language : 'en'
		};
		if (advanced === true){			
			cfg.toolbar = [
				{name: 'max', items: ['Maximize']},
				{name: 'pyro', items:['pyroimages', 'pyrofiles']},
				{name: 'edit', items:['Cut', 'Copy', 'Paste', 'PasteFromWord']},
				{name: 'utils', items:['Undo', 'Redo', '-', 'Find', 'Replace']},
				{name: 'link', items:['Link', 'Unlink']},
				{name: 'insert', items:['Table', 'HorizontalRule', 'SpecialChar']},
				{name: 'styles', items:['Bold', 'Italic', 'StrikeThrough']},
				{name: 'alignment', items:['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl']},
				{name: 'formating', items:['Format', 'FontSize', 'Subscript', 'Superscript', 'NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote']},
				{name: 'utils2', items:['ShowBlocks', 'RemoveFormat', 'Source']}
			];
			cfg.extraPlugins = 'autocss,pyroimages,pyrofiles';
			cfg.removePlugins = 'elementspath';
		} else {
			cfg.toolbar = [{name:'simple', items: ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'Source']}];
		}
		return CKEDITOR.replace(el, cfg);
	};


	var instances = {};
	var toolbar = {
		wraper: $('<div id="inline-toolbar-wraper" />'),
		body: $('<div id="inline-toolbar" />'),
		actions: $('<span id="inline-actions" />'),
	};
	
	toolbar.wraper.append(toolbar.body, toolbar.actions);
	
	// Append to body
	$('body').append(toolbar.wraper);
	toolbar.wraper.hide();

	function PyroEditor(el, config) {
		this.el = el;
		this.id = this.el.attr('id').replace(/[^0-9\.]+/g, '');
		this.config = config||{};
		this.wraper = $('.page-chunk-pad', this.el);
		this.height = this.wraper.height() == 0 ? this.el.height() : this.wraper.height();
		this.width = this.wraper.width();
		
		
		this.data = {
			chunk_id: this.id,
			page_id: $('#page-chunks').attr('data-pid'),
			csrf_hash_name : $.cookie('csrf_cookie_name')
		};
		this.state('view');
		this.init();
	}
	PyroEditor.prototype = {
		
		init:function(){
			var self=this;
			this.el.doubletap(function() {
				if(self.state('state') == 'edit') return false;				
				self.act = self.el.busy({hide : false});
				self.remoteGet();
			});
		},
		
		startEdit:function(){
			this.state('edit');
			this.showActions();
		},
		
		stopEdit:function(is_cancel) {
			if (this.is_wysiwyg) {
				this.obj.textarea.removeClass('wysiwyg-simple wysiwyg-advanced');
				CKEDITOR.instances['chunk-' + this.id] && CKEDITOR.instances['chunk-' + this.id].destroy();
			}
		
			this.obj.form.remove();
			this.obj.actions.remove();
			//toolbar.actions.hide();
			delete instances['chunk-' + this.id];
			
			this.state('view');
			if(is_cancel) {
				this.wraper.fadeIn();
			}
			
			// Check if we have anymore editors
			
			
			if ($.isEmptyObject(CKEDITOR.instances)) {
				var html=$('html');
				this.adjustMargin('up');
			} else {
				// Hack to focus on the next editor
				for (var i in CKEDITOR.instances) {
					CKEDITOR.instances[i].focus();
					return false;
				}
			}

			if ($.isEmptyObject(instances)) {
				this.adjustMargin('up');
				toolbar.actions.hide();
			} else {
				for (var i in instances) {
					instances[i].obj.textarea.focus();
				}				
			}

		},
		
		state: function(st) {
			if (st) this.el.data('state', st);
			else return this.el.data('state');
		},
		adjustMargin:function(dir){
			var html=$('html');
			
			if (dir == 'up' && html.data('pad')) {
				html.animate({'marginTop':'-=58px'}, 'fast');
				html.data('pad',false);
			}
			if (dir == 'down' && !html.data('pad')) {
				html.animate({'marginTop':'+=58px'}, 'fast');
				html.data('pad',true);				
			}
		},
		
		remoteGet: function(){
			var self = this;
			this.data.csrf_hash_name = $.cookie('csrf_cookie_name');
			$.post(SITE_URL + 'admin/pages/inline/edit', this.data, function(data) {
				
				// Error or no data..?
				if(data.length <= 0 || data.status == 'error') {
					self.act.busy('hide');
					self.wraper.fadeIn();
					self.state('view');
					return false;
				}
				self.data.type = data.type;
				self.is_html = (data.type == 'html') ? true : false,
				self.is_wysiwyg = (data.type == 'wysiwyg-simple' || data.type == 'wysiwyg-advanced') ? true : false,
				self.obj = {
					form: $('<form />').css({'min-height': self.height,'max-width':self.width}),
					textarea: $('<textarea class="' + data.type + '" name="chunk-' + self.id + '" rows="20">' + data.body + '</textarea>')
								.css({'height': (self.height > 400) ? 400 : self.height, 'max-width': self.width}).hide(),
					buttons: {
						cancel: $('<input type="button" name="cancel" class="cancel" value="Cancel" />'),
						submit: $('<input type="submit" name="submit" value="Save" />')
					},
					actions: $('<span id="acts-'+self.id+'">')
				};
				
				// Append elements to form
				self.obj.form.append(self.obj.textarea);
				self.el.append(self.obj.form);

				// Add actions to toolbar
				self.obj.actions.append(self.obj.buttons.cancel, self.obj.buttons.submit);
				toolbar.actions.append(self.obj.actions);
				
				// Register click events
				self.regCancel(self.obj.buttons.cancel);
				self.regSubmit(self.obj.buttons.submit);
				
				// Hide chunk
				self.wraper.fadeOut('fast');
				
				// Create wysiwyg editor?
				if(self.is_wysiwyg) {

					self.editor = pyro.init_ckeditor(self.obj.textarea.get(0), self.width, self.height, data.type == 'wysiwyg-advanced');
					
					self.editor.on( 'focus', function(e){
						self.showActions();
					});

					self.editor.on('instanceReady', function(){
						self.editor.focus();	
					});
					// Push the page down 
					self.adjustMargin('down');					
					
				} else {
					// Html or Markdown just show the textarea
					self.editor
					self.obj.textarea.fadeIn();
					self.obj.textarea.on( 'focus', function(e){
						self.showActions();
					});
					self.obj.textarea.focus();
					var txt = self.obj.textarea.createTextRange;
					if (txt) {
						txt.collapse(false);
						txt.select();
					}
				}
				instances['chunk-' + self.id] = self;
				self.startEdit();
				self.act.busy('hide');

	
			// reg sunmit
			}, 'json').error(function(e){
				alert('Error: Please try to refresh page or login again.');
				self.act.busy('hide');
				self.el.fadeIn();
				self.state('view');
				return false;
	
			});
		},
		remotePost:function(){
			var self = this;
			this.data.csrf_hash_name = $.cookie('csrf_cookie_name');
			$.post(SITE_URL+ 'admin/pages/inline/save', this.data, function(data) {
				if(data.status == 'error') {
				} else if(data.status == 'ok') {
					// Destroy existing WYSIWYG instance
					self.stopEdit();
					self.wraper.hide().html(data.body).fadeIn();
				}
				self.act.busy('hide');
			}, 'json');

		},
		
		regSubmit: function(el) {
			var self = this;
			el.one('click', function() {
				self.act.busy('show');
			
				if(self.is_wysiwyg)
					self.data.body = self.editor.getData();
				else
					self.data.body = self.obj.textarea.val();
					
				self.remotePost();
				return false;
			});
		},
		regCancel: function (el) {
			var self=this;
			el.one('click', function() {
				self.stopEdit(true);
			});
		},
		showActions:function(){
			// Hide toolbar actions?
			$('span', toolbar.actions).not('#acts-'+ this.id).hide();
			if(this.is_wysiwyg) {
				toolbar.body.show();
				CKEDITOR.instances['chunk-' + this.id].focus();
				this.adjustMargin('down');
			} else {
				this.adjustMargin('up');
				toolbar.body.fadeOut();
			}
			if (toolbar.actions.is(':hidden')) toolbar.actions.show('fast');
			if (toolbar.wraper.is(':hidden')) toolbar.wraper.delay(1500).fadeIn('fast');
			$('#acts-'+ this.id).show();
		}

	};
	
	$.fn.pyroEditor = function (options) {
		return this.each(function () {
			var self = $(this);
			if (!self.data('plugin_pyroeditor')) {
				self.data('plugin_pyroeditor', new PyroEditor(self, options));
			}
		})
	};
	
});