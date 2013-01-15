<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Pages Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Pages
 */
class Module_Pages extends Module
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
            if ($this->pdb->table('page_types')->count() > 1) {
                $info['sections']['pages']['shortcuts'] = array(
                    array(
                        'name' => 'pages:create_title',
                        'uri' => 'admin/pages/choose_type',
                        'class' => 'add modal'
                    )
                );
            }
            else {
                // Get the one page type. 
                $page_type = $this->pdb->table('page_types')->take(1)->select('id')->first();

                if ($page_type) {
                    $info['sections']['pages']['shortcuts'] = array(
                        array(
                            'name' => 'pages:create_title',
                            'uri' => 'admin/pages/create?page_type='.$page_type->id,
                            'class' => 'add'
                        )
                    );          
                }
            }
        }

        // Show the correct +Add button based on the page
        if ($this->uri->segment(4) == 'fields' and $this->uri->segment(5))
        {
            $info['sections']['types']['shortcuts'] = array(
                array(
                    'name' => 'streams:new_field',
                    'uri' => 'admin/pages/types/fields/'.$this->uri->segment(5).'/new_field',
                    'class' => 'add'
                )
            );
        }
        else
        {
            $info['sections']['types']['shortcuts'] = array(
                array(
                    'name' => 'pages:types_create_title',
                    'uri' => 'admin/pages/types/create',
                    'class' => 'add'
                )
            );          
        }

        return $info;
    }

    public function install()
    {
        $schema = $this->pdb->getSchemaBuilder();
        $schema->dropIfExists('page_types');

        $schema->create('page_types', function($table) {
            $table->increments('id');
            $table->string('slug', 255);
            $table->string('title', 60);
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

        $schema->create('pages', function($table) {
            $table->increments('id');

            $table->string('slug', 255)->nullable();
            $table->string('class', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->text('uri')->nullable();
            $table->integer('parent_id');
            $table->string('type_id', 255);
            $table->string('entry_id', 255)->nullable();
            $table->text('css')->nullable();
            $table->text('js')->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_keywords', 32)->nullable();
            $table->text('meta_description')->nullable();
            $table->integer('rss_enabled')->default(false);
            $table->integer('comments_enabled')->default(false);
            $table->enum('status', array('draft', 'live'))->default('draft');
            $table->integer('created_on');
            $table->integer('updated_on')->nullable();
            $table->string('restricted_to', 255)->nullable();
            $table->boolean('is_home')->default(false);
            $table->boolean('strict_uri')->default(true);
            $table->integer('order')->default(0);

            $table->index('slug');
            $table->index('parent_id');
        });

        $this->load->driver('Streams');

/* @TODO Adam - Convert all stream logic within over to eloquent 

        // Remove pages namespace, just in case its a 2nd install
        $this->streams->utilities->remove_namespace('pages');

        // Remove existing page streams
        $this->pdb
            ->table('data_streams')
            ->where('stream_namespace', '=', 'pages')
            ->delete();

        $this->load->config('pages/pages');

        // Def Page Fields Schema
        $schema->dropIfExists('def_page_fields');

        $stream_id = $this->streams->streams->add_stream(
            'Default',
            'def_page_fields',
            'pages',
            null,
            'A basic page type to get you started adding content.'
        );
    
        // add the fields to the streams
        $this->streams->fields->add_fields(config_item('pages:default_fields'));

        // Insert the page type structures      
        $def_page_type_id = $this->pdb->table('page_types')->insert(array(
            'id' => 1,
            'title' => 'Default',
            'slug' => 'default',
            'stream_id' => $stream_id,
            'body' => '<h2>{{ page:title }}</h2>'."\n\n".'{{ body }}',
            'css' => '',
            'js' => '',
            'updated_on' => now()
        ));

        $page_content = config_item('pages:default_page_content');
        $page_entries = array(
            'home' => array(
                'slug' => 'home',
                'title' => 'Home',
                'uri' => 'home',
                'parent_id' => 0,
                'type_id' => $def_page_type_id,
                'status' => 'live',
                'restricted_to' => '',
                'created_on' => now(),
                'is_home' => 1,
                'order' => now()
            ),
            'contact' => array(
                'slug' => 'contact',
                'title' => 'Contact',
                'uri' => 'contact',
                'parent_id' => 0,
                'type_id' => $def_page_type_id,
                'status' => 'live',
                'restricted_to' => '',
                'created_on' => now(),
                'is_home' => 0,
                'order' => now()
            ),
            'fourohfour' => array(
                'slug' => '404',
                'title' => 'Page missing',
                'uri' => '404',
                'parent_id' => 0,
                'type_id' => $def_page_type_id,
                'status' => 'live',
                'restricted_to' => '',
                'created_on' => now(),
                'is_home' => 0,
                'order' => now()
            )
        );

        foreach ($page_entries as $key => $d)
        {
            // Contact Page
            $page_id = $this->pdb->table('pages')->insert($d);

            $entry_id = $this->pdb->table('def_page_fields')->insert($page_content[$key]);

            // Update the page with this entry_id
            $this->pdb->table('pages')->where('id', $page_id)->update(array('entry_id' => $entry_id));

            unset($page_id, $entry_id);
        }
    */

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