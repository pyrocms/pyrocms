<?php namespace Pyro\Module\Files\Model;

use Pyro\Model\Eloquent;

/**
 * Folder model
 *
 * @author   PyroCMS Dev Team
 * @package  PyroCMS\Core\Modules\Keywords\Models
 * @link     http://docs.pyrocms.com/2.3/api/classes/Pyro.Module.Files.Model.Folder.html
 */
class Folder extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'file_folders';

    /**
     * Cache minutes
     *
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
    public $timestamps = false;

    /**
     * Relationship to child folders
     *
     * @return object
     */
    public function folders()
    {
        return $this->hasMany('Pyro\Module\Files\Model\Folder', 'parent_id');
    }

    /**
     * Find a child folder by slug
     *
     * @param $slug
     * @return object
     */
    public function findChildBySlug($slug)
    {
        return $this->hasMany('Pyro\Module\Files\Model\Folder', 'parent_id')->whereSlug($slug)->first();
    }

    /**
     * Relationship to File
     *
     * @return object
     */
    public function files()
    {
        return $this->hasMany('Pyro\Module\Files\Model\File', 'folder_id');
    }

    /**
     * Get a single folder by slug
     *
     * @param  string $slug The slug of the folder to retrieve
     * @return object
     */
    public static function findBySlug($slug)
    {
        return static::where('slug', '=', $slug)->get();
    }

    /**
     * Get a folder by slug and not id
     *
     * @param  string $slug The slug of the folder to retrieve
     * @return object
     */
    public static function findBySlugAndNotId($slug, $id)
    {
        return static::where('slug', '=', $slug)
            ->where('id', '!=', $id)
            ->get();
    }

    /**
     * Get a folder by slug and not id
     *
     * @param  int $parent_id The slug of the folder to retrieve
     * @return object
     */
    public static function countByParentId($parent_id)
    {
        return static::where('parent_id', '=', $parent_id)->count();
    }

    /**
     * Get all folders ordered by sort
     *
     * @param  string $direction The direction to sort results
     * @return void
     */
    public static function findAllOrdered($direction = 'asc')
    {
        return static::orderBy('sort', $direction)->get();
    }

    /**
     * Get Folders by parent
     *
     * @param  int $parent_id
     * @return void
     */
    public static function findByParent($parent_id = 0)
    {
        return static::where('parent_id', '=', $parent_id)->get();
    }

    /**
     * Get Folders by parent
     *
     * @param  int $parent_id
     * @return void
     */
    public static function findByParentAndSortByName($parent_id = 0)
    {
        return static::where('parent_id', '=', $parent_id)->orderBy('name')->get();
    }

    /**
     * Get Folders by parent ordered by sort
     *
     * @param  int $parent_id
     * @return void
     */
    public static function findByParentBySort($parent_id = 0)
    {
        return static::where('parent_id', '=', $parent_id)->orderBy('sort')->get();
    }

    /**
     * Get Folders by path
     *
     * @param  string $path
     * @return folder object
     */
    public static function findByPath($path)
    {
        $path = explode('/', trim($path, '/'));

        // Get the root folder
        $folder = self::with('folders')->whereSlug(array_shift($path))->whereParentId(0)->first();

        // Cycle and find by slug within parent
        foreach ($path as $slug) {
            $folder = $folder->findChildBySlug($slug);
        }

        return $folder;
    }

    /**
     * Get Files by an array of keywords
     *
     * @param array   $search
     * @param integer $limit
     * @return void
     */
    public static function findByKeywords($search, $limit = 5)
    {
        // first we search folders
        Static::select('name', 'parent_id');

        foreach ($search as $match) {
            $match = trim($match);

            Static::where(
                function ($query) {
                    $query->orWhere('name', 'like', $match);
                    $query->orWhere('location', 'like', $match);
                    $query->orWhere('remote_container', 'like', $match);
                }
            );
        }

        return static::take($limit)->get();
    }
}
