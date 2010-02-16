<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Photo_albums_m extends MY_Model
{
	private $albums_dir;
	
	function __construct()
	{
		parent::__construct();
		$this->albums_dir = APPPATH .'assets/img/photos/';
	}
	
    function get_all()
    {
        $this->db->select('pa.*, COUNT(p.id) AS num_photos')
        	->join('photos p', 'pa.id = p.album_id', 'left')
        	->group_by('pa.slug');
    
        return $this->db->get('photo_albums pa')->result();
    }
    
    function insert($input = array())
    {
		$this->load->helper('date');
        
		$this->db->trans_begin();

		$this->db->insert('photo_albums', array(
			'title'			=> $input['title'],
			'slug'			=> $input['slug'],
			'description' 	=> $input['description'],
            'parent' 		=> $input['parent'],
            'updated_on'	=> now())
		);
		
		$id = $this->db->insert_id();
		
		if ($this->db->trans_status() === FALSE || !mkdir( $this->albums_dir . $id))
		{
		    $this->db->trans_rollback();
		    return FALSE;
		}
		else
		{
		    $this->db->trans_commit();
		    return $id;
		}
    }
    
    function update($id, $input)
    {
        $this->load->helper('date');
        
        return parent::update($id, array(
        	'title'			=> $input['title'],
        	'slug'			=> $input['slug'],
        	'description' 	=> $input['description'],
        	'parent' 		=> $input['parent'],
        	'updated_on'	=> now()
        ));
    }

    function delete($id = 0)
    {
		$this->load->helper('file');
		
		// Delete all files within the album
		delete_files($this->albums_dir . $id, TRUE);
		
		// Delete the album too
		@rmdir($this->albums_dir . $id);
		
    	$this->db->delete('photos', array('album_id'=>$id));
        return parent::delete($id);
    }

    function check_slug($slug, $id = NULL)
    {
    	if($id)
    	{
    		$this->db->where('id !=', $id);
    	}
    	
		return parent::count_by('slug', $slug) == 0;
    }
    
}

?>
