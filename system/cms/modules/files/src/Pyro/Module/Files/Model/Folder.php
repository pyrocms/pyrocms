<?php namespace Pyro\Module\Files\Model;

/**
 * Folder model
 *
 * @author    PyroCMS Dev Team
 * @package  PyroCMS\Core\Modules\Keywords\Models
 */
class Folder extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Define the table name
     *
     * @var string
     */
    public $table = 'file_folders';

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

}
