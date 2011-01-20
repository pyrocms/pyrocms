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
        
        foreach($this->config->item('supported_languages') as $key => $lang)
        {
            $lang_options[$key] = $lang['name'];
        }
        
        $this->template->set('lang_options', $lang_options)
                        ->set_partial('shortcuts', 'admin/partials/shortcuts');
        
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
        
        $this->_edit_default_rules = array(
                                        array(
                                        'field' => 'subject',
                                        'label' => 'Subject',
                                        'rules' => $base_rules
                                        ),
                                        array(
                                            'field' => 'body',
                                            'label' => 'Body',
                                            'rules' => $base_rules
                                        )
                                    );
        $this->_clone_rules = array(
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
    
    /**
     * Used to create an entirely new template from scratch.  Usually will be
     * used for future expansion or third party modules
     *
     * @access public
     * @return void
     */
    public function create()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->_validation_rules);
        
        $email_template->is_default = 0;
        
        // Go through all the known fields and get the post values
        foreach($this->_validation_rules as $key => $field)
        {
            $email_template->$field['field'] = $this->input->post($field['field']);
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
        
        if($email_template->is_default)
        {
            $rules = $this->_edit_default_rules;
        }
        else
        {
            $rules = $this->_validation_rules;
        }
                
        // Go through all the known fields and get the post values
		foreach(array_keys($rules) as $field)
		{
			if (isset($_POST[$field])) $email_template->$field = $this->form_validation->$field;
		}
        
        $this->form_validation->set_rules($rules);
        
        if($this->form_validation->run())
        {
            if($email_template->is_default)
            {
                $data = array(
                            'subject' => $this->input->post('subject'),
                            'body' => $this->input->post('body')
                        );
            }
            else
            {
                $data = array(
                            'slug'  =>  $this->input->post('slug'),
                            'name'  =>  $this->input->post('name'),
                            'description'   =>  $this->input->post('description'),
                            'subject'   =>  $this->input->post('subject'),
                            'body'  =>  $this->input->post('body'),
                            'lang'  =>  $this->input->post('lang')
                        );
            }
            
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
    
    /**
     * Delete duh,  but we won't allow deletion of default templates
     *
     * @access  public
     * @param   int $id
     * @return  void
     */
    public function delete($id = FALSE)
    {
        $id = (int) $id;
        redirect('admin/templates');
    }
    
    /**
     * Preview how your templates may be rendered
     *
     * @access  public
     * @param   int $id
     * @return  void
     */
    public function preview($id = FALSE)
    {
        $id = (int) $id;
        $dummy_data = array();
    }
    
    /**
     * Takes an existing template as a template.  Usefull for creating a template
     * for another language
     *
     * @access  public
     * @param   int $id
     * @return  void
     */
    public function create_copy($id = FALSE)
    {
        $id = (int) $id;
        
        //we will need this later after the form submission
        $copy = $this->email_templates_m->get($id);
        
        //unset the id and is_default from $copy we don't need or want them anymore
        unset($copy->id);
        unset($copy->is_default);
        
        //lets get all variations of this template so we can remove the lang options
        $existing = $this->email_templates_m->get_many_by('slug', $copy->slug);
        
        $lang_options = $this->template->lang_options;
        
        if(!empty($existing))
        {
            foreach($existing as $tpl)
            {
                unset($lang_options[$tpl->lang]);
            }
        }
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules($this->_clone_rules);
        
        if($this->form_validation->run())
        {
            //insert stuff to db
            $copy->lang = $this->input->post('lang');
            
            if($new_id = $this->email_templates_m->insert($copy))
            {
                $this->session->set_flashdata('success', $copy->name . ' has been cloned.  You may now edit the template to your liking.');
                redirect('admin/templates/edit/' . $new_id);
            }
            else
            {
                $this->session->set_flashdata('error', $copy->name . 'was unable to be cloned.  Please try again.');
            }
            
            redirect('admin/templates');
        }
        
        $this->template->set('lang_options', $lang_options)
                        ->set('template_name', $copy->name)
                        ->build('admin/copy');
    }
    
}
/* End of file controllers/admin.php */