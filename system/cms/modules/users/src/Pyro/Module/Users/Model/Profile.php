<?php namespace Pyro\Module\Users\Model;

use Pyro\Module\Streams\Model\UsersProfilesEntryModel;

/**
 * Profile model for the users module.
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\User\Models
 */
class Profile extends UsersProfilesEntryModel
{

    /**
     * Presenter Class
     * @var string
     */
    public $presenterClass = 'Pyro\Module\Users\Presenter\ProfileEntryPresenter';

    /**
     * Cache minutes
     * @var int
     */
    public $cacheMinutes = 30;

    /**
     * User relation
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Pyro\Module\Users\Model\User');
    }
}
