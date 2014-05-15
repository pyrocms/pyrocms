<?php

use Pyro\Module\Addons\AbstractModule;
use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\Stream\StreamSchema;
use Pyro\Module\Streams\Stream\StreamModel;

/**
 * Users Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Users
 */
class Module_Users extends AbstractModule
{
    public $version = '2.1.0';

    public function info()
    {
        $info = array(
            'name' => array(
                'en' => 'Users',
                'ar' => 'المستخدمون',
                'br' => 'Usuários',
                'pt' => 'Utilizadores',
                'cs' => 'Uživatelé',
                'da' => 'Brugere',
                'de' => 'Benutzer',
                'el' => 'Χρήστες',
                'es' => 'Usuarios',
                'fa' => 'کاربران',
                'fi' => 'Käyttäjät',
                'fr' => 'Utilisateurs',
                'he' => 'משתמשים',
                'id' => 'Pengguna',
                'it' => 'Utenti',
                'lt' => 'Vartotojai',
                'nl' => 'Gebruikers',
                'pl' => 'Użytkownicy',
                'ru' => 'Пользователи',
                'sl' => 'Uporabniki',
                'zh' => '用戶',
                'hu' => 'Felhasználók',
                'th' => 'ผู้ใช้งาน',
                'se' => 'Användare',
                'km' => 'អ្នកប្រើ',
            ),
            'description' => array(
                'en' => 'Let users register and log in to the site, and manage them via the control panel.',
                'ar' => 'تمكين المستخدمين من التسجيل والدخول إلى الموقع، وإدارتهم من لوحة التحكم.',
                'br' => 'Permite com que usuários se registrem e entrem no site e também que eles sejam gerenciáveis apartir do painel de controle.',
                'pt' => 'Permite com que os utilizadores se registem e entrem no site e também que eles sejam geriveis apartir do painel de controlo.',
                'cs' => 'Umožňuje uživatelům se registrovat a přihlašovat a zároveň jejich správu v Kontrolním panelu.',
                'da' => 'Lader brugere registrere sig og logge ind på sitet, og håndtér dem via kontrolpanelet.',
                'de' => 'Erlaube Benutzern das Registrieren und Einloggen auf der Seite und verwalte sie über die Admin-Oberfläche.',
                'el' => 'Παρέχει λειτουργίες εγγραφής και σύνδεσης στους επισκέπτες. Επίσης από εδώ γίνεται η διαχείριση των λογαριασμών.',
                'es' => 'Permite el registro de nuevos usuarios quienes podrán loguearse en el sitio. Estos podrán controlarse desde el panel de administración.',
                'fa' => 'به کاربر ها امکان ثبت نام و لاگین در سایت را بدهید و آنها را در پنل مدیریت نظارت کنید',
                'fi' => 'Antaa käyttäjien rekisteröityä ja kirjautua sisään sivustolle sekä mahdollistaa niiden muokkaamisen hallintapaneelista.',
                'fr' => 'Permet aux utilisateurs de s\'enregistrer et de se connecter au site et de les gérer via le panneau de contrôle',
                'he' => 'ניהול משתמשים: רישום, הפעלה ומחיקה',
                'id' => 'Memungkinkan pengguna untuk mendaftar dan masuk ke dalam situs, dan mengaturnya melalui control panel.',
                'it' => 'Fai iscrivere de entrare nel sito gli utenti, e gestiscili attraverso il pannello di controllo.',
                'lt' => 'Leidžia vartotojams registruotis ir prisijungti prie puslapio, ir valdyti juos per administravimo panele.',
                'nl' => 'Laat gebruikers registreren en inloggen op de site, en beheer ze via het controlepaneel.',
                'pl' => 'Pozwól użytkownikom na logowanie się na stronie i zarządzaj nimi za pomocą panelu.',
                'ru' => 'Управление зарегистрированными пользователями, активирование новых пользователей.',
                'sl' => 'Dovoli uporabnikom za registracijo in prijavo na strani, urejanje le teh preko nadzorne plošče',
                'zh' => '讓用戶可以註冊並登入網站，並且管理者可在控制台內進行管理。',
                'th' => 'ให้ผู้ใช้ลงทะเบียนและเข้าสู่เว็บไซต์และจัดการกับพวกเขาผ่านทางแผงควบคุม',
                'hu' => 'Hogy a felhasználók tudjanak az oldalra regisztrálni és belépni, valamint lehessen őket kezelni a vezérlőpulton.',
                'se' => 'Låt dina besökare registrera sig och logga in på webbplatsen. Hantera sedan användarna via kontrollpanelen.',
                'km' => 'អនុញ្ញាតឱ្យអ្នកប្រើចុះឈ្មោះនិងចូលទៅតំបន់បណ្ដាញក្នុង និងគ្រប់គ្រងពួកគេតាមរយៈផ្ទាំងបញ្ជា។',
            ),
            'frontend'  => false,
            'backend'   => true,
            'menu'      => 'users',
            'roles'     => array('admin_profile_fields'),
            'sections'  => array(
                'users' => array(
                    'name'  => 'user:list_title',
                    'uri'   => 'admin/users',
                    'shortcuts' => array(
                        'create' => array(
                            'name'  => 'user:add_title',
                            'uri'   => 'admin/users/create',
                            'class' => 'add'
                        )
                    )
                ),
                'groups' => array(
                    'name' => 'users:groups',
                    'uri' => 'admin/users/groups',
                    'shortcuts' => array(
                        array(
                            'name' => 'users:groups:add_title',
                            'uri' => 'admin/users/groups/add',
                            'class' => 'add',
                        ),
                    ),
                ),
            ),
        );

        if (function_exists('group_has_role')) {
            if (group_has_role('users', 'admin_profile_fields')) {
                $info['sections'] += array(
                    'fields' => array(
                        'name'  => 'user:profile_fields_label',
                        'uri'   => 'admin/users/fields',
                        'shortcuts' => array(
                            'create' => array(
                                'name'  => 'user:add_field',
                                'uri'   => 'admin/users/fields/create',
                                'class' => 'add'
                            )
                        )
                    )
                );
            }
        }

        return $info;
    }

    /**
     * Installation logic
     *
     * This is handled by the installer only so that a default user can be created.
     *
     * @return bool
     */
    public function install($pdb, $schema)
    {
        $schema->dropIfExists('permissions');

        $schema->create('permissions', function ($table) {
            $table->increments('id');
            $table->integer('group_id');
            $table->string('module');
            $table->text('roles')->nullable();

            $table->index('group_id'); // TODO: consider $table->foreign('group_id');
        });

        $schema->dropIfExists('groups');

        $schema->create('groups', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->text('permissions')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();

            $table->unique('name');
        });

        ci()->pdb->table('groups')->insert(array(
            array(
                'name' => 'admin',
                'description' => 'Administrator',
                'permissions' => json_encode(array('admin' => 1)),
                'created_at' => date('Y-m-d H:i:s')
            ),
            array(
                'name' => 'user',
                'description' => 'User',
                'permissions' => null,
                'created_at' => date('Y-m-d H:i:s')
            ),
        ));

        // Install the settings
        $pdb->table('settings')->insert(array(
            array(
                'slug' => 'auto_username',
                'title' => 'Auto Username',
                'description' => 'Create the username automatically, meaning users can skip making one on registration.',
                'type' => 'radio',
                'default' => true,
                'value' => '',
                'options' => '1=Enabled|0=Disabled',
                'is_required' => false,
                'is_gui' => true,
                'module' => 'users',
                'order' => 964,
            ),
            array(
                'slug' => 'enable_profiles',
                'title' => 'Enable profiles',
                'description' => 'Allow users to add and edit profiles.',
                'type' => 'radio',
                'default' => true,
                'value' => '',
                'options' => '1=Enabled|0=Disabled',
                'is_required' => true,
                'is_gui' => true,
                'module' => 'users',
                'order' => 963,
            ),
            array(
                'slug' => 'require_lastname',
                'title' => 'Require last names?',
                'description' => 'For some situations, a last name may not be required. Do you want to force users to enter one or not?',
                'type' => 'radio',
                'default' => true,
                'value' => '',
                'options' => '1=Required|0=Optional',
                'is_required' => true,
                'is_gui' => true,
                'module' => 'users',
                'order' => 962,
            ),
            array(
                'slug' => 'activation_email',
                'title' => 'Activation Email',
                'description' => 'Send out an e-mail with an activation link when a user signs up. Disable this so that admins must manually activate each account.',
                'type' => 'select',
                'default' => true,
                'value' => '',
                'options' => '0=activate_by_admin|1=activate_by_email|2=no_activation',
                'is_required' => false,
                'is_gui' => true,
                'module' => 'users',
                'order' => 961,
            ),
            array(
                'slug' => 'registered_email',
                'title' => 'User Registered Email',
                'description' => 'Send a notification email to the contact e-mail when someone registers.',
                'type' => 'radio',
                'default' => true,
                'value' => '',
                'options' => '1=Enabled|0=Disabled',
                'is_required' => false,
                'is_gui' => true,
                'module' => 'users',
                'order' => 960,
            ),
            array(
                'slug' => 'enable_registration',
                'title' => 'Enable user registration',
                'description' => 'Allow users to register in your site.',
                'type' => 'radio',
                'default' => true,
                'value' => '',
                'options' => '1=Enabled|0=Disabled',
                'is_required' => false,
                'is_gui' => true,
                'module' => 'users',
                'order' => 959,
            ),
        ));

        StreamSchema::destroyNamespace('users');

        // Create the profiles stream
        if (! StreamModel::addStream('profiles', 'users', 'lang:user_profile_fields_label', null, 'Profiles for users module', array(
                'title_column' => 'display_name',
                'view_options' => array('display_name')
            )))
        {
            return false;
        }

         // Index user_id
        $schema->table('profiles', function ($table) {
            // SQLite required the nullable(), it can be removed later if anyone remembers or cares but 
            // it shouldnt matter. Phil
            $table->integer('user_id')->nullable();
            $table->index('user_id');
        });

        // Go ahead and add the profile fields
        $fields = array(
            array(
                'name'          => 'lang:user:display_name',
                'slug'          => 'display_name',
                'type'          => 'text',
                'extra'      => array('max_length' => 50),
                'is_required' => true,
            ),
            array(
                'name'          => 'lang:user:first_name_label',
                'slug'          => 'first_name',
                'type'          => 'text',
                'extra'      => array('max_length' => 50),
                'is_required' => true,
            ),
            array(
                'name'          => 'lang:user:last_name_label',
                'slug'          => 'last_name',
                'type'          => 'text',
                'extra'      => array('max_length' => 50),
                'is_required' => true,
            ),
            array(
                'name'          => 'lang:user:profile_company',
                'slug'          => 'company',
                'type'          => 'text',
                'extra'      => array('max_length' => 100)
            ),
            array(
                'name'          => 'lang:user:profile_bio',
                'slug'          => 'bio',
                'type'          => 'textarea',
            ),
            array(
                'name'          => 'lang:user:lang',
                'slug'          => 'lang',
                'type'          => 'pyro_lang',
                'extra' => array('filter_theme' => 'yes')
            ),
            array(
                'name'          => 'lang:user:profile_dob',
                'slug'          => 'dob',
                'type'          => 'datetime',
                'extra'      => array(
                    'use_time'      => 'no',
                    'storage'       => 'unix',
                    'input_type'    => 'dropdown',
                    'start_date'    => '-100Y'
                )
            ),
            array(
                'name'          => 'lang:user:profile_gender',
                'slug'          => 'choice',
                'type'          => 'text',
                'extra'      => array(
                    'choice_type' => 'dropdown',
                    'choice_data' => " : Not Telling\nm : Male\nf : Female"
                )
            ),
            array(
                'name'          => 'lang:user:profile_phone',
                'slug'          => 'phone',
                'type'          => 'text',
                'extra'      => array('max_length' => 20)
            ),
            array(
                'name'          => 'lang:user:profile_mobile',
                'slug'          => 'mobile',
                'type'          => 'text',
                'extra'      => array('max_length' => 20)
            ),
            array(
                'name'          => 'lang:user:profile_address_line1',
                'slug'          => 'address_line1',
                'type'          => 'text',
            ),
            array(
                'name'          => 'lang:user:profile_address_line2',
                'slug'          => 'address_line2',
                'type'          => 'text',
            ),
            array(
                'name'          => 'lang:user:profile_address_line3',
                'slug'          => 'address_line3',
                'type'          => 'text',
            ),
            array(
                'name'          => 'lang:user:profile_address_postcode',
                'slug'          => 'postcode',
                'type'          => 'text',
                'extra'      => array('max_length' => 20)
            ),
            array(
                'name'          => 'lang:user:profile_website',
                'slug'          => 'website',
                'type'          => 'url',
            )
        );

        FieldModel::addFields($fields, 'profiles', 'users');

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
