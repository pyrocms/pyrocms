<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends Public_Controller {

    function __construct() {
        parent::Public_Controller();
    }

    function create($module = 'home', $id = 0) {
 		$this->load->plugin('captcha');
        $this->load->library('validation');
        $this->load->model('comments_m');
        
        $rules['name'] = 'trim';
        $rules['email'] = 'trim|valid_email';
        $rules['body'] = 'trim|required';
		
        if(!$this->user_lib->logged_in()) {
        	$rules['name'] .= '|required';
        	$rules['email'] .= '|required';
        }
        
        if($this->settings->item('captcha_enabled') && !$this->user_lib->logged_in()) {
        	$rules['captcha'] = 'trim|required|callback__CheckCaptcha';
		}
        
		$this->validation->set_rules($rules);
        $this->validation->set_fields();
        
        // Validation Successful ------------------------------
        if ($this->validation->run()) {
            
        	// Logged in? in which case, we already know their name and email
        	if($this->user_lib->logged_in()) {
        		$commenter['user_id'] = $this->data->user->id;
        	} else {
        		$commenter['name'] = $this->input->post('name');
        		$commenter['email'] = $this->input->post('email');
        	}
        	
        	$this->comments_m->newComment($commenter + array(
            	'body'		=> $this->input->post('body'),	
        		'module' 	=> $module,
            	'module_id' => $id
            ));
            
            $this->session->set_flashdata(array('success'=>'Your comment has been saved.'));
        
        // Validation Failed ------------------------------------
        } else {
        	
        	if(!$this->user_lib->logged_in()) {
        		$comment['name'] = $this->input->post('name');
        		$comment['email'] = $this->input->post('email');
        	}
        	
        	$comment['body'] = $this->input->post('body');
        	$this->session->set_flashdata(array('comment'=>$comment));
        	
            $this->session->set_flashdata(array('error'=>$this->validation->error_string));
        }
        
        // If for some reason the post variable doesnt exist, just send to module main page
        $redirect_to = $this->input->post('redirect_to') ? $this->input->post('redirect_to') : $module;
        redirect($redirect_to);
    }
    
    // Callback: from create()
    function _CheckCaptcha($title = '') {
    	$captcha_id = $this->input->post('captcha_id');
        $captcha_word = $this->session->flashdata('captcha_'.$captcha_id);
        	
        if ($captcha_word != $this->input->post('captcha')) {
            $this->validation->set_message('_CheckCaptcha', 'You filled in the Captcha phrase wrong.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

?>