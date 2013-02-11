<?php namespace Pyro\Module\Files\Model;

/**
 * File model
 *
 * @author   PyroCMS Dev Team
 * @package  PyroCMS\Core\Modules\Keywords\Models
 */
class File extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Define the table name
     *
     * @var string
     */
    public $table = 'files';

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Get files by folder_id
     *
     * @param  int $folder_id The folder_id of the files to retrieve
     * @return object
     */
    public static function findByFolderId($folder_id)
    {
        return static::where('folder_id', '=', $folder_id)->get();
    }

    /**
     * Get Files by parent ordered by sort
     *
     * @param int $parent_id
     * @return void
     */
    public static function findByParentAndSortBySort($parent_id = 0)
    {
        return static::where('parent_id','=',$parent_id)->orderBy('sort')->get();
    }
	
	public static function findByKeywords($search, $limit = 5)
	{
		// search the file records
		static::select('name', 'folder_id');

		foreach ($search as $match) 
		{
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
