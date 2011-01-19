<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Email Templates Admin Controller
 * 
 * @author      Stephen Cozart - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage  Templates Module
 * @category	Module
 */
class Admin extends Admin_Controller {
    
    private $_validation_rules = array();
    
    /**
     * Constructor method
     *
     * @access public
     * @return void
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('email_templates_m');
        $this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
        
        $base_rules = 'required|trim|xss_clean';
        
        $this->_validation_rules = array(
                                    array(
                                        'field' => 'name',
                                        'label' => 'Name',
                                        'rules' => $base_rules
                                    ),
                                    array(
                                        'field' => 'slug',
                                        'label' => 'Slug',
                                        'rules' => $base_rules . '|alpha_dash'
                                    ),
                                    array(
                                        'field' => 'description',
                                        'label' => 'Description',
                                        'rules' => $base_rules
                                    ),
                                    array(
                                        'field' => 'subject',
                                        'label' => 'Subject',
                                        'rules' => $base_rules
                                    ),
                                    array(
                                        'field' => 'body',
                                        'label' => 'Body',
                                        'rules' => $base_rules
                                    ),
                                    array(
                                        'field' => 'lang',
                                        'label' => 'Language',
                                        'rules' => 'trim|xss_clean|max_length[2]'
                                    )
        );
    }
    
    /**
     * index method
     *
     * @access public
     * @return void
     */
    public function index()
    {
        $templates = $this->email_templates_m->get_all();
        
        $this->template->title($this->module_details['name'])
                        ->set('templates', $templates)
                        ->build('admin/index');
    }
    
    public function create()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->_validation_rules);
        
        // Go through all the known fields and get the post values
        foreach($this->_validation_rules as $key => $field)
        {
            $email_template->$field['field'] = set_value($field['field']);
        }
        
        if($this->form_validation->run())
        {
            foreach($_POST as $key => $value)
            {
                $data[$key] = $this->input->post($key);
            }
            unset($data['btnAction']);
            if($this->email_templates_m->insert($data))
            {
                $this->session->set_flashdata('success', 'Email template "' . $data['name'] . '" has been saved.');
            }
            else
            {
                $this->session->set_flashdata('error', 'Email template "' . $data['name'] . '" was not saved.');
            }
            redirect('admin/templates');
        }
        
        $this->template->set('email_template', $email_template)
                        ->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
                        ->build('admin/form');
    }
    
    public function edit($id = FALSE)
    {
        $email_template = $this->email_templates_m->get($id);
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->_validation_rules);
                
        // Go through all the known fields and get the post values
		foreach(array_keys($this->_validation_rules) as $field)
		{
			if (isset($_POST[$field])) $email_template->$field = $this->form_validation->$field;
		}
        
        if($this->form_validation->run())
        {
            foreach($_POST as $key => $value)
            {
                $data[$key] = $this->input->post($key);
            }
            unset($data['btnAction']);
            if($this->email_templates_m->update($id, $data))
            {
                $this->session->set_flashdata('success', 'Changes made to email template "' . $email_template->name . '" have been saved.');
            }
            else
            {
                $this->session->set_flashdata('error', 'Changes made to email template "' . $email_template->name . '" were not saved.');
            }
            redirect('admin/templates');
        }
        
        $this->template->set('email_template', $email_template)
                        ->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
                        ->build('admin/form');
    }
    
    public function action()
    {
        !$this->input->post('action_to') or redirect('admin/templates');
    }
    
    public function preview($id = FALSE)
    {
        
    }
    
}
/* End of file controllers/admin.php */