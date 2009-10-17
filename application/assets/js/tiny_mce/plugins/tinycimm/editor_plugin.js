(function() {
	//tinymce.PluginManager.requireLangPack('tinycimmimage');

	tinymce.create('tinymce.plugins.TinyCIMM', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {

			ed.addCommand('mceTinyCIMM-Image', function(resize) {
				ed.windowManager.open({
					file : url + '/image.htm',
					width : 574,
					height : 462,
					inline : 1
				}, {
					plugin_url : url,
					resize : resize
				});
			});

			ed.addCommand('mceTinyCIMM-Media', function(resize){
				ed.windowManager.open({
					file : url + '/media.htm',
					width : 574,
					height : 462,
					inline : 1
				}, {
					plugin_url : url,
					resize : resize
				});
			});

			// register image manager button
			ed.addButton('tinycimm-image', {
				title : 'Image Manager',
				cmd : 'mceTinyCIMM-Image',
				image : url + '/img/insertimage.gif'
			});

			// register media manager button
			ed.addButton('tinycimm-media', {
				title : 'Media Manager',
				cmd : 'mceTinyCIMM-Media',
				image : url + '/img/insertmedia.gif'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('tinycimm-image', n.nodeName == 'IMG');
			});
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'TinyCIMM',
				author : 'Richard Willis',
				authorurl : 'http://badsyntax.co.uk',
				infourl : 'http://tinycimm.googlecode.com/',
				version : "0.1"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('tinycimm', tinymce.plugins.TinyCIMM);
})();
