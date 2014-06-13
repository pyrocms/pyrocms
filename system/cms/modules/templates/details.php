<?php

use Pyro\Module\Addons\AbstractModule;
use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\Stream\StreamModel;
use Pyro\Module\Streams\Stream\StreamSchema;

/**
 * Templates Module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Templates
 */
class Module_Templates extends AbstractModule
{
    /**
     * Version
     *
     * @var string
     */
    public $version = '1.1.0';

    /**
     * Info
     *
     * @return array
     */
    public function info()
    {
        return array(
            'name'        => array(
                'en' => 'Email Templates',
                'ar' => 'قوالب الرسائل الإلكترونية',
                'br' => 'Modelos de e-mail',
                'pt' => 'Modelos de e-mail',
                'da' => 'Email skabeloner',
                'el' => 'Δυναμικά email',
                'es' => 'Plantillas de email',
                'fa' => 'قالب های ایمیل',
                'fr' => 'Modèles d\'emails',
                'he' => 'תבניות',
                'id' => 'Template Email',
                'lt' => 'El. laiškų šablonai',
                'nl' => 'Email sjablonen',
                'ru' => 'Шаблоны почты',
                'sl' => 'Email predloge',
                'tw' => '郵件範本',
                'cn' => '邮件范本',
                'hu' => 'E-mail sablonok',
                'fi' => 'Sähköposti viestipohjat',
                'th' => 'แม่แบบอีเมล',
                'se' => 'E-postmallar',
                'km' => 'ពុម្ពអ៊ីម៉ែល',
            ),
            'description' => array(
                'en' => 'Create, edit, and save dynamic email templates',
                'ar' => 'أنشئ، عدّل واحفظ قوالب البريد الإلكترني الديناميكية.',
                'br' => 'Criar, editar e salvar modelos de e-mail dinâmicos',
                'pt' => 'Criar, editar e salvar modelos de e-mail dinâmicos',
                'da' => 'Opret, redigér og gem dynamiske emailskabeloner.',
                'el' => 'Δημιουργήστε, επεξεργαστείτε και αποθηκεύστε δυναμικά email.',
                'es' => 'Crear, editar y guardar plantillas de email dinámicas',
                'fa' => 'ایحاد، ویرایش و ذخیره ی قالب های ایمیل به صورت پویا',
                'fr' => 'Créer, éditer et sauver dynamiquement des modèles d\'emails',
                'he' => 'ניהול של תבניות דואר אלקטרוני',
                'id' => 'Membuat, mengedit, dan menyimpan template email dinamis',
                'lt' => 'Kurk, tvarkyk ir saugok dinaminius el. laiškų šablonus.',
                'nl' => 'Maak, bewerk, en beheer dynamische emailsjablonen',
                'ru' => 'Создавайте, редактируйте и сохраняйте динамические почтовые шаблоны',
                'sl' => 'Ustvari, uredi in shrani spremenljive email predloge',
                'tw' => '新增、編輯與儲存可顯示動態資料的 email 範本',
                'cn' => '新增、编辑与储存可显示动态资料的 email 范本',
                'hu' => 'Csináld, szerkeszd és mentsd el a dinamikus e-mail sablonokat',
                'fi' => 'Lisää, muokkaa ja tallenna dynaamisia sähköposti viestipohjia.',
                'th' => 'การสร้างแก้ไขและบันทึกแม่แบบอีเมลแบบไดนามิก',
                'se' => 'Skapa, redigera och spara dynamiska E-postmallar.',
                'km' => 'បង្កើត កែសម្រួល និងរក្សាទុកពុម្ពអ៊ីម៉ែលថាមវន្ត',
            ),
            'frontend'    => false,
            'backend'     => true,
            'menu'        => 'structure',
            'skip_xss'    => true,
            'shortcuts'   => array(
                array(
                    'name'  => 'templates:create_title',
                    'uri'   => 'admin/templates/create',
                    'class' => 'add',
                ),
            ),
        );
    }

    /**
     * Install
     *
     * @param $pdb
     * @param $schema
     * @return bool
     */
    public function install($pdb, $schema)
    {
        StreamSchema::destroyNamespace('templates');

        $schema->dropIfExists('email_templates');

        // Add templates
        StreamModel::addStream(
            $slug = 'templates',
            $namespace = 'templates',
            $name = 'Email Templates',
            $prefix = 'email_',
            $about = null,
            $extra = array(
                'title_column' => 'name',
            )
        );

        // Build the fields
        $fields = array(
            array(
                'name'      => 'lang:name_label',
                'slug'      => 'name',
                'namespace' => 'templates',
                'is_locked'    => true,
                'type'      => 'text',
            ),
            array(
                'name'      => 'lang:global:slug',
                'slug'      => 'slug',
                'namespace' => 'templates',
                'is_locked'    => true,
                'type'      => 'slug',
                'extra'     => array(
                    'slug_field' => 'name',
                    'max_length' => 100,
                ),
            ),
            array(
                'name'      => 'lang:desc_label',
                'slug'      => 'description',
                'namespace' => 'templates',
                'is_locked'    => true,
                'type'      => 'text',
            ),
            array(
                'name'      => 'lang:templates:subject_label',
                'slug'      => 'subject',
                'namespace' => 'templates',
                'is_locked'    => true,
                'type'      => 'text',
            ),
            array(
                'name'      => 'lang:templates:body_label',
                'slug'      => 'body',
                'namespace' => 'templates',
                'is_locked'    => true,
                'type'      => 'wysiwyg',
                'extra'     => array(
                    'editor_type' => 'advanced',
                    'allow_tags'  => 'y',
                ),
            ),
            array(
                'name'      => 'templates:language_label',
                'slug'      => 'lang',
                'namespace' => 'templates',
                'is_locked'    => true,
                'type'      => 'pyro_lang',
                'extra'     => array(
                    'max_length' => 2,
                ),
            ),
        );

        // Add all the fields
        FieldModel::addFields($fields, null, 'templates');

        // Templates assignments
        FieldModel::assignField('templates', 'templates', 'name', array('is_required' => true));
        FieldModel::assignField('templates', 'templates', 'slug', array('is_required' => true));
        FieldModel::assignField('templates', 'templates', 'lang', array('is_required' => true));
        FieldModel::assignField('templates', 'templates', 'description', array('is_required' => true));
        FieldModel::assignField('templates', 'templates', 'subject', array('is_required' => true));
        FieldModel::assignField('templates', 'templates', 'body', array('is_required' => true));

        // Non streams stuff
        $schema->table(
            'email_templates',
            function ($table) {
                $table->boolean('is_default')->default(false);
                $table->string('module', 50)->default('');

                $table->unique(array('slug', 'lang'));
            }
        );

        /*
         * Insert the default email templates
         */

        // @todo move this to the comments module
        $pdb->table('email_templates')->insert(
            array(
                'slug'        => 'comments',
                'name'        => 'Comment Notification',
                'description' => 'Email that is sent to admin when someone creates a comment',
                'subject'     => 'You have just received a comment from {{ name }}',
                'body'        => "<h3>You have received a comment from {{ name }}</h3>
                <p>
                <strong>IP Address: {{ sender_ip }}</strong><br/>
                <strong>Operating System: {{ sender_os }}<br/>
                <strong>User Agent: {{ sender_agent }}</strong>
                </p>
                <p>{{ comment }}</p>
                <p>View Comment: {{ redirect_url }}</p>",
                'lang'        => 'en',
                'is_default'  => true,
                'module'      => 'comments',
                'created_at'  => date('Y-m-d H:i:s'),
            )
        );

        // @todo move this to the contact module
        $pdb->table('email_templates')->insert(
            array(
                'slug'        => 'contact',
                'name'        => 'Contact Notification',
                'description' => 'Template for the contact form',
                'subject'     => '{{ settings:site_name }} :: {{ subject }}',
                'body'        => 'This message was sent via the contact form on with the following details:
                <hr />
                IP Address: {{ sender_ip }}
                OS {{ sender_os }}
                Agent {{ sender_agent }}
                <hr />
                {{ message }}

                {{ name }},

                {{ email }}',
                'lang'        => 'en',
                'is_default'  => true,
                'module'      => 'pages',
                'created_at'  => date('Y-m-d H:i:s'),
            )
        );

        // @todo move this to the users module
        $pdb->table('email_templates')->insert(
            array(
                'slug'        => 'registered',
                'name'        => 'New User Registered',
                'description' => 'Email sent to the site contact e-mail when a new user registers',
                'subject'     => '{{ settings:site_name }} :: You have just received a registration from {{ name }}',
                'body'        => '<h3>You have received a registration from {{ name }}</h3>
                <p><strong>IP Address: {{ sender_ip }}</strong><br/>
                <strong>Operating System: {{ sender_os }}</strong><br/>
                <strong>User Agent: {{ sender_agent }}</strong>
                </p>',
                'lang'        => 'en',
                'is_default'  => true,
                'module'      => 'users',
                'created_at'  => date('Y-m-d H:i:s'),
            )
        );

        // @todo move this to the users module
        $pdb->table('email_templates')->insert(
            array(
                'slug'        => 'activation',
                'name'        => 'Activation Email',
                'description' => 'The email which contains the activation code that is sent to a new user',
                'subject'     => '{{ settings:site_name }} - Account Activation',
                'body'        => '<p>Hello {{ user:first_name }},</p>
                <p>Thank you for registering at {{ settings:site_name }}. Before we can activate your account, please complete the registration process by clicking on the following link:</p>
                <p><a href="{{ url:site }}users/activate/{{ user:id }}/{{ activation_code }}">{{ url:site }}users/activate/{{ user:id }}/{{ activation_code }}</a></p>
                <p>&nbsp;</p>
                <p>In case your email program does not recognize the above link as, please direct your browser to the following URL and enter the activation code:</p>
                <p><a href="{{ url:site }}users/activate">{{ url:site }}users/activate</a></p>
                <p><strong>Activation Code:</strong> {{ activation_code }}</p>',
                'lang'        => 'en',
                'is_default'  => true,
                'module'      => 'users',
                'created_at'  => date('Y-m-d H:i:s'),
            )
        );

        // @todo move this to the users module
        $pdb->table('email_templates')->insert(
            array(
                'slug'        => 'forgotten_password',
                'name'        => 'Forgotten Password Email',
                'description' => 'The email that is sent containing a password reset code',
                'subject'     => '{{ settings:site_name }} - Forgotten Password',
                'body'        => '<p>Hello {{ user:first_name }},</p>
                <p>It seems you have requested a password reset. Please click this link to complete the reset: <a href="{{ url:site }}users/reset_pass/{{ user:forgotten_password_code }}">{{ url:site }}users/reset_pass/{{ user:forgotten_password_code }}</a></p>
                <p>If you did not request a password reset please disregard this message. No further action is necessary.</p>',
                'lang'        => 'en',
                'is_default'  => true,
                'module'      => 'users',
                'created_at'  => date('Y-m-d H:i:s'),
            )
        );

        // @todo move this to the users module
        $pdb->table('email_templates')->insert(
            array(
                'slug'        => 'new_password',
                'name'        => 'New Password Email',
                'description' => 'After a password is reset this email is sent containing the new password',
                'subject'     => '{{ settings:site_name }} - New Password',
                'body'        => '<p>Hello {{ user:first_name }},</p>
                <p>Your new password is: {{ new_password }}</p>
                <p>After logging in you may change your password by visiting <a href="{{ url:site }}edit-profile">{{ url:site }}edit-profile</a></p>',
                'lang'        => 'en',
                'is_default'  => true,
                'module'      => 'users',
                'created_at'  => date('Y-m-d H:i:s'),
            )
        );

        return true;
    }

    /**
     * Uninstall
     *
     * @param $pdb
     * @param $schema
     * @return bool
     */
    public function uninstall($pdb, $schema)
    {
        // This is a core module, lets keep it around.
        return false;
    }

    /**
     * Upgrade
     *
     * @param  string $old_version
     * @return bool
     */
    public function upgrade($oldVersion)
    {
        return true;
    }

}
