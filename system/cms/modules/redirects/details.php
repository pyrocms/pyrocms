<?php

use Pyro\Module\Addons\AbstractModule;
use Pyro\Module\Streams\Stream\StreamModel;
use Pyro\Module\Streams\Field\FieldModel;
use Pyro\Module\Streams\Stream\StreamSchema;

/**
 * Redirects module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Redirects
 */
class Module_Redirects extends AbstractModule
{
    public $version = '1.0.0';

    public function info()
    {
        return array(
            'name'        => array(
                'en' => 'Redirects',
                'ar' => 'التوجيهات',
                'br' => 'Redirecionamentos',
                'pt' => 'Redirecionamentos',
                'cs' => 'Přesměrování',
                'da' => 'Omadressering',
                'el' => 'Ανακατευθύνσεις',
                'es' => 'Redirecciones',
                'fa' => 'انتقال ها',
                'fi' => 'Uudelleenohjaukset',
                'fr' => 'Redirections',
                'he' => 'הפניות',
                'id' => 'Redirect',
                'it' => 'Reindirizzi',
                'lt' => 'Peradresavimai',
                'nl' => 'Verwijzingen',
                'ru' => 'Перенаправления',
                'sl' => 'Preusmeritve',
                'tw' => '轉址',
                'cn' => '转址',
                'hu' => 'Átirányítások',
                'pl' => 'Przekierowania',
                'th' => 'เปลี่ยนเส้นทาง',
                'se' => 'Omdirigeringar',
                'km' => 'ទិសដៅ',
            ),
            'description' => array(
                'en' => 'Redirect from one URL to another.',
                'ar' => 'التوجيه من رابط URL إلى آخر.',
                'br' => 'Redirecionamento de uma URL para outra.',
                'pt' => 'Redirecionamentos de uma URL para outra.',
                'cs' => 'Přesměrujte z jedné adresy URL na jinou.',
                'da' => 'Omadresser fra en URL til en anden.',
                'el' => 'Ανακατευθείνετε μια διεύθυνση URL σε μια άλλη',
                'es' => 'Redireccionar desde una URL a otra',
                'fa' => 'انتقال دادن یک صفحه به یک آدرس دیگر',
                'fi' => 'Uudelleenohjaa käyttäjän paikasta toiseen.',
                'fr' => 'Redirection d\'une URL à un autre.',
                'he' => 'הפניות מכתובת אחת לאחרת',
                'id' => 'Redirect dari satu URL ke URL yang lain.',
                'it' => 'Reindirizza da una URL ad un altra.',
                'lt' => 'Peradresuokite puslapį iš vieno adreso (URL) į kitą.',
                'nl' => 'Verwijs vanaf een URL naar een andere.',
                'ru' => 'Перенаправления с одного адреса на другой.',
                'sl' => 'Preusmeritev iz enega URL naslova na drugega',
                'tw' => '將網址轉址、重新定向。',
                'cn' => '将网址转址、重新定向。',
                'hu' => 'Egy URL átirányítása egy másikra.',
                'pl' => 'Przekierowanie z jednego adresu URL na inny.',
                'th' => 'เปลี่ยนเส้นทางจากที่หนึ่งไปยังอีกที่หนึ่ง',
                'se' => 'Omdirigera från en URL till en annan.',
                'km' => 'ការប្តូរទិសដៅពីមួយ URL ទៅមួយទៀត។',
            ),
            'frontend'    => false,
            'backend'     => true,
            'menu'        => 'structure',
            'shortcuts'   => array(
                array(
                    'name'  => 'redirects:add_title',
                    'uri'   => 'admin/redirects/add',
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
        // Uninstall first to make sure we're clean
        self::uninstall($pdb, $schema);

        // Add redirects
        StreamModel::addStream(
            $slug = 'redirects',
            $namespace = 'redirects',
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
                'name'      => 'lang:redirects:from',
                'slug'      => 'from',
                'namespace' => 'redirects',
                'locked'    => true,
                'type'      => 'url',
            ),
            array(
                'name'      => 'lang:redirects:to',
                'slug'      => 'to',
                'namespace' => 'redirects',
                'locked'    => true,
                'type'      => 'url',
            ),
            array(
                'name'      => 'lang:redirects:type',
                'slug'      => 'type',
                'namespace' => 'redirects',
                'locked'    => true,
                'type'      => 'choice',
                'extra'     => array(
                    'choice_type'   => 'dropdown',
                    'choice_data'   => '301 : lang:redirects:301' . "\n"
                        . '302 : lang:redirects:302',
                    'default_value' => '301',
                ),
            ),
        );

        // Add all the fields
        FieldModel::addFields($fields, null, 'redirects');

        // Redirects assignments
        FieldModel::assignField('redirects', 'redirects', 'from', array('is_required' => true));
        FieldModel::assignField('redirects', 'redirects', 'to', array('is_required' => true));
        FieldModel::assignField('redirects', 'redirects', 'type', array('is_required' => true));

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
     * @param string $oldVersion
     * @return bool
     */
    public function upgrade($oldVersion)
    {
        return true;
    }
}
