<?php 

/**
 * Redirect model
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Redirects\Models 
 */
class Redirect_m extends MY_Model
{

    /**
     * Gets a single redirect using the id.
     *
     * @param   mixed   $where
     * @return  object
     */
    public function get($id)
    {
        return $this->pdb
            ->table($this->_table)
            ->where($this->primary_key, '=', $id)
            ->first();
    }

    /**
     * Gets all redirects
     *
     * @return  object
     */
    public function getAll()
    {
        return $this->pdb
            ->table($this->_table)
            ->get();
    }

    public function getFrom($from)
    {
        return $this->pdb
            ->table($this->_table)
            ->where('from', '=', $from)
            ->first();
    }

    public function countAll()
    {
        return $this->pdb
            ->table($this->_table)
            ->count();
    }

    public function insert($input = array(), $skip_validation = false)
    {
        return $this->pdb
            ->table($this->_table)
            ->insertGetId(array(
                '`type`' => $input['type'],
                '`from`' => str_replace('*', '%', $input['from']),
                '`to`' => trim($input['to'], '/'),
            ));
    }

    public function update($id, $input = array(), $skip_validation = false)
    {
        return $this->pdb
            ->table($this->_table)
            ->where('id', '=', $id)
            ->update(array(
                '`type`' => $input['type'],
                '`from`' => str_replace('*', '%', $input['from']),
                '`to`' => trim($input['to'], '/')
            ));
    }

    public function delete($id)
    {
        return $this->pdb
            ->table($this->_table)
            ->where('id', '=', $id)
            ->delete();
    }

    // Callbacks
    public function checkFrom($from, $id = 0)
    {
        if($id > 0)
        {
            $this->pdb->where('id', '!=', $id);
        }

        return $this->pdb
                    ->table($this->_table)
                    ->where('`from`', str_replace('*', '%', $from))
                    ->count();
    }
}