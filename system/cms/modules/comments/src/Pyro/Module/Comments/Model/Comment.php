<?php namespace Pyro\Module\Comments\Model;

use Settings;
use Pyro\Model\Eloquent;

/**
 * Comment model
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Comments\Models
 */
class Comment extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * Cache minutes
     * @var int
     */
    public $cacheMinutes = 30;

    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = array();

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = true;

    /**
     * Returns the relationship between comments and users
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Pyro\Module\Users\Model\User');
    }

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
       return static::with('user', 'user.profile')
            ->where('module', $module)
            ->where('entry_id', $entry_id)
            ->where('entry_key', $entry_key)
            ->where('is_active', $is_active)
            ->orderBy('created_at', Settings::get('comment_order'))
            ->get();
    }

    /**
     * Find recent comments
     *
     *
     * @param  int    $limit     The amount of comments to get
     * @param  bool   $is_active Is the comment active?
     * @return array
     */
    public static function findRecent($limit = 10, $is_active = true)
    {
        return static::with('user', 'user.profile')
            ->where('is_active', $is_active)
            ->take($limit)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Find with Filter
     *
     * @param  array $filter Magical array of random stuff required for CP filter results
     * @return array
     */
    public static function findWithFilter($filter)
    {
        $query = static::with('user', 'user.profile');

        if (isset($filter['module'])) {
            $query->where('module', $filter['module']);
        }

        return $query->where('is_active', $filter['is_active'])
            ->orderBy($filter['order-by'], $filter['order-dir'])
            ->take($filter['limit'])
            ->skip($filter['offset'])
            ->get();
    }

    /**
     * Count with Filter
     *
     * @param  array $filter Magical array of random stuff required for CP filter results
     * @return int
     */
    public static function countWithFilter($filter)
    {
        $query = static::where('is_active', $filter['is_active']);

        if (isset($filter['module'])) {
            $query->where('module', $filter['module']);
        }

        return $query->count();
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
        $slugs = static::select('comments.module', 'modules.name')
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

    /**
     * Get User Name Attribute
     *
     * @param  string $value The user (commenters) name
     * @return array
     */
    public function getUserNameAttribute($value)
    {
        return $value ?: ($this->user->profile->display_name ?: $this->user->username);
    }

}
