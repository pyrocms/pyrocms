<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Galleries_m extends Model {

    function __construct() {
        parent::Model();
    }
    
    function addPhoto($image = array(), $gallery_slug = '', $description) {
        $this->load->helper('date');
        $filename = $image['file_name'];
        
        $image_cfg['image_library'] = 'GD2';
        $image_cfg['source_image'] = APPPATH.'assets/img/galleries/' . $gallery_slug . '/' . $filename;
        $image_cfg['create_thumb'] = TRUE;
        $image_cfg['maintain_ratio'] = TRUE;
        $image_cfg['width'] = '150';
        $image_cfg['height'] = '125';
        $this->load->library('image_lib', $image_cfg);
        $this->image_lib->resize();
        
        $this->db->insert('photos', array('filename'=>$filename, 
                                          'gallery_slug'=>$gallery_slug,
                                          'description'=>$description,
                                          'updated_on'=>now()));
        return $this->db->insert_id();
    }
    
    function checkTitle($title = '') {
        $this->db->select('COUNT(title) AS total');
        $query = $this->db->getwhere('galleries', array('slug'=>url_title($title)));
        $row = $query->row();
        if ($row->total == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function newGallery($input = array()) {
		$this->load->helper('date');
        $slug = url_title($input['title']);

		if( !@mkdir(APPPATH.'assets/img/galleries/' . $slug) ) return FALSE;

		$this->db->insert('galleries', array(
			'title'			=> $input['title'],
			'slug'			=> $slug,
			'description' 	=> $input['description'],
            'parent' 		=> $input['parent'],
            'updated_on'	=> now())
		);
        
        return $this->db->insert_id();
    }

    function getGalleries($params = array()) {
        $this->db->select('galleries.*, COUNT(photos.id) AS num_photos');
        $this->db->join('photos', 'galleries.slug = photos.gallery_slug', 'LEFT');
        $this->db->groupby('galleries.slug', 'ASC');
        $query = $this->db->getwhere('galleries', $params);
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }
    
    function getGallery($slug = '') {
        $query = $this->db->getwhere('galleries', array('slug'=>$slug));
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->row();
        }
    }
    
    function getPhotos($slug = '') {     
        $query = $this->db->getwhere('photos', array('gallery_slug'=>$slug));
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }
    
    function updateGallery($input, $oldslug) {

        $this->load->helper('date');
        
        $slug = url_title($input['title']);
        
        $this->db->update('galleries', array(
        	'title'		=> $input['title'],
        	'slug'			=> $slug,
        	'description' 	=> $input['description'],
        	'parent' 		=> $input['parent'],
        	'updated_on'	=> now()
        ), array('slug'=>$oldslug));
        
        $this->db->update('photos', array('gallery_slug'=>$slug), array('gallery_slug'=>$oldslug));
        
        // No point trying a rename if it slug is not updated
        if( $oldslug != $slug)
        {
        	rename(APPPATH.'assets/img/galleries/' . $oldslug, APPPATH.'assets/img/galleries/' . $slug);
        }
        
        return TRUE;
    }

    function deleteGallery($slug = '') {
        // Photos are not deleted from the server for archival purposes (an excuse by CI Lee for not implementing the delete?)
		$this->db->delete('photos', array('gallery_slug'=>$slug));
        $this->db->delete('galleries', array('slug'=>$slug));
    	return $this->db->affected_rows();
    }

	function deleteGalleryPhoto($id) {
        $this->db->delete('photos', array('id'=>$id));
		return $this->db->affected_rows();
    }
    
    // -- DIRTY frontend functions. Move these to views sometimes
    
	function galleryPhotos($gallery = '', $numPhotos = 5) {
        $string = '<div id="photos"><ul>';
        if (empty($gallery)) {
            $this->db->order_by('updated_on', 'DESC');
            $query = $this->db->get('photos', 5, 0);

        } else {
            $query = $this->db->getwhere('photos', array('gallery_slug'=>$gallery), 5, 0);
        }
        foreach ($query->result() as $photo) {
            $string .= '<li><a href="'. image_path('galleries/' . $photo->gallery_slug . '/' . $photo->filename) . '" rel="modal" title="' . $photo->description . '">' . image('galleries/' . $photo->gallery_slug . '/' . substr($photo->filename, 0, -4) . '_thumb' . substr($photo->filename, -4), '', array('title'=>$photo->description)) . '</a></li>';
        }
        $string .= '</ul></div>';
        return $string;
    }

    function galleryPhotosList($gallery = '', $numPhotos = 5) {
        $string = '<ul>';
        if (empty($gallery)) {
            $this->db->order_by('updated_on', 'DESC');
            $query = $this->db->get('photos', 5, 0);

        } else {
            $query = $this->db->getwhere('photos', array('gallery_slug'=>$gallery), $numPhotos, 0);
        }
        foreach ($query->result() as $photo) {
            $string .= '<li><a href="'. image_path('galleries/' . $photo->gallery_slug . '/' . $photo->filename) . '" rel="modal" title="' . $photo->description . '">' . image('galleries/' . $photo->gallery_slug . '/' . substr($photo->filename, 0, -4) . '_thumb' . substr($photo->filename, -4), '', array('title'=>$photo->description)) . '</a></li>';
        }
        $string .= '</ul>';
        return $string;
    }  
}

?>
