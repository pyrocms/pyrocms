<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Settings {

	private $CI;
	
	private $items = array();
	
	function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->module_model('settings', 'settings_m');
	}
	
	function item($slug = '') {
		
		// Check for previously called settings and return it if found
		if(in_array($slug, array_keys($this->items)))
        {
        	return $this->items[$slug];
        }
		
		// Check the database for this setting
		if ($setting = $this->CI->settings_m->get($slug))
		{
        	$value = $setting->value;
        } 	
        
        // Not in the database? Try a config value instead
        else
        {
            $value = $this->CI->config->item($slug);
        }
        
        // Save the value in the items array and return it
        return $this->items[$slug] = $value;
    }
    
    function set_item($slug, $value) {
    	return $this->CI->settings_m->update($slug, array('value'=>$value));
    }
    
    function formControl(&$setting) {
    	switch($setting->type) {
    		default:
    		case 'text':
        		$form_control = form_input(array(
        			'id'	=>	$setting->slug,
        			'name'	=>	$setting->slug,
        			'value'	=>	$setting->value,
        			'class' => 'text width-20'
        		));
        	break;
        	
        	case 'textarea':
        		$form_control = form_textarea(array(
        			'id'	=>	$setting->slug,
        			'name'	=>	$setting->slug,
        			'value'	=>	$setting->value,
        			'class'	=>	'width-20'
        		));
        	break;
        	
    		case 'password':
        		$form_control = form_password(array(
        			'id'	=>	$setting->slug,
        			'name'	=>	$setting->slug,
        			'value'	=>	$setting->value,
        			'class' => 'text width-20'
        		));
        	break;
        	
        	case 'select':
        		
        		$form_control = form_dropdown(
        			$setting->slug,
        			$this->_formatOptions($setting->options),
        			$setting->value,
        			'class="width-20"'
        		);
        	break;
        	
        	case 'checkbox':
        	case 'radio':
        		
        		$func = $setting->type == 'checkbox' ? 'form_checkbox' : 'form_radio';
        		
        		$form_control = '';
        		
        		foreach($this->_formatOptions($setting->options) as $value => $label):

        			$form_control .= ' '.form_radio(array(
	        			'id'		=>	$setting->slug,
	        			'name'		=>	$setting->slug,
	        			'checked'	=>	$setting->value == $value,
	        			'value'		=>	$value
        			)) . ' '.$label;
        					  
        		endforeach;
        	break;
        }
        
        return $form_control;
    }
    
    function _formatOptions($options = array()) {
    	$select_array = array();
    	
    	foreach(explode('|', $options) as $option):
        	list($value, $name)=explode('=', $option);
        	$select_array[$value] = $name;
        endforeach;
        
        return $select_array;
    }

}

?>