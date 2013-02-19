<?php namespace Pyro\Module\Domains\Model;

/**
 * Domain model
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Redirects\Models 
 */
class Domain extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'domains';

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

    public function site()
    {
        return $this->belongsTo('site');
    }

    /**
     * Find by domain with ID
     *
     * @param string $domain The domain
     * @param int $id of the domain
     *
     * @return void
     */
    public static function findByDomainAndId($domain, $id = 0)
    {
        return static::where('id', '!=', $id)
                    ->where('domain', '=', $domain)->first();
    }

}