<?php namespace Pyro\Module\Files\Model;

/**
 * File model
 *
 * @author    PyroCMS Dev Team
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

}
