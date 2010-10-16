<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package     PyroCMS
 * @subpackage  tags
 * @tag         Module
 * @author      Alexandru Bucur (CoolGoose)
 */
class Admin_Tags extends Admin_Controller
{
     /**
     * Array that contains the validation rules
     * @access protected
     * @var array
     */
    protected $validation_rules;
    
        /** 
     * The constructor
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::Admin_Controller();
        $this->load->model('news_tags_m');
        
        // load the language files
        $this->lang->load('categories');
        $this->lang->load('news');
        $this->lang->load('tags');
        
        $this->template->set_partial('shortcuts', 'admin/partials/shortcuts');
    
        // Set the validation rules
        $this->validation_rules = array(
            array(
                'field' => 'tag',
                'label' => lang('tags.tag_label'),
                'rules' => 'trim|required|max_length[100]'
            ),
        );
        
        // Load the validation library along with the rules
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->validation_rules);
    }

     /**
     * Index method, lists all tags
     * @access public
     * @return void
     */
    public function index()
    {
        $this->cache->delete_all('modules_m');
        // Create pagination links
        $total_rows             = $this->news_tags_m->count_all();
        $this->data->pagination = create_pagination('admin/news/tags/index', $total_rows);
            
        // Using this data, get the relevant results
        $this->data->tags = $this->news_tags_m->limit( $this->data->pagination['limit'] )->get_all();
        $this->template->build('admin/tags/index', $this->data);
    }
    
    public function create()
    {
        // Validate the data
        if ($this->form_validation->run())
        {
            $tag['tag'] = $this->input->post('tag');
            
            if (strpos($this->input->post('tag'), ',') !== FALSE) 
            {
                $tags = array();
                
                $tags_raw = explode(',', $this->input->post('tag'));               

                foreach ($tags_raw as $tag) {
                    $tags[]['tag'] = $tag;
                }    
            }
            
            $return = FALSE;
            
            if (!empty($tags)) 
            {
                $return = $this->news_tags_m->insert_many($tags);
            }
            else {
                $return = $this->news_tags_m->insert($tag);
            }
            
            $return ? $this->session->set_flashdata('success', sprintf( lang('tag_add_success'), $this->input->post('tag')) )
                    : $this->session->set_flashdata(array('error'=> lang('tag_add_error')));

            redirect('admin/news/tags');
        }
        
        // Loop through each validation rule
        foreach($this->validation_rules as $rule)
        {
            $tag->{$rule['field']} = set_value($rule['field']);
        }
        
        // Render the view  
        $this->data->tag =& $tag; 
        $this->template->build('admin/tags/form', $this->data);   
    }

     /**
     * Delete method, deletes an existing tag
     * @access public
     * @param int id The ID of the tag to edit 
     * @return void
     */
    public function delete($id = 0)
    {   
        $id_array = (!empty($id)) ? array($id) : $this->input->post('action_to');
        
        // Delete multiple
        if(!empty($id_array))
        {            
            $deleted = 0;
            $to_delete = 0;
            foreach ($id_array as $id) 
            {
                if ($this->news_tags_m->has_posts($id)) 
                {
                    $this->news_tags_m->delete_related($id);
                }
                
                if($this->news_tags_m->delete($id))
                {
                    $deleted++;
                }
                else
                {
                    $this->session->set_flashdata('error', sprintf($this->lang->line('tag_mass_delete_error'), $id));
                }
                $to_delete++;
            }
            
            if( $deleted > 0 )
            {
                $this->session->set_flashdata('success', sprintf($this->lang->line('tag_mass_delete_success'), $deleted, $to_delete));
            }
        }       
        else
        {
            $this->session->set_flashdata('error', $this->lang->line('tag_no_select_error'));
        }
        
        redirect('admin/news/tags/index');
    }
}
