<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Photos_m extends MY_Model
{
    function get_by_album($album_id)
    {
    	return parent::order_by('`order`')->get_many_by('album_id', $album_id);
    }
    
	function insert($image, $album_id, $caption)
    {
        $this->load->helper('date');
        $filename = $image['file_name'];
        
        $image_cfg['image_library'] = 'GD2';
        $image_cfg['source_image'] = APPPATH.'assets/img/photos/' . $album_id . '/' . $filename;
        $image_cfg['create_thumb'] = TRUE;
        $image_cfg['maintain_ratio'] = TRUE;
        $image_cfg['width'] = '150';
        $image_cfg['height'] = '125';
        $this->load->library('image_lib');
        $this->image_lib->initialize($image_cfg);
        $this->image_lib->resize();

        $order_id = (int) $this->db->select_max('id')->get('photos')->row()->id + 1;        

        return parent::insert(array(
        	'filename'		=> $filename,
        	'album_id'		=> $album_id,
        	'caption'	=> $caption,
            '`order`'            => $order_id,
        	'updated_on'	=> now()
        ));
    }

    function update_caption($photo_id)
    {
		$this->db->where('album_id', $this->input->post('album'))->where('id', $photo_id);
		$this->db->update('photos', array('caption' => $this->input->post('caption_update')));
		return TRUE;
    }
    
}

?>
