<?php

use Pyro\Module\Addons\AbstractModule;

/**
 * Settings module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Settings
 */
class Module_Settings extends AbstractModule
{
    public $version = '1.1.0';

    public function info()
    {
        return array(
            'name' => array(
                'en' => 'Settings',
                'ar' => 'الإعدادات',
                'br' => 'Configurações',
                'pt' => 'Configurações',
                'cs' => 'Nastavení',
                'da' => 'Indstillinger',
                'de' => 'Einstellungen',
                'el' => 'Ρυθμίσεις',
                'es' => 'Configuraciones',
                'fi' => 'Asetukset',
                'fr' => 'Paramètres',
                'he' => 'הגדרות',
                'id' => 'Pengaturan',
                'it' => 'Impostazioni',
                'lt' => 'Nustatymai',
                'nl' => 'Instellingen',
                'pl' => 'Ustawienia',
                'ru' => 'Настройки',
                'sl' => 'Nastavitve',
                'zh' => '網站設定',
                'hu' => 'Beállítások',
                'th' => 'ตั้งค่า',
                'se' => 'Inställningar',
                'km' => 'ការកំណត់',
            ),
            'description' => array(
                'en' => 'Allows administrators to update settings like Site Name, messages and email address, etc.',
                'ar' => 'تمكن المدراء من تحديث الإعدادات كإسم الموقع، والرسائل وعناوين البريد الإلكتروني، .. إلخ.',
                'br' => 'Permite com que administradores e a equipe consigam trocar as configurações do website incluindo o nome e descrição.',
                'pt' => 'Permite com que os administradores consigam alterar as configurações do website incluindo o nome e descrição.',
                'cs' => 'Umožňuje administrátorům měnit nastavení webu jako jeho jméno, zprávy a emailovou adresu apod.',
                'da' => 'Lader administratorer opdatere indstillinger som sidenavn, beskeder og email adresse, etc.',
                'de' => 'Erlaubt es Administratoren die Einstellungen der Seite wie Name und Beschreibung zu ändern.',
                'el' => 'Επιτρέπει στους διαχειριστές να τροποποιήσουν ρυθμίσεις όπως το Όνομα του Ιστοτόπου, τα μηνύματα και τις διευθύνσεις email, κ.α.',
                'es' => 'Permite a los administradores y al personal configurar los detalles del sitio como el nombre del sitio y la descripción del mismo.',
                'fi' => 'Mahdollistaa sivuston asetusten muokkaamisen, kuten sivuston nimen, viestit ja sähköpostiosoitteet yms.',
                'fr' => 'Permet aux admistrateurs de modifier les paramètres du site : nom du site, description, messages, adresse email, etc.',
                'he' => 'ניהול הגדרות שונות של האתר כגון: שם האתר, הודעות, כתובות דואר וכו',
                'id' => 'Memungkinkan administrator untuk dapat memperbaharui pengaturan seperti nama situs, pesan dan alamat email, dsb.',
                'it' => 'Permette agli amministratori di aggiornare impostazioni quali Nome del Sito, messaggi e indirizzo email, etc.',
                'lt' => 'Leidžia administratoriams keisti puslapio vavadinimą, žinutes, administratoriaus el. pašta ir kitą.',
                'nl' => 'Maakt het administratoren en medewerkers mogelijk om websiteinstellingen zoals naam en beschrijving te veranderen.',
                'pl' => 'Umożliwia administratorom zmianę ustawień strony jak nazwa strony, opis, e-mail administratora, itd.',
                'ru' => 'Управление настройками сайта - Имя сайта, сообщения, почтовые адреса и т.п.',
                'sl' => 'Dovoljuje administratorjem posodobitev nastavitev kot je Ime strani, sporočil, email naslova itd.',
                'zh' => '網站管理者可更新的重要網站設定。例如：網站名稱、訊息、電子郵件等。',
                'hu' => 'Lehetővé teszi az adminok számára a beállítások frissítését, mint a weboldal neve, üzenetek, e-mail címek, stb...',
                'th' => 'ให้ผู้ดูแลระบบสามารถปรับปรุงการตั้งค่าเช่นชื่อเว็บไซต์ ข้อความและอีเมล์เป็นต้น',
                'se' => 'Administratören kan uppdatera webbplatsens titel, meddelanden och E-postadress etc.',
                'km' => 'អនុញ្ញាតឱ្យអ្នកគ្រប់គ្រងធ្វើឱ្យទាន់សម័យនូវការកំណត់ដូចជាឈ្មោះគេហទំព័រ សារ និងអ៊ីម៉ែល។',
            ),
            'frontend' => false,
            'backend'  => true,
            'skip_xss' => true,
            'menu'    => 'settings',
        );
    }

    public function admin_menu(&$menu)
    {
        unset($menu['lang:cp:nav_settings']);

        $menu['lang:cp:nav_settings'] = 'admin/settings';

        add_admin_menu_place('lang:cp:nav_settings', 7);
    }

    /**
     * Install
     *
     * This function is run to install the module
     *
     * @return bool
     */
    public function install($pdb, $schema)
    {
        log_message('debug', '-- Settings: going to install the default settings');

        // Regarding ordering: any additions to this table can have an order
        // value the same as a sibling in the same section. For example if you
        // add to the Email tab give it a value in the range of 983 to 975.
        // Third-party modules should use lower numbers or 0.
        $settings = array(
            array(
                'title' => 'Site Name',
                'slug' => 'site_name',
                'description' => 'The name of the website for page titles and for use around the site.',
                'type' => 'text',
                'default' => 'Un-named Website',
                'is_required' => true,
                'is_gui' => true,
                'order' => 1000,
            ),
            array(
                'title' => 'Site Slogan',
                'slug' => 'site_slogan',
                'description' => 'The slogan of the website for page titles and for use around the site',
                'type' => 'text',
                'value' => 'Add your slogan here',
                'is_required' => false,
                'is_gui' => true,
                'order' => 999,
            ),
            array(
                'title' => 'Meta Topic',
                'slug' => 'meta_topic',
                'description' => 'Two or three words describing this type of company/website.',
                'type' => 'text',
                'default' => 'Content Management',
                'value' => 'Add your slogan here',
                'is_required' => false,
                'is_gui' => true,
                'order' => 998,
            ),
            array(
                'title' => 'Site Language',
                'slug' => 'site_lang',
                'description' => 'The native language of the website, used to choose templates of e-mail notifications, contact form, and other features that should not depend on the language of a user.',
                'type' => 'select',
                'default' => DEFAULT_LANG,
                'value' => DEFAULT_LANG,
                'options' => 'func:get_supported_lang',
                'is_required' => true,
                'is_gui' => true,
                'order' => 997,
            ),
            array(
                'title' => 'Public Languages',
                'slug' => 'site_public_lang',
                'description' => 'Which are the languages really supported and offered on the front-end of your website?',
                'type' => 'checkbox',
                'default' => DEFAULT_LANG,
                'value' => DEFAULT_LANG,
                'options' => 'func:get_supported_lang',
                'is_required' => true,
                'is_gui' => true,
                'order' => 996,
            ),
            array(
                'title' => 'Date Format',
                'slug' => 'date_format',
                'description' => 'How should dates be displayed across the website and control panel? Using the <a target="_blank" href="http://php.net/manual/en/function.date.php">date format</a> from PHP - OR - Using the format of <a target="_blank" href="http://php.net/manual/en/function.strftime.php">strings formatted as date</a> from PHP.',
                'type' => 'text',
                'default' => 'Y-m-d',
                'is_required' => true,
                'is_gui' => true,
                'order' => 995,
            ),
            array(
                'title' => 'Currency',
                'slug' => 'currency',
                'description' => 'The currency symbol for use on products, services, etc.',
                'type' => 'text',
                'default' => '&pound;',
                'is_required' => true,
                'is_gui' => true,
                'order' => 994,
            ),
            array(
                'title' => 'Records Per Page',
                'slug' => 'records_per_page',
                'description' => 'How many records should we show per page in the admin section?',
                'type' => 'select',
                'default' => '25',
                'options' => '5=5|10=10|25=25|50=50|100=100',
                'is_required' => true,
                'is_gui' => true,
                'order' => 992,
            ),
            array(
                'title' => 'Feed item count',
                'slug' => 'rss_feed_items',
                'description' => 'How many items should we show in RSS/blog feeds?',
                'type' => 'select',
                'default' => '25',
                'options' => '10=10|25=25|50=50|100=100',
                'is_required' => true,
                'is_gui' => true,
                'order' => 991,
            ),
            array(
                'title' => 'Dashboard RSS Feed',
                'slug' => 'dashboard_rss',
                'description' => 'Link to an RSS feed that will be displayed on the dashboard.',
                'type' => 'text',
                'default' => 'https://www.pyrocms.com/blog/rss/all.rss',
                'is_required' => false,
                'is_gui' => true,
                'order' => 990,
            ),
            array(
                'title' => 'Dashboard RSS Items',
                'slug' => 'dashboard_rss_count',
                'description' => 'How many RSS items would you like to display on the dashboard?',
                'type' => 'text',
                'default' => '5',
                'value' => '5',
                'is_required' => true,
                'is_gui' => true,
                'order' => 989,
            ),
            array(
                'title' => 'Site Status',
                'slug' => 'frontend_enabled',
                'description' => 'Use this option to the user-facing part of the site on or off. Useful when you want to take the site down for maintenance.',
                'type' => 'radio',
                'default' => true,
                'options' => '1=Open|0=Closed',
                'is_required' => true,
                'is_gui' => true,
                'order' => 988,
            ),
            array(
                'title' => 'Unavailable Message',
                'slug' => 'unavailable_message',
                'description' => 'When the site is turned off or there is a major problem, this message will show to users.',
                'type' => 'textarea',
                'default' => 'Sorry, this website is currently unavailable.',
                'is_required' => false,
                'is_gui' => true,
                'order' => 987,
            ),
            array(
                'title' => 'Google Tracking Code',
                'slug' => 'ga_tracking',
                'description' => 'Enter your Google Analytic Tracking Code to activate Google Analytics view data capturing. E.g: UA-19483569-6',
                'type' => 'text',
                'is_required' => false,
                'is_gui' => true,
                'module' => 'integration',
                'order' => 985,
            ),
            array(
                'title' => 'Google Analytic Profile ID',
                'slug' => 'ga_profile',
                'description' => 'Profile ID for this website in Google Analytics',
                'type' => 'text',
                'is_required' => false,
                'is_gui' => true,
                'module' => 'integration',
                'order' => 984,
            ),
            array(
                'title' => 'Google Analytic E-mail',
                'slug' => 'ga_email',
                'description' => 'E-mail address used for Google Analytics, we need this to show the graph on the dashboard.',
                'type' => 'text',
                'is_required' => false,
                'is_gui' => true,
                'module' => 'integration',
                'order' => 983,
            ),
            array(
                'title' => 'Google Analytic Password',
                'slug' => 'ga_password',
                'description' => 'This is also needed to show the graph on the dashboard. You will need to allow access to Google to get this to work. See <a href="https://accounts.google.com/b/0/IssuedAuthSubTokens?hl=en_US" target="_blank">Authorized Access to your Google Account</a>',
                'type' => 'password',
                'is_required' => false,
                'is_gui' => true,
                'module' => 'integration',
                'order' => 982,
            ),
            array(
                'title' => 'Contact E-mail',
                'slug' => 'contact_email',
                'description' => 'All e-mails from users, guests and the site will go to this e-mail address.',
                'type' => 'text',
                'default' => DEFAULT_EMAIL,
                'is_required' => true,
                'is_gui' => true,
                'module' => 'email',
                'order' => 979,
            ),
            array(
                'title' => 'Server E-mail',
                'slug' => 'server_email',
                'description' => 'All e-mails to users will come from this e-mail address.',
                'type' => 'text',
                'default' => 'admin@localhost',
                'is_required' => true,
                'is_gui' => true,
                'module' => 'email',
                'order' => 978,
            ),
            array(
                'title' => 'Mail Protocol',
                'slug' => 'mail_protocol',
                'description' => 'Select desired email protocol.',
                'type' => 'select',
                'default' => 'mail',
                'value' => 'mail',
                'options' => 'mail=Mail|sendmail=Sendmail|smtp=SMTP',
                'is_required' => true,
                'is_gui' => true,
                'module' => 'email',
                'order' => 977,
            ),
            array(
                'title' => 'SMTP Host Name',
                'slug' => 'mail_smtp_host',
                'description' => 'The host name of your smtp server.',
                'type' => 'text',
                'is_required' => false,
                'is_gui' => true,
                'module' => 'email',
                'order' => 976,
            ),
            array(
                'title' => 'SMTP password',
                'slug' => 'mail_smtp_pass',
                'description' => 'SMTP password.',
                'type' => 'password',
                'is_required' => false,
                'is_gui' => true,
                'module' => 'email',
                'order' => 975,
            ),
            array(
                'title' => 'SMTP Port',
                'slug' => 'mail_smtp_port',
                'description' => 'SMTP port number.',
                'type' => 'text',
                'is_required' => false,
                'is_gui' => true,
                'module' => 'email',
                'order' => 974,
            ),
            array(
                'title' => 'SMTP User Name',
                'slug' => 'mail_smtp_user',
                'description' => 'SMTP user name.',
                'type' => 'text',
                'is_required' => false,
                'is_gui' => true,
                'module' => 'email',
                'order' => 973,
            ),
            array(
                'title' => 'SMTP Encryption',
                'slug' => 'mail_smtp_crypto',
                'description' => 'SMTP Encryption used for sending emails.',
                'type' => 'select',
                'is_required' => false,
                'is_gui' => true,
                'module' => 'email',
                'order' => 972,
            ),
            array(
                'title' => 'Sendmail Path',
                'slug' => 'mail_sendmail_path',
                'description' => 'Path to server sendmail binary.',
                'type' => 'text',
                'is_required' => false,
                'is_gui' => true,
                'module' => 'email',
                'order' => 971,
            ),
            array(
                'title' => 'Cache time',
                'slug' => 'twitter_cache',
                'description' => 'How many minutes should your Tweets be stored?',
                'type' => 'text',
                'default' => '300',
                'is_required' => false,
                'is_gui' => true,
                'module' => 'twitter',
                'order' => 969,
            ),
            array(
                'title' => 'Force HTTPS for Control Panel?',
                'slug' => 'admin_force_https',
                'description' => 'Allow only the HTTPS protocol when using the Control Panel?',
                'type' => 'radio',
                'default' => 0,
                'options' => '1=Yes|0=No',
                'is_required' => true,
                'is_gui' => true,
                'module' => '',
                'order' => 0,
            ),
            // @todo Move this to the API module
            array(
                'title' => 'API Enabled',
                'slug' => 'api_enabled',
                'description' => 'Allow API access to all modules which have an API controller.',
                'type' => 'select',
                'default' => 0,
                'value' => 0,
                'options' => '0=Disabled|1=Enabled',
                'is_required' => false,
                'is_gui' => false,
                'module' => 'api',
                'order' => 0,
            ),
            array(
                'title' => 'API User Keys',
                'slug' => 'api_user_keys',
                'description' => 'Allow users to sign up for API keys (if the API is Enabled).',
                'type' => 'select',
                'default' => 0,
                'value' => 0,
                'options' => '0=Disabled|1=Enabled',
                'is_required' => false,
                'is_gui' => false,
                'module' => 'api',
                'order' => 0,
            ),
            array(
                'title' => 'CDN Domain',
                'slug' => 'cdn_domain',
                'description' => 'CDN domains allow you to offload static content to various edge servers, like Amazon CloudFront or MaxCDN.',
                'type' => 'text',
                'is_required' => false,
                'is_gui' => true,
                'module' => 'integration',
                'order' => 1000,
            ),
        );

        // Lets add the settings for this module.
        foreach ($settings as $setting) {
            log_message('debug', '-- Settings: installing '.$setting['slug']);

            if ( ! $pdb->table('settings')->insert($setting)) {
                log_message('error', '-- -- could not install '.$setting['slug']);

                return false;
            }
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
