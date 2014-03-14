<?php

use Pyro\Module\Addons\AbstractModule;

/**
 * PyroStreams Core Module
 *
 * @package        PyroCMS\Core\Modules\Streams Core
 * @author         Parse19
 * @copyright      Copyright (c) 2011 - 2012, Parse19
 * @license        http://parse19.com/pyrostreams/docs/license
 * @link           http://parse19.com/pyrostreams
 */
class Module_Streams_core extends AbstractModule
{
    public $version = '1.3.0';

    /**
     * Module Info
     *
     * @return array
     */
    public function info()
    {
        return array(
            'name' => array(
                'en' => 'Streams Core',
                'pt' => 'Núcleo Fluxos',
                'el' => 'Πυρήνας Ροών',
                'fa' => 'هسته استریم ها',
                'fr' => 'Noyau Flux',
                'fi' => 'Striimit ydin',
                'se' => 'Streams grundmodul',
                'tw' => 'Streams 核心',
                'cn' => 'Streams 核心',
                'ar' => 'الجداول الأساسية',
                'it' => 'Streams Core',
                'km' => 'ស្ទ្រីមស្នូល',
            ),
            'description' => array(
                'en' => 'Core data module for streams.',
                'pt' => 'Módulo central de dados para fluxos.',
                'fa' => 'ماژول مرکزی برای استریم ها',
                'fi' => 'Ydin datan hallinoiva moduuli striimejä varten.',
                'fr' => 'Noyau de données pour les Flux.',
                'el' => 'Προγραμματιστικός πυρήνας για την λειτουργία ροών δεδομένων.',
                'se' => 'Streams grundmodul för enklare hantering av data.',
                'tw' => 'Streams 核心資料模組。',
                'cn' => 'Streams 核心资料模组。',
                'ar' => 'وحدة البيانات الأساسية للجداول',
                'it' => 'Core dello Stream',
                'km' => 'ម៉ូឌុលទិន្នន័យស្នូលសម្រាប់ស្ទ្រីម។',
            ),
            'frontend' => false,
            'backend' => false,
            'skip_xss' => true,
            'author' => 'PyroCMS Dev Team',
            // Register field types with the autoloader
            'field_types' => true
        );
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
        return true;
    }

    /**
     * Uninstall Streams Core
     *
     * This is a very dangerous function. It removes the core streams tables so
     * watch out.
     *
     * @return bool
     */
    public function uninstall($pdb, $schema)
    {
        return true;
    }

    public function upgrade($old_version)
    {
        return true;
    }

    /**
     * Manually load config that has all of our streams table data.
     *
     * @return mixed False or the config array
     */
    private function loadConfig()
    {
        if (defined('PYROPATH')) {
            require_once(PYROPATH.'modules/streams_core/config/streams.php');
        } elseif (defined('APPPATH')) {
            require_once(APPPATH.'modules/streams_core/config/streams.php');
        }

        return (isset($config)) ? $config : false;
    }
}
