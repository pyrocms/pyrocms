<?php namespace Pyro\Module\Maintenance\Model;

/**
 * Data Module
 *
 * @author	 PyroCMS Dev Team
 * @package	 PyroCMS\Core\Modules\Maintenance\Models
 * @link     http://docs.pyrocms.com/2.3/api/classes/Pyro.Module.Maintenance.Model.Data.html
 */
class Data
{
    /**
     * Export tables
     *
     * @param string $table The name of the table.
     * @param string $type The export format type
     * @param string $table_list An array of database tables that are eligible to be exported
     *
     * @return array
     */
    public function export($table, $type = 'xml', $table_list)
    {
        $db = ci()->pdb;

        switch ($table) {
            case 'users':
                return $db
                    ->table('users')
                    ->select('users.id', 'email')
                    ->select($db->raw('IF(active = 1, "Y", "N") as active'))
                    ->select('first_name', 'last_name', 'display_name', 'company', 'lang', 'gender', 'website')
                    ->join('profiles', 'profiles.user_id',  '=', 'users.id')
                    ->get()
                    ->toArray();

            case 'files':
                return $db
                    ->table('files')
                    ->select('files.*', 'file_folders.name as folder_name', 'file_folders.slug')
                    ->join('file_folders', 'files.folder_id', '=', 'file_folders.id')
                    ->get()
                    ->toArray();

            default:
                return $db
                    ->table($table)
                    ->get()
                    ->toArray();
        }
    }
}
