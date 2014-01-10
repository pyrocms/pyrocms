<?php namespace Pyro\Module\Users\Model; 

use Pyro\Module\Streams_core\Data\UsersProfilesEntryModel;

/**
 * Profile model for the users module.
 * 
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\User\Models
 */
class Profile extends UsersProfilesEntryModel
{
    /**
     * User relation
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
    	return $this->belongsTo('Pyro\Module\Users\Model\User');
    }
}
