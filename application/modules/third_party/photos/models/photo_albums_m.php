<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Photo_albums_m extends MY_Model
{
    function get($id = 0)
    {
        $this->db->select('pa.*, COUNT(p.id) AS num_photos')
        	->join('photos p', 'pa.id = p.album_id', 'LEFT')
        	->group_by('pa.slug');
        
        if( $id > 0 )
        {
        	$this->db->where('pa.id', $id);
        }
        	
        return $this->db->get('photo_albums pa')
        	->result();
    }
    
    function insert($input = array())
    {
		$this->load->helper('date');
        $slug = url_title($input['title']);

		if( !@mkdir(APPPATH.'assets/img/photos/' . $slug) ) return FALSE;

		$this->db->insert('photo_albums', array(
			'title'			=> $input['title'],
			'slug'			=> $slug,
			'description' 	=> $input['description'],
            'parent' 		=> $input['parent'],
            'updated_on'	=> now())
		);
        
        return $this->db->insert_id();
    }
    
    function update($id, $input)
    {
        $this->load->helper('date');
        
        $old = parent::get($id);
        $new_slug = url_title($input['title']);
        
        $this->db->update('photo_albums', array(
        	'title'			=> $input['title'],
        	'slug'			=> $new_slug,
        	'description' 	=> $input['description'],
        	'parent' 		=> $input['parent'],
        	'updated_on'	=> now()
        ), array('id'=> $id));
        
        // No point trying a rename if it slug is not updated
        if( $old->slug != $new_slug)
        {
        	rename(APPPATH.'assets/img/photos/' . $old->slug, APPPATH.'assets/img/photos/' . $new_slug);
        }
        
        return TRUE;
    }

    function delete($id = 0)
    {
		$album = parent::get($id);
    	
		// Delete files
		$this->load->helper('file');
		
		$path = APPPATH.'assets/img/photos/'.$album->slug;
		delete_files($path, TRUE);
		@rmdir($path);
		
    	$this->db->delete('photos', array('album_id'=>$id));
        return parent::delete($id);
    }

    function check_title($title = '')
    {
		return parent::count_by('slug', url_title($title)) === 0;
    }
    
    // -- DIRTY frontend functions. Move these to views sometimes
    
	function albumPhotos($id = '', $numPhotos = 5) {
        $string = '<div id="photos"><ul>';
        if (empty($album)) {
            $this->db->order_by('updated_on', 'DESC');
            $query = $this->db->get('photos', 5, 0);

        } else {
            $query = $this->db->get_where('photos', array('album_slug'=>$album), 5, 0);
        }
        foreach ($query->result() as $photo) {
            $string .= '<li><a href="'. image_path('photo_albums/' . $photo->album_slug . '/' . $photo->filename) . '" rel="modal" title="' . $photo->description . '">' . image('photo_albums/' . $photo->album_slug . '/' . substr($photo->filename, 0, -4) . '_thumb' . substr($photo->filename, -4), '', array('title'=>$photo->description)) . '</a></li>';
        }
        $string .= '</ul></div>';
        return $string;
    }

    function albumPhotosList($album = '', $numPhotos = 5) {
        $string = '<ul>';
        if (empty($album)) {
            $this->db->order_by('updated_on', 'DESC');
            $query = $this->db->get('photos', 5, 0);

        } else {
            $query = $this->db->get_where('photos', array('album_slug'=>$album), $numPhotos, 0);
        }
        foreach ($query->result() as $photo) {
            $string .= '<li><a href="'. image_path('photo_albums/' . $photo->album_slug . '/' . $photo->filename) . '" rel="modal" title="' . $photo->description . '">' . image('photo_albums/' . $photo->album_slug . '/' . substr($photo->filename, 0, -4) . '_thumb' . substr($photo->filename, -4), '', array('title'=>$photo->description)) . '</a></li>';
        }
        $string .= '</ul>';
        return $string;
    }
}

?>
