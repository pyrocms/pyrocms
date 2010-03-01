/**
 * Based on TinyMCE Wordpress plugin (Kitchen Sink)
 * 
 * @author Guido Neele
 */

(function() {
	var DOM = tinymce.DOM;
	tinymce.PluginManager.requireLangPack('pdw');
	
	tinymce.create('tinymce.plugins.pdw', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			var t = this, tbIds = new Array(), toolbars = new Array(), i;
			
			// Split toolbars
			toolbars = (ed.settings.pdw_toggle_toolbars).split(',');
			
			for(i = 0; i < toolbars.length; i++){
				tbIds[i] = ed.getParam('', 'toolbar' + (toolbars[i]).replace(' ',''));
			}
			
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand('mcePDWToggleToolbars', function() {
			
				var cm = ed.controlManager, id, j;
				
				for(j = 0; j < tbIds.length; j++){
					id = ed.controlManager.get(tbIds[j]).id;
				
					if (DOM.isHidden(id)) {
						cm.setActive('pdw_toggle', 0);
						DOM.show(id);
						t._resizeIframe(ed, tbIds[j], -26);
						ed.settings.pdw_toggle_on = 0;
					} else {
						cm.setActive('pdw_toggle', 1);
						DOM.hide(id);
						t._resizeIframe(ed, tbIds[j], 26);
						ed.settings.pdw_toggle_on = 1;
					}
				}
				
			});
			
			// Register pdw_toggle button
			ed.addButton('pdw_toggle', {
				title : ed.getLang('pdw.desc', 0),
				cmd : 'mcePDWToggleToolbars',
				image : url + '/img/toolbars.gif'
			});
			
			ed.onPostRender.add(function(){
				// If the setting pdw_toggle_on is set to 1 then hide toolbars and set button active
				if (ed.settings.pdw_toggle_on == 1) {

					var cm = ed.controlManager, tdId, id;
					
					for(i = 0; i < toolbars.length; i++){
						tbId = ed.getParam('', 'toolbar' + (toolbars[i]).replace(' ',''));
						id = ed.controlManager.get(tbId).id;
						cm.setActive('pdw_toggle', 1);
						DOM.hide(id);
						t._resizeIframe(ed, tbId, 26);
					}
				}
			});
		},
		
		// Resizes the iframe by a relative height value
		_resizeIframe : function(ed, tb_id, dy) {
			var ifr = ed.getContentAreaContainer().firstChild;

			DOM.setStyle(ifr, 'height', ifr.clientHeight + dy); // Resize iframe
			ed.theme.deltaHeight += dy; // For resize cookie
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'PDW Toggle Toolbars',
				author : 'Guido Neele',
				authorurl : 'http://www.neele.name/',
				infourl : 'http://www.neele.name/pdw_toggle_toolbars',
				version : "1.1"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('pdw', tinymce.plugins.pdw);
})();