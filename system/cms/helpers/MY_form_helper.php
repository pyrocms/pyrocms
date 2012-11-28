<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('form_file_picker'))
{
    /**
    * File Picker Field
    *
    * @param	string
    * @param	mixed ( string or array )
    * @param	boolean
    * @return	string
	* 
	* Example 1 (single image): <?php echo form_file_picker('product_image_id', $product->product_image_id);?>
	* Example 2 (multiple images) : <?php echo form_file_picker('product_highlights', $product->product_highlights, true);?>
	*
    */
    function form_file_picker($data = '', $value = '', $multiple=false)
    {
        $output = '';

        $ci = & get_instance();

        $ci->lang->load('files/files');
        $ci->load->model('files/file_folders_m');
        $ci->load->library('files/files');

        $data_array = array();

        $data_array['input_hidden_data'] = $data;
        $data_array['input_hidden_value'] = $value;
        $data_array['multiple_select'] = $multiple?'true':'false';

        $data_array['field_id'] = is_array($data)?$data['name']:$data;
        $data_array['folders'] = $ci->file_folders_m->count_by('parent_id', 0);
        $data_array['folder_tree'] = Files::folder_tree();

        $output .= '<div class="file-picker-container" id="file-picker-container_'.$data_array['field_id'].'" field-id="'.$data_array['field_id'].'">';
        $output .= '<div class="file-container">';
        $output .= '<ul class="selected-files-container">';
        if ( is_array($value) && count($value)>0 ) {
            foreach ( $value AS $val ) {
                $file = Files::get_file($value);
                $output .= '<li data-id="'.$value.'"><span>'.$file['data']->name.'</span><input type="hidden" value="'.$file['data']->id.'" name="'.$value.'"/><a href="javascript:" class="unselected-button"><span>x</span></a></li>';
            }
        } elseif ( isset($value) && is_numeric($value) ) {
            $file = Files::get_file($value);
            $output .= '<li data-id="'.$value.'"><span>'.$file['data']->name.'</span><input type="hidden" value="'.$file['data']->id.'" name="'.$value.'"/><a href="javascript:" class="unselected-button"><span>x</span></a></li>';
        }
        $output .= '</ul>';
        $output .= '</div>';
        $output .= '<a class="file-picker-link btn button orange" href="#file-picker-'.$data_array['field_id'].'">select</a><div class="clear" style="clear:both;"></div>';
        $output .= $ci->load->view('admin/partials/file_picker', $data_array, true);
        $output .= '</div>';
        return $output;
    }
}