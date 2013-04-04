<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Widgets Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Widgets
 */
class Module_WYSIWYG extends Module
{

        public $version = '1.0.0';

        public function info()
        {
                return array(
                    'name' => array(
                        'en' => 'WYSIWYG',
                        'fa' => 'WYSIWYG',
                        'fr' => 'WYSIWYG',
                        'pt' => 'WYSIWYG',
                        'se' => 'HTML-redigerare',
                        'tw' => 'WYSIWYG',
                        'cn' => 'WYSIWYG',
                        'ar' => 'المحرر الرسومي',
                        'it' => 'WYSIWYG',
                    ),
                    'description' => array(
                        'en' => 'Provides the WYSIWYG editor for PyroCMS powered by CKEditor.',
                        'fa' => 'ویرایشگر WYSIWYG که توسطCKEditor ارائه شده است. ',
                        'fr' => 'Fournit un éditeur WYSIWYG pour PyroCMS propulsé par CKEditor',
                        'pt' => 'Fornece o editor WYSIWYG para o PyroCMS, powered by CKEditor.',
                        'el' => 'Παρέχει τον επεξεργαστή WYSIWYG για το PyroCMS, χρησιμοποιεί το CKEDitor.',
                        'se' => 'Redigeringsmodul för HTML, CKEditor.',
                        'tw' => '提供 PyroCMS 所見即所得（WYSIWYG）編輯器，由 CKEditor 技術提供。',
                        'cn' => '提供 PyroCMS 所见即所得（WYSIWYG）编辑器，由 CKEditor 技术提供。',
                        'ar' => 'توفر المُحرّر الرسومي لـPyroCMS من خلال CKEditor.',
                        'it' => 'Fornisce l\'editor WYSIWYG per PtroCMS creato con CKEditor',
                    ),
                    'frontend' => false,
                    'backend' => false,
                );
        }

        public function install()
        {
                $this->db->insert('settings', array(
                    'slug' => 'ckeditor_config',
                    'title' => 'CKEditor Config',
                    'description' => 'You can find a list of valid configuration items in <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditor\'s documentation.</a>',
                    'type' => 'textarea',
                    'default' => '',
                    'value' => "{{# this is a wysiwyg-simple editor customized for the blog module (it allows images to be inserted) #}}\n$('textarea#intro.wysiwyg-simple').ckeditor({\n	toolbar: [\n		['pyroimages'],\n		['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink']\n	  ],\n	extraPlugins: 'pyroimages',\n	width: '99%',\n	height: 100,\n	dialog_backgroundCoverColor: '#000',\n	defaultLanguage: '{{ helper:config item=\"default_language\" }}',\n	language: '{{ global:current_language }}'\n});\n\n{{# this is the config for all wysiwyg-simple textareas #}}\n$('textarea.wysiwyg-simple').ckeditor({\n	toolbar: [\n		['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink']\n	  ],\n	width: '99%',\n	height: 100,\n	dialog_backgroundCoverColor: '#000',\n	defaultLanguage: '{{ helper:config item=\"default_language\" }}',\n	language: '{{ global:current_language }}'\n});\n\n{{# and this is the advanced editor #}}\n$('textarea.wysiwyg-advanced').ckeditor({\n	toolbar: [\n		['Maximize'],\n		['pyroimages', 'pyrofiles'],\n		['Cut','Copy','Paste','PasteFromWord'],\n		['Undo','Redo','-','Find','Replace'],\n		['Link','Unlink'],\n		['Table','HorizontalRule','SpecialChar'],\n		['Bold','Italic','StrikeThrough'],\n		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl'],\n		['Format', 'FontSize', 'Subscript','Superscript', 'NumberedList','BulletedList','Outdent','Indent','Blockquote'],\n		['ShowBlocks', 'RemoveFormat', 'Source']\n	],\n	extraPlugins: 'pyroimages,pyrofiles',\n	width: '99%',\n	height: 400,\n	dialog_backgroundCoverColor: '#000',\n	removePlugins: 'elementspath',\n	defaultLanguage: '{{ helper:config item=\"default_language\" }}',\n	language: '{{ global:current_language }}'\n});",
                    'options' => '',
                    'is_required' => 1,
                    'is_gui' => 1,
                    'module' => 'wysiwyg',
                    'order' => 993,
                ));

                return true;
        }

        public function uninstall()
        {
                // This is a core module, lets keep it around.
                return false;
        }

        public function upgrade($old_version)
        {
                return true;
        }

}
