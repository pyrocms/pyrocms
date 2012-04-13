/*
 * Handles Mobile tap events
 *
(function(a){var b=!1,c=navigator.userAgent.toLowerCase();if(0<=c.indexOf("iphone")||0<=c.indexOf("ipad")||0<=c.indexOf("android"))b=!0;a.fn.doubletap=function(c,i,d){var j,h,d=null==d?500:d;j=b?"touchend":"click";eventStart=b?"touchstart":"mousedown";a(this).bind(eventStart,function(a){a.preventDefault()});a(this).bind(j,function(b){b.preventDefault();var e=a(this),f=(new Date).getTime(),g=e.data("lt")||f+1,g=f-g;clearTimeout(h);500>g&&0<g?a.isFunction(c)&&c.call(e,b):(a(this).data("lt", f),h=setTimeout(function(b){a.isFunction(i)&&i.call(e,b);clearTimeout(h)},d,[b]));e.data("lt",f)})}})(jQuery);
*/
(function(c){function b(a){this.options=c.extend({},b.defaults,a)}b.instances=[];b.repositionAll=function(){for(var a=0;a<b.instances.length;a++)if(b.instances[a]){var e=b.instances[a].options;(new b(e)).positionImg(c(b.instances[a].target),c.data(b.instances[a].target,"busy"),e.position)}};b.prototype.hide=function(a){a.each(function(){var a=c.data(this,"busy");a&&a.remove();c(this).css("visibility","");c.data(this,"busy",null);for(a=0;a<b.instances.length;a++)null!=b.instances[a]&&b.instances[a].target==
this&&(b.instances[a]=null)})};b.prototype.show=function(a){var e=this;a.each(function(){if(!c.data(this,"busy")){var a=c(this),d=e.buildImg();d.css("visibility","hidden");d.load(function(){e.positionImg(a,d,e.options.position);d.css("visibility","")});c("body").append(d);e.options.hide&&a.css("visibility","hidden");c.data(this,"busy",d);b.instances.push({target:this,options:e.options})}})};b.prototype.preload=function(){var a=this.buildImg();a.css("visibility","hidden");a.load(function(){c(this).remove()});
c("body").append(a)};b.prototype.buildImg=function(){var a="<img src='"+this.options.img+"' alt='"+this.options.alt+"' title='"+this.options.title+"'";this.options.width&&(a+=" width='"+this.options.width+"'");this.options.height&&(a+=" height='"+this.options.height+"'");return c(a+" />")};b.prototype.positionImg=function(a,b,c){var d=a.offset(),f=a.outerWidth(),a=a.outerHeight(),g=b.outerWidth(),h=b.outerHeight(),c="left"==c?d.left-g-this.options.offset:"right"==c?d.left+f+this.options.offset:d.left+
(f-g)/2,d=d.top+(a-h)/2;b.css("position","absolute");b.css("left",c+"px");b.css("top",d+"px")};b.defaults={img:"busy.gif",alt:"Please wait...",title:"Please wait...",hide:!0,position:"center",zIndex:1001,width:null,height:null,offset:10};c.fn.busy=function(a,e){if(-1!=c.inArray(a,["clear","hide","remove"]))(new b(a)).hide(c(this));else if("defaults"==a)c.extend(b.defaults,e||{});else if("preload"==a)(new b(a)).preload();else if("reposition"==a)b.repositionAll();
else return(new b(a)).show(c(this)),c(this)}})(jQuery);


/*
 * @todo rebind submit button after..
 */

$(function() {

	if( typeof pyro === 'undefined')
		var pyro = {};

	/*
	 * Detect size and format
	 */

	pyro.init_ckeditor = function(w,h) {
		w = w || 'auto';
		h = h || 'auto';
		$('textarea.wysiwyg-simple').ckeditor({
			toolbar : [['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'Source']],
			width : w,
			extraPlugins : 'autocss',
			skin:'pyroeditor',
			height : h,
			dialog_backgroundCoverColor : '#000',
			sharedSpaces: {top : 'inline-toolbar'},
			toolbarCanCollapse: false,
			defaultLanguage : 'en',
			language : 'en'
		});

		$('textarea.wysiwyg-advanced').ckeditor({
			toolbar : [['Maximize'], ['pyroimages', 'pyrofiles'], ['Cut', 'Copy', 'Paste', 'PasteFromWord'], ['Undo', 'Redo', '-', 'Find', 'Replace'], ['Link', 'Unlink'], ['Table', 'HorizontalRule', 'SpecialChar'], ['Bold', 'Italic', 'StrikeThrough'], ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'], ['Format', 'FontSize', 'Subscript', 'Superscript', 'NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote'], ['ShowBlocks', 'RemoveFormat', 'Source']],
			extraPlugins : 'autocss,pyroimages,pyrofiles',
			width : w,
			skin:'pyroeditor',
			height : h,
			sharedSpaces: {top : 'inline-toolbar'},
			dialog_backgroundCoverColor : '#000',
			removePlugins : 'elementspath',
			defaultLanguage : 'en',
			toolbarCanCollapse: false,
			language : 'en'
		});
	};
	pyro.init_ckeditor();
	
	var toolbarWraper = $('<div id="inline-toolbar-wraper" style="text-align:center; position:fixed; top:0;left:0; margin:0; width:100%; z-index:9999" />');
	var toolbar = $('<div id="inline-toolbar" style="display:none; " />');
	toolbarWraper.append(toolbar);
	$('body').append(toolbarWraper);
	var isMobile = false,
		agent = navigator.userAgent.toLowerCase();
		
	if(agent.indexOf('iphone') >= 0 || agent.indexOf('ipad') >= 0 || agent.indexOf('android') >= 0){
		   isMobile = true;
	}
 
	$.fn.doubletap = function(onDbl, onSingle, delay) {
		var eventName, action;
		delay = delay == null ? 500 : delay;
		eventName = isMobile ? 'touchend' : 'click',
 		eventStart = isMobile ? "touchstart" : "mousedown";

		$(this).not('textarea').bind(eventStart, function(e) {
			//e.preventDefault();
			//e.stopPropagation()
		});

		$(this).bind(eventName, function(e){
			e.preventDefault();
			var self=$(this),
				now = new Date().getTime(),
				lastTouch = self.data('lastTouch') || now + 1,
				delta = now - lastTouch;
			clearTimeout(action);
			if(delta<500 && delta>0) {
				if($.isFunction(onDbl)) {
					onDbl.call(self, e);
				}
			}else{
				$(this).data('lastTouch', now);
				action = setTimeout(function(evt){
					if($.isFunction(onSingle)){
						onSingle.call(self, evt);
					}
					clearTimeout(action);   // clear the timeout
				}, delay, [e]);
			}
			self.data('lastTouch', now);
		});
	};

		//function bindMain () {
			$('.page-chunk').doubletap(function() {

			if($(this).data('state') == 'edit') return false;

			$(this).data('state', 'edit');
			if (toolbar.is(':hidden')) toolbar.fadeIn();
			var self = $(this), id = self.attr('id').replace(/[^0-9\.]+/g, ''), container = $('.page-chunk-pad', self), page_id = $('#page-chunks').attr('data-pid'), post_data = {
				chunk_id : id,
				page_id : page_id,
				csrf_hash_name : $.cookie('csrf_cookie_name')
			}, form = $('<form />'), _busy = false;

			_busy = self.busy({
				hide : false
			});
			
			var _h = container.height(), _w=container.width();
			
			if (_h == 0) _h = self.height();
			form.css('min-height',_h);
			form.css('max-width',_w);

			$.post(SITE_URL + 'admin/pages/inline/edit', post_data, function(data) {
				if(data.length <= 0 || data.status == 'error') {
					_busy.busy('hide');
					container.fadeIn();
					$(this).data('state', 'view');
					return false;
				}
				post_data.type = data.type;
				var is_html = (data.type == 'html') ? true : false,
					is_wysiwyg = (data.type == 'wysiwyg-simple' || data.type == 'wysiwyg-advanced') ? true : false,
					txt = $('<textarea class="' + data.type + '" name="chunk-' + id + '" rows="20" style="max-height:">' + data.body + '</textarea>').hide();
					txt.css({'height':(_h > 400) ? 400 : _h,'max-width':_w});
				var act = {
					cancel : $('<input type="button" name="cancel" class="cancel" value="Cancel" />'),
					submit : $('<input type="submit" name="submit" value="Save" />')
				};
				form.append(txt);
				form.append(act.cancel);
				form.append(act.submit);
				self.append(form);
				
				container.fadeOut('fast', function() {
				
				});
				if(is_wysiwyg) {
					pyro.init_ckeditor(_w, _h-50);
					if ($('html').css('margin-top') != '58'){
						$('html').data('pad', $('body').css('margin-top'));
						//({"left": "-=50px"}, "slow");
						$('html').animate({'marginTop':'58px'},'slow');
					}
				} else{
					txt.fadeIn();
				}

				_busy.busy('hide');
				
				// Stop Editing
				var end_edit = function(is_cancel) {
					if(is_wysiwyg) {
						txt.removeClass('wysiwyg-simple');
						txt.removeClass('wysiwyg-advanced');
						var instance = CKEDITOR.instances['chunk-' + id];
						instance && instance.destroy();
					}

					form.remove();
					self.data('state', 'view');
					if(is_cancel) {
						container.fadeIn();
					}
					if ($.isEmptyObject(CKEDITOR.instances)) {
						$('html').animate({'marginTop':'-=58px'},'slow');
						//$('html').css('margin-top',);
					} else {
						for (var i in CKEDITOR.instances) {
							CKEDITOR.instances[i].focus();
							return false;
						}
					}
				};

				act.cancel.one('click', function() {
					end_edit(true);
				});

				act.submit.one('click', function() {
					_busy.busy('show');

					if(is_wysiwyg)
						post_data.body = CKEDITOR.instances['chunk-' + id].getData();
					else
						post_data.body = txt.val();
					$.post(SITE_URL+ 'admin/pages/inline/save', post_data, function(data) {
						if(data.status == 'error') {
						} else if(data.status == 'ok') {
							// Destroy existing WYSIWYG instance
							end_edit();
							self.hide().html(data.body).fadeIn();
						}
						_busy.busy('hide');
					}, 'json');
					return false;
				});
			}, 'json').error(function(e){
 				alert('Error: Please try to refresh page or login again.');
				_busy.busy('hide');
				container.fadeIn();
				self.data('state', 'view');
				return false;

			});
			
			return false;
		});
});
