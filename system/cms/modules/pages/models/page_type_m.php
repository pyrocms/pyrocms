<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Page type model
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Pages\Models
 */
class Page_type_m extends MY_Model
{
	
    /**
     * Get a page type
     *
     * @access  public
     * @param   int - id
     * @return  mixed
     */
    public function get($id)
    {
        $pt = $this->db
                ->limit(1)
                ->where('id', $id)
                ->get($this->_table)->row();
    
        if ( ! $pt) return null;

        // Do we have things saved as files? If
        // so, we should grab them.
        if ($pt->save_as_files == 'y')
        {
            $this->load->helper('file');
        
            $folder = FCPATH.'assets/page_types/'.$pt->slug.'/';

            $pt->body   = read_file($folder.$pt->slug.'.html');
            $pt->js     = read_file($folder.$pt->slug.'.js');
            $pt->css    = read_file($folder.$pt->slug.'.css');
        }

        return $pt;
    }

    // --------------------------------------------------------------------------

    /**
     * Get all
     *
     * Get all of the 
     */
    public function get_all()
    {
        $pts = $this->db->get($this->_table)->result();
    
        foreach ($pts as $pt)
        {
            $this->get_page_type_files_for_page($pt, true);
        }

        return $pts;
    }

    // --------------------------------------------------------------------------

    /**
     * Create a new page type
	 *
	 * 
	 * @param array $input The input to insert into the DB
	 * @return mixed
	 *
     */
    public function insert($input = array(), $skip_validation = false)
    {
        $this->load->helper('date');

        $input['updated_on'] = now();

        return parent::insert($input);
    }

    // --------------------------------------------------------------------------

    /**
     * Update a page type
	 *
	 * @param int $id The ID of the page type to update
	 * @param array $input The data to update
	 * @return mixed
     */
    public function update($id = 0, $input = array(), $skip_validation = false)
    {
        $this->load->helper('date');

        $input['updated_on'] = now();

        return parent::update($id, $input);
    }

    // --------------------------------------------------------------------------

    /**
     * Validation callback to check the
     * page type slug. We want page type slugs
     * to be unique so we can use them as folder
     * names when saving as files.
     *
     * @access  public
     * @param   string $slug - the page slug
     * @return  bool
     */
    public function _check_pt_slug($slug)
    {
        if (parent::count_by(array('slug' => $slug)) == 0)
        {
            return true;
        }
        else
        {
            $this->form_validation->set_message('_check_pt_slug', lang('page_types._check_pt_slug_msg'));
            return false;
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Place files for layout files.
     *
     */
    public function place_page_layout_files($input)
    {
        // Our folder path:
        $folder = FCPATH.'assets/page_types/'.$input['slug'];

        if (is_dir($folder))
        {
            $this->remove_page_layout_files($input['slug']);
        }
        else
        {
            if ( ! mkdir($folder, 0777)) return false;
        }

        $this->load->helper('file');

        // Write our three files.
        write_file($folder.'/'.$input['slug'].'.html', $input['body']);
        write_file($folder.'/'.$input['slug'].'.js', $input['js']);
        write_file($folder.'/'.$input['slug'].'.css', $input['css']);
    }

    // --------------------------------------------------------------------------

    /**
     * Get page files
     *
     * If appropriate, gets the content from the
     * files instead of from the database.
     *
     * We also preserve the database copies for comparison
     * purposes.
     *
     */
    public function get_page_type_files_for_page(&$page, $pt = false)
    {
        if ($page->save_as_files == 'y')
        {
            // We are getting this for a pt instead of a page,
            // then our vars are just a little different.
            $pt_slug_var = $pt ? 'slug' : 'page_type_slug';

            // Grab our files.
            $this->load->helper('file');

            $folder = FCPATH.'assets/page_types/'.$page->{$pt_slug_var}.'/';

            $page->db_originals = new stdClass();

            // Body
            $page->db_originals->body = $page->body;
            if (file_exists($folder.$page->{$pt_slug_var}.'.html'))
            {
                $page->body = read_file($folder.$page->{$pt_slug_var}.'.html');
            }

            // CSS/JS
            foreach (array('css', 'js') as $ext)
            {
                $page->db_originals->$ext = $page->$ext;
                if (file_exists($folder.$page->{$pt_slug_var}.'.'.$ext))
                {
                    $page->$ext = read_file($folder.$page->{$pt_slug_var}.'.'.$ext);
                }
            }

            // Sync comparison.
            // If we are getting them for a page type list,
            // we are going to compare our 
            if ($pt)
            {
                $page->needs_sync = false;

                foreach (array('body', 'css', 'js') as $ext)
                {
                    // We only need to know one.
                    if (strcmp($page->db_originals->$ext, $page->$ext) != 0)
                    {
                        $page->needs_sync = true;
                        break;
                    }
                }
            }
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Delete 
     */
    public function delete($id, $delete_stream = false)
    {
        $page_type = $this->get($id);

        // Are we going to delete the stream?
        if ($delete_stream)
        {
            $stream = $this->streams_m->get_stream($page_type->stream_id);

            $this->streams->streams->delete_stream($stream->stream_slug, $stream->stream_namespace);
        }

        // Delete the actual page entry.
        $this->db->limit(1)->where('id', $id)->delete($this->_table);
    }

    // --------------------------------------------------------------------------

    /**
     * Rename page layout files + the folder.
     *
     */
    public function remove_page_layout_files($slug, $remove_folder = false)
    {
        $this->load->helper('file');

        delete_files(FCPATH.'assets/page_types/'.$slug);

        if ($remove_folder)
        {
            $this->remove_page_layout_folder($slug);
        }
    }

    // --------------------------------------------------------------------------

    public function remove_page_layout_folder($slug)
    {
        if (is_dir(FCPATH.'assets/page_types/'.$slug))
        {
            return rmdir(FCPATH.'assets/page_types/'.$slug);       
        }
    }
}