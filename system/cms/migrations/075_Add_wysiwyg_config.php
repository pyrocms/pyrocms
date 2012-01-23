<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_wysiwyg_config extends CI_Migration {

	public function up()
	{
		$this->db->query("INSERT INTO ".$this->db->dbprefix('settings')." (`slug`, `title`, `description`, `type`, `default`, `value`, `options`, `is_required`, `is_gui`, `module`, `order`) VALUES
						('ckeditor_config', 'CKEditor Config', 'You can find a list of valid configuration items in <a target=\"_blank\" href=\"http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html\">CKEditor\'s documentation.</a>', 'textarea', '', '{{# this is the config for all wysiwyg-simple textareas #}}\n$(''textarea.wysiwyg-simple'').ckeditor({\n	toolbar: [\n		[''Bold'', ''Italic'', ''-'', ''NumberedList'', ''BulletedList'', ''-'', ''Link'', ''Unlink'']\n	  ],\n	width: ''99%'',\n	height: 100,\n	dialog_backgroundCoverColor: ''#000'',\n	defaultLanguage: ''{{ helper:config item=\"default_language\" }}'',\n	language: ''{{ global:current_language }}''\n});\n\n{{# this is a wysiwyg-simple editor customized for the blog module (it allows images to be inserted) #}}\n$(''textarea.blog.wysiwyg-simple'').ckeditor({\n	toolbar: [\n		[''pyroimages''],\n		[''Bold'', ''Italic'', ''-'', ''NumberedList'', ''BulletedList'', ''-'', ''Link'', ''Unlink'']\n	  ],\n	extraPlugins: ''pyroimages'',\n	width: ''99%'',\n	height: 100,\n	dialog_backgroundCoverColor: ''#000'',\n	defaultLanguage: ''{{ helper:config item=\"default_language\" }}'',\n	language: ''{{ global:current_language }}''\n});\n\n{{# and this is the advanced editor #}}\n$(''textarea.wysiwyg-advanced'').ckeditor({\n	toolbar: [\n		[''Maximize''],\n		[''pyroimages'', ''pyrofiles''],\n		[''Cut'',''Copy'',''Paste'',''PasteFromWord''],\n		[''Undo'',''Redo'',''-'',''Find'',''Replace''],\n		[''Link'',''Unlink''],\n		[''Table'',''HorizontalRule'',''SpecialChar''],\n		[''Bold'',''Italic'',''StrikeThrough''],\n		[''JustifyLeft'',''JustifyCenter'',''JustifyRight'',''JustifyBlock'',''-'',''BidiLtr'',''BidiRtl''],\n		[''Format'', ''FontSize'', ''Subscript'',''Superscript'', ''NumberedList'',''BulletedList'',''Outdent'',''Indent'',''Blockquote''],\n		[''ShowBlocks'', ''RemoveFormat'', ''Source'']\n	],\n	extraPlugins: ''pyroimages,pyrofiles'',\n	width: ''99%'',\n	height: 400,\n	dialog_backgroundCoverColor: ''#000'',\n	removePlugins: ''elementspath'',\n	defaultLanguage: ''{{ helper:config item=\"default_language\" }}'',\n	language: ''{{ global:current_language }}''\n});', '', 1, 1, 'CKEditor', 994);");
	}

	public function down()
	{
		$this->db->delete('settings', array('module' => 'CKEditor'));
	}
}