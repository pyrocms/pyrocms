<?php namespace Pyro\Module\Comments\Model;

/**
 * Comment model
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Comments\Models 
 */
class Comment extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Approve a comment
     *
     * @param int $id The ID of the comment to approve
     * @return mixed
     */
    public static function approve($id)
    {
        return parent::update($id, array('is_active' => true));
    }
    
    /**
     * Unapprove a comment
     *
     * @param int $id The ID of the comment to unapprove
     * @return mixed
     */
    public static function unapprove($id)
    {
        return parent::update($id, array('is_active' => false));
    }

    /**
     * Return array of modules that have comments
     *
     * @return array
     */
    public static function getModuleSlugs()
    {
        $slugs = ci()->pdb
            ->table('comments')
            ->select('comments.modules, modules.name')
            ->leftJoin('modules', 'comments.module',  '=', 'modules.slug')
            ->get();

        $options = array();
        
        if ( ! empty($slugs)) {
            foreach ($slugs as $slug) {
                if ( ! $slug->name and ($pos = strpos($slug->module, '-')) !== false) {
                    $slug->ori_module   = $slug->module;
                    $slug->module       = substr($slug->module, 0, $pos);
                }

                if ( ! $slug->name and $module = $this->module_m->get_by('slug', plural($slug->module))) {
                    $slug->name = $module->name;
                }

                //get the module name
                if ($slug->name and $module_names = unserialize($slug->name)) {
                    if (array_key_exists(CURRENT_LANGUAGE, $module_names)) {
                        $slug->name = $module_names[CURRENT_LANGUAGE];
                    } else {
                        $slug->name = $module_names['en'];
                    }

                    if (isset($slug->ori_module)) {
                        $options[$slug->ori_module] = $slug->name . " ($slug->ori_module)";
                    } else {
                        $options[$slug->module] = $slug->name;
                    }
                } else {
                    if (isset($slug->ori_module)) {
                        $options[$slug->ori_module] = $slug->ori_module;
                    } else {
                        $options[$slug->module] = $slug->module;
                    }
                }
            }
        }

        asort($options);

        return $options;
    }

}