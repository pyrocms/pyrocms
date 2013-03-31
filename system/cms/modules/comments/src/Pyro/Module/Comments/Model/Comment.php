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
     * Get comments based on a module item
     *
     * @param  string $module    The name of the module
     * @param  int    $entry_key The singular key of the entry (E.g: blog:post or pages:page)
     * @param  int    $entry_id  The ID of the entry
     * @param  bool   $is_active Is the comment active?
     * @return array
     */
    public static function findByEntry($module, $entry_key, $entry_id, $is_active = true)
    {
        //@TODO Update this query once we have relationships setup in the users model
        return ci()->pdb
            ->table('comments c')
            ->select(
                ci()->pdb->raw('u.username'),
                ci()->pdb->raw('p.display_name'),
                ci()->pdb->raw('IF(c.user_id > 0, p.display_name, c.user_name) as user_name'),
                ci()->pdb->raw('IF(c.user_id > 0, u.email, c.user_email) as user_email')
            )
            ->leftJoin('users as u', 'c.user_id', '=', 'u.id')
            ->leftJoin('profiles as p', 'p.user_id', '=', 'u.id')
            ->where('c.module', $module)
            ->where('c.entry_id', $entry_id)
            ->where('c.entry_key', $entry_key)
            ->where('c.is_active', $is_active)
            ->orderBy('c.created_on', Settings::get('comment_order'))
            ->get();
    }

    /**
     * Find recent comments
     *
     *
     * @param  int   $limit     The amount of comments to get
     * @param  int   $is_active set default to only return active comments
     * @return array
     */
    public static function findRecent($limit = 10, $is_active = 1)
    {
        //@TODO Update this query once we have relationships setup in the users model
        return ci()->pdb
            ->table('comments as c')
            ->select(
                ci()->pdb->raw('u.username'),
                ci()->pdb->raw('p.display_name'),
                ci()->pdb->raw('IF(c.user_id > 0, p.display_name, c.user_name) as user_name'),
                ci()->pdb->raw('IF(c.user_id > 0, u.email, c.user_email) as user_email')
            )
            ->join('users as u', 'c.user_id', '=', 'u.id')
            ->join('profiles as p', 'p.user_id', '=', 'u.id')
            ->where('is_active', $is_active)
            ->take($limit)
            ->orderBy('c.created_on', 'desc')
            ->get();
    }

    /**
     * Find Comments by Module and ID
     *
     *
     * @param int $module - Module Name
     * @param int $key_id - Key ID
     *
     * @return array
     */
    public static function findManyByModuleAndEntryId($module, $entry_id)
    {
        return static::where('module','=',$module)
            ->where('entry_id','=',$entry_id)
            ->get();
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
