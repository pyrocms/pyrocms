<?php

use Pyro\Module\Addons\AbstractModule;

/**
 * Keywords module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Keywords
 */
class Module_Keywords extends AbstractModule
{
    public $version = '1.1.0';

    public $_tables = array('keywords', 'keywords_applied');

    public function info()
    {
        return array(
            'name' => array(
                'en' => 'Keywords',
                'ar' => 'كلمات البحث',
                'br' => 'Palavras-chave',
                'pt' => 'Palavras-chave',
                'da' => 'Nøgleord',
                'el' => 'Λέξεις Κλειδιά',
                'fr' => 'Mots-Clés',
                'id' => 'Kata Kunci',
                'nl' => 'Sleutelwoorden',
                'zh' => '鍵詞',
                'hu' => 'Kulcsszavak',
                'fi' => 'Avainsanat',
                'sl' => 'Ključne besede',
                'th' => 'คำค้น',
                'se' => 'Nyckelord',
                'km' => 'ពាក្យគន្លឹះ',
            ),
            'description' => array(
                'en' => 'Maintain a central list of keywords to label and organize your content.',
                'ar' => 'أنشئ مجموعة من كلمات البحث التي تستطيع من خلالها وسم وتنظيم المحتوى.',
                'br' => 'Mantém uma lista central de palavras-chave para rotular e organizar o seu conteúdo.',
                'pt' => 'Mantém uma lista central de palavras-chave para rotular e organizar o seu conteúdo.',
                'da' => 'Vedligehold en central liste af nøgleord for at organisere dit indhold.',
                'el' => 'Συντηρεί μια κεντρική λίστα από λέξεις κλειδιά για να οργανώνετε μέσω ετικετών το περιεχόμενό σας.',
                'fr' => 'Maintenir une liste centralisée de Mots-Clés pour libeller et organiser vos contenus.',
                'id' => 'Memantau daftar kata kunci untuk melabeli dan mengorganisasikan konten.',
                'nl' => 'Beheer een centrale lijst van sleutelwoorden om uw content te categoriseren en organiseren.',
                'zh' => '集中管理可用於標題與內容的鍵詞(keywords)列表。',
                'hu' => 'Ez egy központi kulcsszó lista a cimkékhez és a tartalmakhoz.',
                'fi' => 'Hallinnoi keskitettyä listaa avainsanoista merkitäksesi ja järjestelläksesi sisältöä.',
                'sl' => 'Vzdržuj centralni seznam ključnih besed za označevanje in ogranizacijo vsebine.',
                'th' => 'ศูนย์กลางการปรับปรุงคำค้นในการติดฉลากและจัดระเบียบเนื้อหาของคุณ',
                'se' => 'Hantera nyckelord för att organisera webbplatsens innehåll.',
                'km' => 'រក្សាបញ្ជីកណ្តាលនៃពាក្យគន្លឹះទៅនឹងស្លាកនិងរៀបចំមាតិការបស់អ្នក។',
            ),
            'frontend' => false,
            'backend'  => true,
            'menu'     => 'data',
            'shortcuts' => array(
                array(
                   'name' => 'keywords:add_title',
                   'uri' => 'admin/keywords/add',
                   'class' => 'add',
                ),
            ),
        );
    }

    public function install($pdb, $schema)
    {
        $schema->dropIfExists('keywords');

        $schema->create('keywords', function($table) {
            $table->increments('id');
            $table->string('name', 50);
        });

        $schema->dropIfExists('keywords_applied');

        $schema->create('keywords_applied', function($table) {
            $table->integer('keyword_id');
            $table->integer('entry_id');
            $table->string('entry_type', 250);
            $table->string('module', 50);
        });

        return true;
    }

    public function uninstall($pdb, $schema)
    {
        // This is a core module, lets keep it around.
        return false;
    }

    public function upgrade($old_version)
    {
        return true;
    }

}
