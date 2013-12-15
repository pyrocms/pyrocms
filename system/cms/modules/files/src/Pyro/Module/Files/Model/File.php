<?php namespace Pyro\Module\Files\Model;

use Pyro\Model\Eloquent;

/**
 * File model
 *
 * @author   PyroCMS Dev Team
 * @package  PyroCMS\Core\Modules\Keywords\Models
 * @link     http://docs.pyrocms.com/2.3/api/classes/Pyro.Module.Files.Model.File.html
 */
class File extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'files';

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
     * Relationship with Folder
     *
     * @return object
     */
    public function folder()
    {
        return $this->belongsTo('Pyro\Module\Files\Model\Folder', 'folder_id');
    }

    /**
     * Get files by folder_id
     *
     * @param  int    $folder_id The folder_id of the files to retrieve
     * @return object
     */
    public static function findByFolderId($folder_id)
    {
        return static::where('folder_id', '=', $folder_id)->get();
    }

    /**
     * Get Files by parent ordered by sort
     *
     * @param  int  $parent_id
     * @return void
     */
    public static function findByFolderIdBySort($parent_id = 0)
    {
        return static::where('folder_id','=',$parent_id)
            ->orderBy('sort')->get();
    }

    /**
     * Get Files by slug
     *
     * @param  string $slug
     * @return void
     */
    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->get();
    }

    /**
     * Get Files by filename
     *
     * @param  string $filename
     * @return void
     */
    public static function findByFilename($filename)
    {
        return static::where('filename', $filename)->get();
    }

    /**
     * Get Files by folder_id
     *
     * @param  string $folder_id
     * @return void
     */
    public static function findByFolder($folder_id)
    {
        return static::where('folder_id', $folder_id)->get();
    }

    /**
     * Get Files by slug and location
     *
     * @param  string $slug
     * @param  string $location
     * @return void
     */
    public static function findBySlugAndLocation($slug, $location)
    {
        return static::where('slug', $slug)
                ->where('location', $location)
                ->get();
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
        // search the file records
        static::select('name', 'folder_id');

        foreach ($search as $match) {
            $match = trim($match);

            static::where(function($query) {
                $query->orWhere('name','like',$match);
                $query->orWhere('filename','like',$match);
                $query->orWhere('extension','like',$match);
            });
        }

        return static::take($limit)->get();
    }
}
