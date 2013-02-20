<?php namespace Pyro\Module\Comments\Model;

/**
 * Comment model
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Redirects\Models 
 */
class Comment extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

}