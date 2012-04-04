<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_wysiwyg_config extends CI_Migration {

	public function up()
	{
		if ( ! $this->db->limit(1)->where('slug', 'ckeditor_config')->get('settings')->num_rows())
		{
			$this->db->insert('settings', array(
				'slug'			=> 'ckeditor_config',
				'title'			=> 'CKEditor Config',
				'description'	=> 'You can find a list of valid configuration items in <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditor\'s documentation.</a>',
				'`default`' 	=> false,
				'type'			=> 'textarea',
				'value'			=> "{{# this is the config for all wysiwyg-simple textareas #}}\n$('textarea.wysiwyg-simple').ckeditor({\n	toolbar: [\n		['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink']\n	  ],\n	width: '99%',\n	height: 100,\n	dialog_backgroundCoverColor: '#000',\n	defaultLanguage: '{{ helper:config item=\"default_language\" }}',\n	language: '{{ global:current_language }}'\n});\n\n{{# this is a wysiwyg-simple editor customized for the blog module (it allows images to be inserted) #}}\n$('textarea.blog.wysiwyg-simple').ckeditor({\n	toolbar: [\n		['pyroimages'],\n		['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink']\n	  ],\n	extraPlugins: 'pyroimages',\n	width: '99%',\n	height: 100,\n	dialog_backgroundCoverColor: '#000',\n	defaultLanguage: '{{ helper:config item=\"default_language\" }}',\n	language: '{{ global:current_language }}'\n});\n\n{{# and this is the advanced editor #}}\n$('textarea.wysiwyg-advanced').ckeditor({\n	toolbar: [\n		['Maximize'],\n		['pyroimages', 'pyrofiles'],\n		['Cut','Copy','Paste','PasteFromWord'],\n		['Undo','Redo','-','Find','Replace'],\n		['Link','Unlink'],\n		['Table','HorizontalRule','SpecialChar'],\n		['Bold','Italic','StrikeThrough'],\n		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl'],\n		['Format', 'FontSize', 'Subscript','Superscript', 'NumberedList','BulletedList','Outdent','Indent','Blockquote'],\n		['ShowBlocks', 'RemoveFormat', 'Source']\n	],\n	extraPlugins: 'pyroimages,pyrofiles',\n	width: '99%',\n	height: 400,\n	dialog_backgroundCoverColor: '#000',\n	removePlugins: 'elementspath',\n	defaultLanguage: '{{ helper:config item=\"default_language\" }}',\n	language: '{{ global:current_language }}'\n});",
				'`options`'		=> '0=Disabled|1=Enabled',
				'is_required'	=> true,
				'is_gui' 		=> true,
				'module' 		=> 'CKEditor',
				'order'			=> 994
			));
		}
	}

	public function down()
	{
		$this->db->delete('settings', array('module' => 'CKEditor'));
	}
}