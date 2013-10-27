<?php namespace Pyro\Module\Users\Model; 

use Pyro\Module\Streams_core\Core\Model\Entry as StreamEntry;

/**
 * Profile model for the users module.
 * 
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\User\Models
 */
class Profile extends StreamEntry
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $stream_slug = 'profiles';

    protected $stream_namespace = 'users';

    public function relationUser()
    {
    	return $this->belongsTo('Pyro\Module\Users\Model\User');
    }
}
