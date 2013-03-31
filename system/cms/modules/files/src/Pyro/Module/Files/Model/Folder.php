<?php namespace Pyro\Module\Files\Model;

/**
 * Folder model
 *
 * @author   PyroCMS Dev Team
 * @package  PyroCMS\Core\Modules\Keywords\Models
 * @link     http://docs.pyrocms.com/2.3/api/classes/Pyro.Module.Files.Model.Folder.html
 */
class Folder extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'file_folders';

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

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
                        ->where('id','!=',$id)
                        ->get();
    }

    /**
     * Get all folders ordered by sort
     *
     * @param  string $direction The direction to sort results
     * @return void
     */
    public static function findAndSortBySort($direction = 'asc')
    {
        return static::orderBy('sort', $direction)->get();
    }

    /**
     * Get Folders by parent
     *
     * @param  int  $parent_id
     * @return void
     */
    public static function findByParent($parent_id = 0)
    {
        return static::where('parent_id', '=', $parent_id)->get();
    }

    /**
     * Get Folders by parent
     *
     * @param  int  $parent_id
     * @return void
     */
    public static function findByParentByName($parent_id = 0)
    {
        return static::where('parent_id','=',$parent_id)->orderBy('name')->get();
    }

    /**
     * Get Folders by parent ordered by sort
     *
     * @param  int  $parent_id
     * @return void
     */
    public static function findByParentBySort($parent_id = 0)
    {
        return static::where('parent_id','=',$parent_id)->orderBy('sort')->get();
    }

    /**
     * Get Folders by path
     *
     * @param  string $path
     * @return folder object
     */
    public function findByPath($path)
    {
        if (is_array($path)) {
            $path = implode('/', $path);
        }

        $path = trim($path, '/');

        return static::where('virtual_path', $path)->get();
    }

    /**
     * Get Files by an array of keywords
     *
     * @param array   $search
     * @param integer $limit
     *
     * @return void
     */
    public static function findByKeywords($search, $limit = 5)
    {
        // first we search folders
        Static::select('name', 'parent_id');

        foreach ($search as $match) {
            $match = trim($match);

            Static::where(function($query) {
                $query->orWhere('name','like',$match);
                $query->orWhere('location','like',$match);
                $query->orWhere('remote_container','like',$match);
            });
        }

        return static::take($limit)->get();
    }
}
