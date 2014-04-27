<?php

use Pyro\Module\Addons\AbstractModule;
use Pyro\Module\Search\Model\Search;
use Pyro\Module\Pages\Model\Page as PageModel;

/**
 * Search module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Search
 */
class Module_Search extends AbstractModule
{
    public $version = '1.0.0';

    public $_tables = array('search_index');

    public function info()
    {
        return array(
            'name' => array(
                'en' => 'Search',
                'fr' => 'Recherche',
                'se' => 'Sök',
                'ar' => 'البحث',
                'tw' => '搜尋',
                'cn' => '搜寻',
                'it' => 'Ricerca',
                'fa' => 'جستجو',
                'fi' => 'Etsi',
                'km' => 'ស្វែងរក',
            ),
            'description' => array(
                'en' => 'Search through various types of content with this modular search system.',
                'fr' => 'Rechercher parmi différents types de contenus avec système de recherche modulaire.',
                'se' => 'Sök igenom olika typer av innehåll',
                'ar' => 'ابحث في أنواع مختلفة من المحتوى باستخدام نظام البحث هذا.',
                'tw' => '此模組可用以搜尋網站中不同類型的資料內容。',
                'cn' => '此模组可用以搜寻网站中不同类型的资料内容。',
                'it' => 'Cerca tra diversi tipi di contenuti con il sistema di reicerca modulare',
                'fa' => 'توسط این ماژول می توانید در محتواهای مختلف وبسایت جستجو نمایید.',
                'fi' => 'Etsi eri tyypistä sisältöä tällä modulaarisella hakujärjestelmällä.',
                'km' => 'ស្វែងរកតាមប្រភេទផ្សេងគ្នានៃមាតិកាជាមួយនឹងប្រព័ន្ធការស្វែងរកម៉ូឌុលនេះ។',
            ),
        );
    }

    public function install($pdb, $schema)
    {
        $schema->dropIfExists('search_index');

        $schema->create('search_index', function ($table) {
            $table->increments('id');
            $table->string('title', 255)->fulltext();
            $table->text('description')->fulltext();
            $table->text('keywords')->fulltext()->nullable();
            $table->text('keywords_hash')->nullable();
            $table->string('module', 40);
            $table->string('scope', 100);
            $table->string('entry_singular', 100);
            $table->string('entry_plural', 100);
            $table->string('entry_id', 193);
            $table->string('uri', 255);
            $table->string('cp_uri', 255);
            $table->text('group_access')->nullable();
            $table->text('user_access')->nullable();

            //   FULLTEXT KEY `full search` (`title`,`description`,`keywords`)

            $table->unique(array('module', 'scope', 'entry_id'));
        });

        ci()->load->library('keywords/keywords');

        foreach (PageModel::all() as $page) {

            // Only index live articles
            if ($page->status === 'live') {

                $hash = ci()->keywords->process($page->meta_keywords, $page);

                Search::index(
                    $module = 'pages',
                    $scope = 'def_page_fields.pages',
                    $singular = 'pages:page',
                    $plural = 'pages:pages',
                    $entry_id = $page->id,
                    $title = $page->title,
                    $description = $page->meta_description,
                    $keywords = $hash,
                    $uri = $page->uri,
                    $cp_uri = 'admin/pages/edit/'.$page->id,
                    $group_access = null,
                    $user_access = null
                );
            }
        }

        return true;
    }

    public function admin_menu()
    {
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
