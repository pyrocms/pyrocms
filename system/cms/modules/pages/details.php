<?php

use Pyro\Module\Addons\AbstractModule;
use Pyro\Module\Streams_core\Data;

/**
 * Pages Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Pages
 */
class Module_Pages extends AbstractModule
{
    public $version = '2.2.0';

    public function info()
    {
        $info = array(
            'name' => array(
                'en' => 'Pages',
                'ar' => 'الصفحات',
                'br' => 'Páginas',
                'pt' => 'Páginas',
                'cs' => 'Stránky',
                'da' => 'Sider',
                'de' => 'Seiten',
                'el' => 'Σελίδες',
                'es' => 'Páginas',
                'fi' => 'Sivut',
                'fr' => 'Pages',
                'he' => 'דפים',
                'id' => 'Halaman',
                'it' => 'Pagine',
                'lt' => 'Puslapiai',
                'nl' => 'Pagina&apos;s',
                'pl' => 'Strony',
                'ru' => 'Страницы',
                'sl' => 'Strani',
                'tw' => '頁面',
                'cn' => '页面',
                'hu' => 'Oldalak',
                'th' => 'หน้าเพจ',
                'se' => 'Sidor',
            ),
            'description' => array(
                'en' => 'Add custom pages to the site with any content you want.',
                'ar' => 'إضافة صفحات مُخصّصة إلى الموقع تحتوي أية مُحتوى تريده.',
                'br' => 'Adicionar páginas personalizadas ao site com qualquer conteúdo que você queira.',
                'pt' => 'Adicionar páginas personalizadas ao seu site com qualquer conteúdo que você queira.',
                'cs' => 'Přidávejte vlastní stránky na web s jakýmkoliv obsahem budete chtít.',
                'da' => 'Tilføj brugerdefinerede sider til dit site med det indhold du ønsker.',
                'de' => 'Füge eigene Seiten mit anpassbaren Inhalt hinzu.',
                'el' => 'Προσθέστε και επεξεργαστείτε σελίδες στον ιστότοπό σας με ό,τι περιεχόμενο θέλετε.',
                'es' => 'Agrega páginas customizadas al sitio con cualquier contenido que tu quieras.',
                'fi' => 'Lisää mitä tahansa sisältöä sivustollesi.',
                'fr' => "Permet d'ajouter sur le site des pages personalisées avec le contenu que vous souhaitez.",
                'he' => 'ניהול דפי תוכן האתר',
                'id' => 'Menambahkan halaman ke dalam situs dengan konten apapun yang Anda perlukan.',
                'it' => 'Aggiungi pagine personalizzate al sito con qualsiesi contenuto tu voglia.',
                'lt' => 'Pridėkite nuosavus puslapius betkokio turinio',
                'nl' => "Voeg aangepaste pagina&apos;s met willekeurige inhoud aan de site toe.",
                'pl' => 'Dodaj własne strony z dowolną treścią do witryny.',
                'ru' => 'Управление информационными страницами сайта, с произвольным содержимым.',
                'sl' => 'Dodaj stran s kakršno koli vsebino želite.',
                'tw' => '為您的網站新增自定的頁面。',
                'cn' => '为您的网站新增自定的页面。',
                'th' => 'เพิ่มหน้าเว็บที่กำหนดเองไปยังเว็บไซต์ของคุณตามที่ต้องการ',
                'hu' => 'Saját oldalak hozzáadása a weboldalhoz, akármilyen tartalommal.',
                'se' => 'Lägg till egna sidor till webbplatsen.',
            ),
            'frontend' => true,
            'backend'  => true,
            'skip_xss' => true,
            'menu'    => 'content',

            'roles' => array(
                'put_live', 'edit_live', 'delete_live'
            ),

            'sections' => array(
                'pages' => array(
                    'name' => 'pages:list_title',
                    'uri' => 'admin/pages',
                ),
                'types' => array(
                    'name' => 'page_types:list_title',
                    'uri' => 'admin/pages/types'
                ),
            ),
        );

        // Shortcuts for New page

        if (class_exists('Admin_Controller', false)) {

            // Do we have more than one page type? If we don't, no need to have a modal
            // ask them to choose a page type.
            if (ci()->pdb->table('page_types')->count() > 1) {
                $info['sections']['pages']['shortcuts'] = array(
                    array(
                        'name' => 'pages:create_title',
                        'uri' => 'admin/pages/choose_type',
                        'class' => 'btn-sm btn-success',
                        'data-toggle' => 'modal',
                        'data-target' => '#modal',
                        'data-hotkey' => 'n',
                        'data-follow' => 'yes',
                    )
                );
            } else {
                // Get the one page type.
                $page_type = ci()->pdb->table('page_types')->take(1)->select('id')->first();

                if ($page_type) {
                    $info['sections']['pages']['shortcuts'] = array(
                        array(
                            'name' => 'pages:create_title',
                            'uri' => 'admin/pages/create?page_type='.$page_type->id,
                            'class' => 'btn-sm btn-success',
                            'data-hotkey' => 'n',
                            'data-follow' => 'yes',
                        )
                    );
                }
            }
        }

        // Show the correct +Add button based on the page
        if (ci()->uri->segment(4) == 'fields' and ci()->uri->segment(5)) {
            $info['sections']['types']['shortcuts'] = array(
                array(
                    'name' => 'streams:new_field',
                    'uri' => 'admin/pages/types/fields/'.ci()->uri->segment(5).'/new_field',
                    'class' => 'btn-sm btn-success',
                    'data-hotkey' => 'n',
                    'data-follow' => 'yes',
                )
            );
        } else {
            $info['sections']['types']['shortcuts'] = array(
                array(
                    'name' => 'pages:types_create_title',
                    'uri' => 'admin/pages/types/create',
                    'class' => 'btn-sm btn-success',
                    'data-hotkey' => 'n',
                    'data-follow' => 'yes',
                )
            );
        }

        return $info;
    }

    public function install($pdb, $schema)
    {
        $schema->dropIfExists('page_types');

        $schema->create('page_types', function($table) {
            $table->increments('id');
            $table->string('slug', 255);
            $table->string('title', 60);
            $table->text('description')->nullable();
            $table->integer('stream_id');
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_keywords', 32)->nullable();
            $table->text('meta_description')->nullable();
            $table->text('body');
            $table->text('css')->nullable();
            $table->text('js')->nullable();
            $table->string('theme_layout', 100)->default('default');
            $table->integer('updated_on');
            $table->string('save_as_files', 1)->default('n');
            $table->string('content_label', 60)->nullable();
            $table->string('title_label', 100)->nullable();
        });

        // Pages Schema ----
        $schema->dropIfExists('pages');

        // Just in case. If this is a new install, we
        // definiitely should not have a page_chunks table.
        $schema->dropIfExists('page_chunks');

        $schema->create('pages', function($table) {
            $table->increments('id');

            $table->string('slug', 255)->nullable();
            $table->string('class', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->text('uri')->nullable();
            $table->integer('parent_id');
            $table->string('type_id', 255);
            $table->string('entry_id', 255)->nullable();
            $table->string('entry_type', 122);
            $table->text('css')->nullable();
            $table->text('js')->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_keywords', 32)->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('meta_robots_no_index')->nullable();
            $table->boolean('meta_robots_no_follow')->nullable();
            $table->integer('rss_enabled')->default(false);
            $table->integer('comments_enabled')->default(false);
            $table->enum('status', array('draft', 'live'))->default('draft');
            $table->string('restricted_to', 255)->nullable();
            $table->boolean('is_home')->default(false);
            $table->boolean('strict_uri')->default(true);
            $table->integer('order')->default(0);
            $table->integer('created_on');
            $table->integer('updated_on')->nullable();

            $table->index('slug');
            $table->index('parent_id');
        });

        // Remove pages namespace, just in case its a 2nd install
        Data\Utility::destroyNamespace('pages');

        ci()->load->config('pages/pages');

        // Def Page Fields Schema
        $schema->dropIfExists('def_page_fields');

        $stream = Data\Streams::addStream(
            'def_page_fields',
            'pages',
            'Default', // @todo - language
            null,
            'A basic page type to get you started adding content.' // @todo - language
        );

        // add the fields to the streams
        Data\Fields::addFields(config_item('pages:default_fields'), 'def_page_fields', 'pages');

        // Insert the page type structures
        $def_page_type_id = $pdb->table('page_types')->insertGetId(array(
            'id' => 1,
            'title' => 'Default',
            'slug' => 'default',
            'stream_id' => $stream->id,
            'body' => '<h2>{{ page:title }}</h2>'."\n\n".'{{ body }}',
            'css' => '',
            'js' => '',
            'updated_on' => time()
        ));

        $page_content = config_item('pages:default_page_content');
        $page_entries = array(
            'home' => array(
                'slug' => 'home',
                'title' => 'Home',
                'uri' => 'home',
                'parent_id' => 0,
                'type_id' => $def_page_type_id,
                'entry_type' => 'def_page_fields.pages',
                'status' => 'live',
                'restricted_to' => '',
                'created_on' => time(),
                'is_home' => 1,
                'order' => time()
            ),
            'contact' => array(
                'slug' => 'contact',
                'title' => 'Contact',
                'uri' => 'contact',
                'parent_id' => 0,
                'type_id' => $def_page_type_id,
                'entry_type' => 'def_page_fields.pages',
                'status' => 'live',
                'restricted_to' => '',
                'created_on' => time(),
                'is_home' => 0,
                'order' => time()
            ),
            'fourohfour' => array(
                'slug' => '404',
                'title' => 'Page missing',
                'uri' => '404',
                'parent_id' => 0,
                'type_id' => $def_page_type_id,
                'entry_type' => 'def_page_fields.pages',
                'status' => 'live',
                'restricted_to' => '',
                'created_on' => time(),
                'is_home' => 0,
                'order' => time()
            )
        );

        foreach ($page_entries as $key => $d) {
            // Contact Page
            $page_id = $pdb->table('pages')->insertGetId($d);

            $entry_id = $pdb->table('def_page_fields')->insertGetId($page_content[$key]);

            // Update the page with this entry_id
            $pdb->table('pages')
                ->where('id', $page_id)
                ->update(array('entry_id' => $entry_id));

            unset($page_id, $entry_id);
        }

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