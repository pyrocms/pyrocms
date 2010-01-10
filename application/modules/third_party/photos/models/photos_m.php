<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Photos_m extends MY_Model
{
    function insert($image = array(), $album_slug = '', $description)
    {
        $this->load->helper('date');
        $filename = $image['file_name'];
        
        $image_cfg['image_library'] = 'GD2';
        $image_cfg['source_image'] = APPPATH.'assets/img/photo_albums/' . $album_slug . '/' . $filename;
        $image_cfg['create_thumb'] = TRUE;
        $image_cfg['maintain_ratio'] = TRUE;
        $image_cfg['width'] = '150';
        $image_cfg['height'] = '125';
        $this->load->library('image_lib', $image_cfg);
        $this->image_lib->resize();
        
        return parent::insert(array(
        	'filename'=>$filename,
        	'album_slug'=>$album_slug,
        	'description'=>$description,
        	'updated_on'=>now()
        ));
    }
    
}

?>
