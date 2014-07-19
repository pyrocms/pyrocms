<?php

use Pyro\Module\Addons\AbstractModule;
use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\Stream\StreamSchema;
use Pyro\Module\Streams\Stream\StreamModel;
use Pyro\Module\Streams\FieldType\FieldTypeManager;

/**
 * Blog module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Blog
 */
class Module_Blog extends AbstractModule
{
    public $version = '2.0.0';

    public function info()
    {
        $info = array(
            'name'        => array(
                'en' => 'Blog',
                'ar' => 'المدوّنة',
                'br' => 'Blog',
                'pt' => 'Blog',
                'el' => 'Ιστολόγιο',
                'fa' => 'بلاگ',
                'he' => 'בלוג',
                'id' => 'Blog',
                'lt' => 'Blogas',
                'pl' => 'Blog',
                'ru' => 'Блог',
                'tw' => '文章',
                'cn' => '文章',
                'hu' => 'Blog',
                'fi' => 'Blogi',
                'th' => 'บล็อก',
                'se' => 'Blogg',
                'km' => 'Blog',
            ),
            'description' => array(
                'en' => 'Post blog entries.',
                'ar' => 'أنشر المقالات على مدوّنتك.',
                'br' => 'Escrever publicações de blog',
                'pt' => 'Escrever e editar publicações no blog',
                'cs' => 'Publikujte nové články a příspěvky na blog.', #update translation
                'da' => 'Skriv blogindlæg',
                'de' => 'Veröffentliche neue Artikel und Blog-Einträge', #update translation
                'sl' => 'Objavite blog prispevke',
                'fi' => 'Kirjoita blogi artikkeleita.',
                'el' => 'Δημιουργήστε άρθρα και εγγραφές στο ιστολόγιο σας.',
                'es' => 'Escribe entradas para los artículos y blog (web log).', #update translation
                'fa' => 'مقالات منتشر شده در بلاگ',
                'fr' => 'Poster des articles d\'actualités.',
                'he' => 'ניהול בלוג',
                'id' => 'Post entri blog',
                'it' => 'Pubblica notizie e post per il blog.', #update translation
                'lt' => 'Rašykite naujienas bei blog\'o įrašus.',
                'nl' => 'Post nieuwsartikelen en blogs op uw site.',
                'pl' => 'Dodawaj nowe wpisy na blogu',
                'ru' => 'Управление записями блога.',
                'tw' => '發表新聞訊息、部落格等文章。',
                'cn' => '发表新闻讯息、部落格等文章。',
                'th' => 'โพสต์รายการบล็อก',
                'hu' => 'Blog bejegyzések létrehozása.',
                'se' => 'Inlägg i bloggen.',
                'km' => 'ប្រកាសធាតុ blog',
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
                'posts'      => array(
                    'name'      => 'blog:posts_title',
                    'uri'       => 'admin/blog',
                    'shortcuts' => array(
                        array(
                            'name'  => 'blog:create_title',
                            'uri'   => 'admin/blog/create',
                            'class' => 'add',
                        ),
                    ),
                ),
                'categories' => array(
                    'name'      => 'cat:list_title',
                    'uri'       => 'admin/blog/categories',
                    'shortcuts' => array(
                        array(
                            'name'  => 'cat:create_title',
                            'uri'   => 'admin/blog/categories/create',
                            'class' => 'add',
                        ),
                    ),
                ),
            ),
        );

        if (function_exists('group_has_role')) {
            if (group_has_role('blog', 'admin_blog_fields')) {
                $info['sections']['fields'] = array(
                    'name'      => 'global:custom_fields',
                    'uri'       => 'admin/blog/fields',
                    'shortcuts' => array(
                        'create' => array(
                            'name'  => 'streams:add_field',
                            'uri'   => 'admin/blog/fields/create',
                            'class' => 'add'
                        )
                    )
                );
            }
        }

        return $info;
    }

    /**
     * Install
     * This function is run to install the module
     *
     * @return bool
     */
    public function install($pdb, $schema)
    {
        $schema->dropIfExists('blog_categories');
        $schema->dropIfExists('blog');

        $schema->create(
            'blog_categories',
            function ($table) {
                $table->increments('id');
                $table->string('slug', 100)->nullable()->unique();
                $table->string('title', 100)->nullable()->unique();
            }
        );

        $this->addFields();

        // Add fields to streamsy table
        /*		$schema->table('blog', function($table) {
                    //$table->string('slug', 200)->unique();
                    //$table->string('title', 200)->unique();
                    //$table->integer('category_id');
                    //$table->string('attachment', 255)->default('');
                    //$table->text('body');
                    //$table->text('parsed');
                    //$table->string('keywords', 32)->default('');
                    //$table->integer('author_id')->nullable();
                    //$table->enum('comments_enabled', array('no','1 day','1 week','2 weeks','1 month', '3 months', 'always'))->default('3 months');
                    //$table->enum('status', array('draft', 'live'))->default('draft');
                    //$table->enum('type', array('html', 'markdown', 'wysiwyg-advanced', 'wysiwyg-simple'));
                    //$table->string('preview_hash', 32)->nullable();
                    //$table->index('slug');
                    //$table->index('category_id');
                });*/

        return true;
    }

    public function addFields()
    {
        StreamSchema::destroyNamespace('blogs');

        StreamModel::addStream(
            'blog',
            'blogs',
            'lang:blog:blog_title'
        );

        FieldTypeManager::registerFolderFieldTypes(APPPATH . '/modules/streams_core/field_types/', true);

        $comments_enabled_options = array(
            'no'       => 'lang:global:no',
            '1 day'    => 'lang:global:duration:1-day',
            '1 week'   => 'lang:global:duration:1-week',
            '2 weeks'  => 'lang:global:duration:2-weeks',
            '1 month'  => 'lang:global:duration:1-month',
            '3 months' => 'lang:global:duration:3-months',
            'always'   => 'lang:global:duration:always',
        );

        $comments_enabled_choice_data = '';

        foreach ($comments_enabled_options as $key => $value) {
            $comments_enabled_choice_data .= $key . ' : ' . $value . "\n";
        }

        $status_options = array(
            'draft' => 'lang:blog:draft_label',
            'live'  => 'lang:blog:live_label',
        );

        $status_choice_data = '';

        foreach ($status_options as $key => $value) {
            $status_choice_data .= $key . ' : ' . $value . "\n";
        }

        // Add the intro field.
        // This can be later removed by an admin.
        FieldModel::addFields(
            array(
                array(
                    'name'        => 'lang:blog:title_label',
                    'slug'        => 'title',
                    'type'        => 'text',
                    'is_required' => true,
                    'is_locked'   => true,
                ),
                array(
                    'name'        => 'lang:blog:intro_label',
                    'slug'        => 'intro',
                    'type'        => 'wysiwyg',
                    'is_required' => true,
                    'is_locked'   => true,
                    'extra'       => array('editor_type' => 'simple', 'allow_tags' => 'y'),
                ),
                array(
                    'name'        => 'lang:global:slug',
                    'slug'        => 'slug',
                    'type'        => 'slug',
                    'is_required' => true,
                    'unique'      => true,
                    'is_locked'   => true,
                    'extra'       => array('slug_field' => 'title'),
                ),
                array(
                    'name'        => 'lang:blog:body_label',
                    'slug'        => 'body',
                    'type'        => 'wysiwyg',
                    'is_required' => true,
                    'is_locked'   => true,
                    'extra'       => array('editor_type' => 'advanced'),
                ),
                array(
                    'name' => 'lang:streams:keywords.name',
                    'slug' => 'keywords',
                    'type' => 'keywords',
                ),
                array(
                    'name'        => 'lang:blog:author_label',
                    'slug'        => 'author',
                    'type'        => 'user',
                    'is_required' => true,
                    'is_locked'   => true,
                ),
                array(
                    'name'        => 'lang:blog:comments_enabled',
                    'slug'        => 'comments_enabled',
                    'type'        => 'choice',
                    'is_required' => true,
                    'is_locked'   => true,
                    'extra'       => array(
                        'choice_data'   => $comments_enabled_choice_data,
                        'default_value' => '3 months',
                    ),
                ),
                array(
                    'name'        => 'lang:blog:status_label',
                    'slug'        => 'status',
                    'type'        => 'choice',
                    'is_locked'   => true,
                    'is_required' => true,
                    'extra'       => array(
                        'choice_data'   => $status_choice_data,
                        'default_value' => 'draft',
                    ),
                ),
                array(
                    'name'      => 'lang:blog:preview_hash',
                    'slug'      => 'preview_hash',
                    'type'      => 'text',
                    'is_locked' => true,
                    'default'   => 'draft'
                ),
                array(
                    'name'      => 'lang:blog:category_label',
                    'slug'      => 'category',
                    'type'      => 'relationship',
                    'is_locked' => true,
                    'extra'     => array(
                        'title_field'    => 'title',
                        'relation_class' => 'Pyro\Module\Blog\BlogCategoryModel',
                        'form_input_row' => 'module::blog/fields/category'
                    ),
                ),
            ),
            'blog',
            'blogs'
        );
    }

    public function uninstall($pdb, $schema)
    {
        StreamSchema::destroyNamespace('blogs');

        // This is a core module, lets keep it around.
        return true;
    }

    public function upgrade($old_version)
    {
        return true;
    }
}
