<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration 128: Add full-page wysiwyg settings
 *
 * This allows you to use a full HTML template within the WYSIWYG
 * 
 * Added May 13th, 2013
 */

class Migration_Add_full_page_wysiwyg_settings extends CI_Migration
{
    public function up()
    {
        $setting = $this->db->select('slug, value')
            ->where('slug', 'ckeditor_config')
            ->get('settings')
            ->row();

        if ($setting)
        {
            $setting->value .= "\n\n{{# full page editor #}}\n$('textarea.wysiwyg-full').ckeditor({\n   toolbar: [\n        ['Maximize'],\n     ['pyroimages', 'pyrofiles'],\n      ['Cut','Copy','Paste','PasteFromWord'],\n       ['Undo','Redo','-','Find','Replace'],\n     ['Link','Unlink'],\n        ['Table','HorizontalRule','SpecialChar'],\n     ['Bold','Italic','StrikeThrough'],\n        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl'],\n        ['Format', 'FontSize', 'Subscript','Superscript', 'NumberedList','BulletedList','Outdent','Indent','Blockquote'],\n     ['ShowBlocks', 'RemoveFormat', 'Source']\n  ],\n    extraPlugins: 'pyroimages,pyrofiles',\n width: '99%',\n height: 400,\n  dialog_backgroundCoverColor: '#000',\n  removePlugins: 'elementspath',\n    defaultLanguage: '{{ helper:config item=\"default_language\" }}',\n   language: '{{ global:current_language }}',\n        fullPage: true\n});";
    
            $this->db->where('slug', $setting->slug)
                ->update('settings', array('value' => $setting->value));
        }
    }

    public function down()
    {
        return true;
    }
}