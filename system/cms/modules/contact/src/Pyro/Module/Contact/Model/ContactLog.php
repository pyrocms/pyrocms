<?php namespace Pyro\Module\Contact\Model;

use Illuminate\Database\Eloquent\Model;

/**
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Contact\Models
 */
class ContactLog extends Model {
	
	/**
	 * Define the table name
	 *
	 * @var string
	 */
	public $table = 'contact_log';
	
	/**
	 * Disable updated_at and created_at on table
	 *
	 * @var boolean
	 */
	public $timestamps = false;
	
	/**
	 * Get all contact logs ordered by name
	 *
	 * @param string $direction The direction to sort results
	 * @return void
	 */
	public static function findAndSortByDate($direction = 'desc')
	{
		return static::orderBy('sent_at', $direction)->get();
	}
	
}