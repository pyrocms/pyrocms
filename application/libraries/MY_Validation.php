<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

class MY_Validation extends CI_Validation {


    function MY_Validation() {
        parent::CI_Validation();
    }

    function set_fields($data = '', $field = '', $separator = '_') {    
        if ($data == '') {
            if (count($this->_fields) == 0 && count($this->_rules) == 0) {
                return FALSE;
            }
        } else {
            if ( ! is_array($data)) {
                $data = array($data => $field);
            }
            
            if (count($data) > 0) {
                $this->_fields = $data;
            }
        }
        
        $auto_fields = array();
        foreach($this->_rules as $key => $val) {                  
            $text = ucwords(str_replace($separator, ' ', $key));             
            $auto_fields[$key] = $text;     
        }
        
        $this->_fields = !empty($auto_fields) ? array_merge($auto_fields, $this->_fields) : $this->_fields;
        
        foreach($this->_fields as $key => $val) {        
            $this->$key = ( ! isset($_POST[$key]) OR is_array($_POST[$key])) ? '' : $this->prep_for_form($_POST[$key]);
            
            $error = $key.'_error';
            if ( ! isset($this->$error)) {
                $this->$error = '';
            }
        }        
    }
} 