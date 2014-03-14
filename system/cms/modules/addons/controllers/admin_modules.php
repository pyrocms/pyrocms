<?php
use Pyro\Module\Streams\Stream\StreamModel;

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Modules controller, lists all installed modules
 *
 * @package 	PyroCMS\Core\Modules\Addons\Controllers
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 */

class Admin_modules extends Admin_Controller
{
    /**
     * The current active section
     *
     * @var string
     */
    protected $section = 'modules';

    /**
     * Constructor method
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->modules = $this->moduleManager->getModel();

        $this->lang->load('addons');
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->moduleManager->registerUnavailableModules();

        $all_modules = $this->moduleManager->getAll();

        $core_modules = $addon_modules = array();
        foreach ($all_modules as $module) {
            if ($module['is_core']) {
                $core_modules[] = $module;
            } else {
                $addon_modules[] = $module;
            }
        }

        $this->template
            ->title($this->module_details['name'])
            ->set('core_modules', $core_modules)
            ->set('addon_modules', $addon_modules)
            ->build('admin/modules/index');
    }

    /**
     * Upload
     *
     * Uploads an addon module
     *
     * @return	void
     */
    public function upload()
    {
        if (( ! Settings::get('addons_upload'))) {
            show_error('Uploading add-ons has been disabled for this site. Please contact your administrator.');
        }

        if ($this->input->post('btnAction') == 'upload') {
            $config['upload_path'] 		= UPLOAD_PATH;
            $config['allowed_types'] 	= 'zip';
            $config['max_size']			= 20480;
            $config['overwrite'] 		= true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload()) {
                $upload_data = $this->upload->data();

                // Now try to unzip
                $this->load->library('unzip');
                $this->unzip->allow(array('xml', 'html', 'css', 'js', 'png', 'gif', 'jpeg', 'jpg', 'swf', 'ico', 'php'));

                // Try and extract
                if ( is_string($slug = $this->unzip->extract($upload_data['full_path'], ADDONPATH.'modules/', true, true)) ) {
                    $redirect = 'addons/modules';
                    $this->session->set_flashdata('success', sprintf(lang('addons:modules:upload_success'), $slug));
                } else {
                    $redirect = 'addons/modules/upload';
                    $this->session->set_flashdata('error', $this->unzip->error_string());
                }

                // Delete uploaded file
                unlink($upload_data['full_path']);
            } else {
                $redirect = 'addons/modules/upload';
                $this->session->set_flashdata('error', $this->upload->display_errors());
            }

            redirect('admin/'.$redirect);
        }

        $this->template
            ->title($this->module_details['name'], lang('addons:modules:upload_title'))
            ->build('admin/modules/upload');
    }

    /**
     * Uninstall
     *
     * Uninstalls an addon module
     *
     * @param	string	$slug	The slug of the module to uninstall
     * @return	void
     */
    public function uninstall($slug = '')
    {
        $module = $this->modules->findBySlug($slug);

        if ($module and $this->moduleManager->uninstall($slug)) {
            $this->session->set_flashdata('success', sprintf(lang('addons:modules:uninstall_success'), $module->name));

            // Fire an event. A module has been disabled when uninstalled.
            Events::trigger('module_uninstalled', $module);
        } else {
            $this->session->set_flashdata('error', sprintf(lang('addons:modules:uninstall_error'), $module->name));
        }

        redirect('admin/addons/modules');
    }

    /**
     * Delete
     *
     * Completely deletes an addon module
     *
     * @param	string	$slug	The slug of the module to delete
     * @return	void
     */
    public function delete($slug = '')
    {
        // Don't allow user to delete the entire module folder
        if ($slug === '/' or $slug === '*' or empty($slug)) {
            show_error(lang('addons:modules:module_not_specified'));
        }

        // lets kill this thing
        if ($this->module_m->uninstall($slug) and $this->module_m->delete($slug)) {
            $this->session->set_flashdata('success', sprintf(lang('addons:modules:delete_success'), $slug));

            $path = ADDONPATH.'modules/'.$slug;

            // they can only delete it if it's in the addons folder
            if ( is_dir($path) ) {
                if (!$this->_delete_recursive($path)) {
                    $this->session->set_flashdata('notice', sprintf(lang('addons:modules:manually_remove'), $path));
                }
            }

            // Fire an event. A module has been disabled when deleted.
            Events::trigger('module_deleted', $slug);
        } else {
            $this->session->set_flashdata('error', sprintf(lang('addons:modules:delete_error'), $slug));
        }

        redirect('admin/addons/modules');
    }

    /**
     * Enable
     *
     * Enables an addon module
     *
     * @param	string	$slug	The slug of the module to enable
     * @return	void
     */
    public function install($slug)
    {
        $module = $this->modules->findBySlug($slug);

        if ($module and $this->moduleManager->install($slug)) {
            // Fire an event. A module has been enabled when installed.
            Events::trigger('module_installed', $module);

            // Clear the module cache
            $this->cache->forget('module_m');
            $this->session->set_flashdata('success', sprintf(lang('addons:modules:install_success'), $module->name));
        } else {
            $this->session->set_flashdata('error', sprintf(lang('addons:modules:install_error'), $module->name));
        }

        redirect('admin/addons/modules');
    }

    /**
     * Enable
     *
     * Enables an addon module
     *
     * @param	string	$slug	The slug of the module to enable
     * @return	void
     */
    public function enable($slug)
    {
        $module = $this->modules->findBySlug($slug);

        if ($module and $module->enable()) {
            // Fire an event. A module has been enabled.
            Events::trigger('module_enabled', $module);

            // Clear the module cache
            $this->cache->forget('module_m');
            $this->session->set_flashdata('success', sprintf(lang('addons:modules:enable_success'), $module->name));
        } else {
            $this->session->set_flashdata('error', sprintf(lang('addons:modules:enable_error'), $module->name));
        }

        redirect('admin/addons/modules');
    }

    /**
     * Disable
     *
     * @param	string	$slug	The slug of the module to disable
     * @return	void
     */
    public function disable($slug)
    {
        $module = $this->modules->findBySlug($slug);

        if ($module and $module->disable()) {
            // Fire an event. A module has been disabled.
            Events::trigger('module_disabled', $module);

            // Clear the module cache
            $this->cache->forget('module_m');
            $this->session->set_flashdata('success', sprintf(lang('addons:modules:disable_success'), $module->name));
        } else {
            $this->session->set_flashdata('error', sprintf(lang('addons:modules:disable_error'), $module->name));
        }

        redirect('admin/addons/modules');
    }

    /**
     * Upgrade
     *
     * @param	string	$slug	The slug of the module to disable
     * @return	void
     */
    public function upgrade($slug)
    {
        $module = $this->modules->findBySlug($slug);

        // If upgrade succeeded
        if ($module and $this->moduleManager->upgrade($slug)) {
            // Fire an event. A module has been upgraded.
            Events::trigger('module_upgraded', $module);

            $this->session->set_flashdata('success', sprintf(lang('addons:modules:upgrade_success'), $module->name));
        }
        // If upgrade failed
        else {
            $this->session->set_flashdata('error', sprintf(lang('addons:modules:upgrade_error'), $module->name));
        }

        redirect('admin/addons/modules');
    }

    /**
     * Recompile
     */
    public function recompile()
    {
        foreach (StreamModel::all() as $stream) {
            $stream->save();
        }

        redirect('admin/addons/modules');
    }

    /**
     * Delete Recursive
     *
     * Recursively delete a folder
     *
     * @param	string	$str	The path to delete
     * @return	bool
     */
    private function _delete_recursive($str)
    {
        if (is_file($str)) {
            return @unlink($str);
        } elseif (is_dir($str)) {
            $scan = glob(rtrim($str,'/').'/*');

            foreach ($scan as $path) {
                $this->_delete_recursive($path);
            }

            return @rmdir($str);
        }
    }
}
