<?php

use Pyro\Module\Addons\AbstractModule;
use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\Stream\StreamSchema;
use Pyro\Module\Streams\Stream\StreamModel;

/**
 * Pages Module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Pages
 */
class Module_Pages extends AbstractModule
{
    public $version = '2.2.0';

    public function info()
    {
        $info = array(
            'name'        => array(
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
                'km' => 'ទំព័រ',
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
                'km' => 'បន្ថែមទំព័រផ្ទាល់ខ្លួនទៅតំបន់បណ្តាញជាមួយនឹងមាតិកាណាមួយដែលអ្នកចង់បាន។',
            ),
            'frontend'    => true,
            'backend'     => true,
            'skip_xss'    => true,
            'menu'        => 'content',
            'roles'       => array(
                'put_live',
                'edit_live',
                'delete_live'
            ),
            'sections'    => array(
                'pages' => array(
                    'name' => 'pages:list_title',
                    'uri'  => 'admin/pages',
                ),
                'types' => array(
                    'name' => 'page_types:list_title',
                    'uri'  => 'admin/pages/types'
                ),
            ),
        );

        // Shortcuts for New page

        if (class_exists('Admin_Controller', false)) {

            // Do we have more than one page type? If we don't, no need to have a modal
            // ask them to choose a page type.
            if (!$pageTypesCount = ci()->cache->get('pageTypesCount')) {
                $pageTypesCount = ci()->pdb->table('page_types')->count();
                ci()->cache->put('pageTypesCount', $pageTypesCount, 30);
            }

            if ($pageTypesCount > 1) {
                $info['sections']['pages']['shortcuts'] = array(
                    array(
                        'name'  => 'pages:create_title',
                        'uri'   => 'admin/pages/choose_type',
                        'class' => 'add modal'
                    )
                );
            } else {
                // Get the one page type.
                $page_type = ci()->pdb->table('page_types')->take(1)->select('id')->first();

                if ($page_type) {
                    $info['sections']['pages']['shortcuts'] = array(
                        array(
                            'name'  => 'pages:create_title',
                            'uri'   => 'admin/pages/create?page_type=' . $page_type->id,
                            'class' => 'add'
                        )
                    );
                }
            }
        }

        // Show the correct +Add button based on the page
        if (ci()->uri->segment(4) == 'fields' and ci()->uri->segment(5)) {
            $info['sections']['types']['shortcuts'] = array(
                array(
                    'name'  => 'streams:new_field',
                    'uri'   => 'admin/pages/types/fields/' . ci()->uri->segment(5) . '/new_field',
                    'class' => 'add'
                )
            );
        } else {
            $info['sections']['types']['shortcuts'] = array(
                array(
                    'name'  => 'pages:types_create_title',
                    'uri'   => 'admin/pages/types/create',
                    'class' => 'add'
                )
            );
        }

        return $info;
    }

    public function install($pdb, $schema)
    {
        $schema->dropIfExists('page_types');

        $schema->create(
            'page_types',
            function ($table) {
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
                $table->string('save_as_files', 1)->default('n');
                $table->string('content_label', 60)->nullable();
                $table->string('title_label', 100)->nullable();
                $table->dateTime('created_at');
                $table->dateTime('updated_at')->nullable();
            }
        );

        // Pages Schema ----
        $schema->dropIfExists('pages');

        // Just in case. If this is a new install, we
        // definiitely should not have a page_chunks table.
        $schema->dropIfExists('page_chunks');

        $schema->create(
            'pages',
            function ($table) {
                $table->increments('id');

                $table->string('slug', 255)->nullable();
                $table->string('title', 255)->nullable();
                $table->text('uri')->nullable();
                $table->integer('parent_id');
                $table->string('type_id', 255);
                $table->string('entry_id', 255)->nullable();
                $table->string('entry_type', 122);
                $table->boolean('is_home')->default(false);
                $table->integer('order')->default(0);
                $table->enum('status', array('draft', 'live'))->default('draft');

                $table->index('slug');
                $table->index('parent_id');
            }
        );

        // Remove pages namespace, just in case its a 2nd install
        StreamSchema::destroyNamespace('pages');

        $schema->dropIfExists('def_page_fields');

        ci()->load->config('pages/pages');

        $stream = StreamModel::addStream(
            'def_page_fields',
            'pages',
            'Default', // @todo - language
            null,
            'A basic page type to get you started adding content.' // @todo - language
        );

        $fields = array(
            /*array(
                'name'        => 'lang:pages:uri',
                'slug'        => 'uri',
                'type'        => 'text',
                'is_required' => true,
                'is_locked'   => true,
            ),
            array(
                'name'        => 'lang:pages:parent_id',
                'slug'        => 'parent',
                'type'        => 'relationship',
                'is_required' => true,
                'is_locked'   => true,
                'extra'       => array(
                    'relation_class' => 'Pyro\Module\Pages\Model\Page',
                )
            ),
            array(
                'name'        => 'lang:pages:type_id',
                'slug'        => 'type',
                'type'        => 'relationship',
                'is_required' => true,
                'is_locked'   => true,
                'extra'       => array(
                    'relation_class' => 'Pyro\Module\Pages\Model\PageType',
                )
            ),
            array(
                'name'        => 'lang:pages:entry',
                'slug'        => 'entry',
                'type'        => 'polymorphic',
                'is_required' => true,
                'is_locked'   => true,
            ),*/
            array(
                'name'      => 'lang:pages:body_label',
                'slug'      => 'body',
                'type'      => 'wysiwyg',
                'is_locked' => true,
                'extra'     => array(
                    'editor_type' => 'advanced',
                    'allow_tags'  => 'y',
                ),
            ),
            array(
                'name'         => 'lang:global:title',
                'slug'         => 'title',
                'type'         => 'text',
                'title_column' => true,
                'is_required'  => true,
                'is_locked'    => true,
                'extra'        => array(
                    'max_length' => 255
                ),
            ),
            array(
                'name'        => 'lang:global:slug',
                'slug'        => 'slug',
                'type'        => 'slug',
                'is_required' => true,
                'is_locked'   => true,
                'extra'       => array(
                    'max_length'     => 255,
                    'namespace'      => 'pages',
                    'slug_field'     => 'title',
                    'form_input_row' => 'module::pages/fields/slug'
                ),
            ),
            array(
                'name'      => 'lang:global:class',
                'slug'      => 'class',
                'type'      => 'text',
                'is_locked' => true,
                'extra'     => array(
                    'max_length' => 255
                ),
            ),
            array(
                'name'      => 'lang:pages:css_label',
                'slug'      => 'css',
                'type'      => 'textarea',
                'is_locked' => true,
            ),
            array(
                'name'      => 'lang:pages:js_label',
                'slug'      => 'js',
                'type'      => 'textarea',
                'is_locked' => true,
            ),
            array(
                'name'      => 'lang:pages:meta_title_label',
                'slug'      => 'meta_title',
                'type'      => 'text',
                'is_locked' => true,
            ),
            array(
                'name'      => 'lang:pages:meta_keywords_label',
                'slug'      => 'meta_keywords',
                'type'      => 'keywords',
                'is_locked' => true,
            ),
            array(
                'name'      => 'lang:pages:meta_desc_label',
                'slug'      => 'meta_description',
                'type'      => 'textarea',
                'is_locked' => true,
            ),
            array(
                'name'      => 'lang:pages:meta_robots_no_index_label',
                'slug'      => 'meta_robots_no_index',
                'type'      => 'choice',
                'is_locked' => true,
                'extra'     => array(
                    'choice_data' => '1 :  ',
                    'choice_type' => 'checkboxes'
                ),
            ),
            array(
                'name'      => 'lang:pages:meta_robots_no_follow_label',
                'slug'      => 'meta_robots_no_follow',
                'type'      => 'choice',
                'is_locked' => true,
                'extra'     => array(
                    'choice_data' => '1 :  ',
                    'choice_type' => 'checkboxes'
                ),
            ),
            array(
                'name'      => 'lang:pages:rss_enabled_label',
                'slug'      => 'rss_enabled',
                'type'      => 'choice',
                'is_locked' => true,
                'extra'     => array(
                    'choice_data' => '1 :  ',
                    'choice_type' => 'checkboxes'
                ),
            ),
            array(
                'name'      => 'lang:pages:comments_enabled_label',
                'slug'      => 'comments_enabled',
                'type'      => 'choice',
                'default'   => 0,
                'is_locked' => true,
                'extra'     => array(
                    'choice_data' => '1 :  ',
                    'choice_type' => 'checkboxes'
                ),
            ),
            array(
                'name'      => 'lang:pages:status_label',
                'slug'      => 'status',
                'type'      => 'choice',
                'is_locked' => true,
                'default'   => 'draft',
                'extra'     => array(
                    'choice_data' => "draft : lang:pages:draft_label\n
                                        live : lang:pages:live_label\n"
                ),
            ),
            array(
                'name'      => 'lang:pages:is_home_label',
                'slug'      => 'is_home',
                'type'      => 'choice',
                'default'   => 0,
                'is_locked' => true,
                'extra'     => array(
                    'choice_data' => '1 :  ',
                    'choice_type' => 'checkboxes'
                ),
            ),
            array(
                'name'      => 'lang:pages:strict_uri_label',
                'slug'      => 'strict_uri',
                'type'      => 'choice',
                'default'   => 1,
                'is_locked' => true,
                'extra'     => array(
                    'choice_data' => '1 :  ',
                    'choice_type' => 'checkboxes'
                ),
            ),
            array(
                'name'      => 'lang:pages:access_label',
                'slug'      => 'restricted_to',
                'type'      => 'multiple',
                'is_locked' => true,
                'extra'     => array(
                    'relation_class' => 'Pyro\Module\Pages\FieldType\GroupModel'
                ),
            ),
        );

        FieldModel::addFields($fields, null, 'pages');

        /*FieldModel::assignField('pages', 'pages', 'slug', array('is_required' => true));
        FieldModel::assignField('pages', 'pages', 'uri', array('is_required' => true));
        FieldModel::assignField('pages', 'pages', 'parent', array('is_required' => true));
        FieldModel::assignField('pages', 'pages', 'type', array('is_required' => true));
        FieldModel::assignField('pages', 'pages', 'entry', array('is_required' => true));
        FieldModel::assignField('pages', 'pages', 'is_home', array('is_required' => true));*/

        FieldModel::assignField('def_page_fields', 'pages', 'body', array());
        FieldModel::assignField('def_page_fields', 'pages', 'title', array('is_required' => true));
        FieldModel::assignField('def_page_fields', 'pages', 'slug', array('is_required' => true));
        FieldModel::assignField('def_page_fields', 'pages', 'class', array());
        FieldModel::assignField('def_page_fields', 'pages', 'css', array());
        FieldModel::assignField('def_page_fields', 'pages', 'js', array());
        FieldModel::assignField('def_page_fields', 'pages', 'restricted_to', array());
        FieldModel::assignField('def_page_fields', 'pages', 'meta_title', array());
        FieldModel::assignField('def_page_fields', 'pages', 'meta_keywords', array());
        FieldModel::assignField('def_page_fields', 'pages', 'meta_description', array());
        FieldModel::assignField('def_page_fields', 'pages', 'meta_robots_no_index', array());
        FieldModel::assignField('def_page_fields', 'pages', 'meta_robots_no_follow', array());
        FieldModel::assignField('def_page_fields', 'pages', 'rss_enabled', array());
        FieldModel::assignField('def_page_fields', 'pages', 'rss_enabled', array());
        FieldModel::assignField('def_page_fields', 'pages', 'comments_enabled', array());
        FieldModel::assignField('def_page_fields', 'pages', 'status', array('is_required' => true));
        FieldModel::assignField('def_page_fields', 'pages', 'is_home', array());
        FieldModel::assignField('def_page_fields', 'pages', 'strict_uri', array());

        // Insert the page type structures
        $def_page_type_id = $pdb->table('page_types')->insertGetId(
            array(
                'id'         => 1,
                'title'      => 'Default',
                'slug'       => 'default',
                'stream_id'  => $stream->id,
                'body'       => '<h2>{{ page:title }}</h2>' . "\n\n" . '{{ body }}',
                'css'        => '',
                'js'         => '',
                'created_at' => date('Y-m-d H:i:s'),
            )
        );

        $pageEntryModel = $stream->getEntryModelClass('def_page_fields', 'pages');

        /**
         * Insert default page types
         */
        $page_content = config_item('pages:default_page_content');
        $page_entries = array(
            'home'       => array(
                'title'      => 'Home',
                'uri'        => 'home',
                'parent_id'  => 0,
                'type_id'    => $def_page_type_id,
                'entry_type' => $pageEntryModel,
                'status'     => 'live',
                'is_home'    => true,
                'order'      => time()
            ),
            'contact'    => array(
                'title'      => 'Contact',
                'uri'        => 'contact',
                'parent_id'  => 0,
                'type_id'    => $def_page_type_id,
                'entry_type' => $pageEntryModel,
                'status'     => 'live',
                'is_home'    => false,
                'order'      => time()
            ),
            'fourohfour' => array(
                'title'      => 'Page missing',
                'uri'        => '404',
                'parent_id'  => 0,
                'type_id'    => $def_page_type_id,
                'entry_type' => $pageEntryModel,
                'status'     => 'live',
                'is_home'    => 0,
                'order'      => time()
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
