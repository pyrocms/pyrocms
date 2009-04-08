<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {

	// Validation rules to be used for create and edit
	private $rules = array(
		'title' 			=> 'trim|required',
        'category_id' 		=> 'trim|numeric',
        'intro' 			=> 'trim|required',
        'body' 				=> 'trim|required',
        'status' 			=> 'trim|alpha',
            
        'created_on_day' 	=> 'trim|numeric|required',
        'created_on_month' 	=> 'trim|numeric|required',
        'created_on_year' 	=> 'trim|numeric|required',
        
        'created_on_hour' 	=> 'trim|numeric|required',
        'created_on_minute' => 'trim|numeric|required'
    );
	
    function __construct() {
        parent::Admin_Controller();
        $this->load->model('news_m');
        $this->load->module_model('categories', 'categories_m');
        $this->load->helper('date');
        
        // Date ranges for select boxes
        $this->data->days = array_combine($days = range(1, 31), $days);
        $this->data->months = array_combine($months = range(1, 12), $months);
        $this->data->years = array_combine($years = range(date('Y')-2, date('Y')+2), $years);
        
        $this->data->hours = array_combine($hours = range(1, 23), $hours);
        $this->data->minutes = array_combine($minutes = range(1, 59), $minutes);
        
        $this->data->categories = array();
        if($categories = $this->categories_m->getCategories()):
	        foreach($categories as $category):
	        	$this->data->categories[$category->id] = $category->title;
	        endforeach;
	    endif;
    }

    // Admin: List Blogs
    function index() {
    	
    	// Create pagination links
    	$total_rows = $this->news_m->countArticles(array('show_future'=>TRUE, 'status' => 'all'));
    	$this->data->pagination = create_pagination('admin/news/index', $total_rows);

    	// Using this data, get the relevant results
    	$this->data->news = $this->news_m->getNews(array(
    		'show_future'=>TRUE,
    		'status' => 'all',
    		'order'	=> 'created_on DESC, status',
    		'limit' => $this->data->pagination['limit']
    	));

    	$this->layout->create('admin/index', $this->data);
    }
    
    // Admin: Create a new article
    function create() {
        $this->load->library('validation');
        $this->rules['title'] .= '|callback__createTitleCheck';
        $this->validation->set_rules($this->rules);
        $this->validation->set_fields();
        
        $config = array('name'=>'body', 'content'=>$this->validation->body);
        $this->load->library('spaw', $config);
		
        // setting directories for a SPAW editor instance:
		$this->spaw->setConfigItem(
			'PG_SPAWFM_DIRECTORIES',
			  array(
			    array(
			      'dir'     => '/uploads/news/flash/',
			      'caption' => 'Flash movies', 
			      'params'  => array(
			        'allowed_filetypes' => array('flash')
			      )
			    ),
			    array(
			      'dir'     => '/uploads/news/images/',
			      'caption' => 'Images',
			      'params'  => array(
			        'default_dir' => true, // set directory as default (optional setting)
			        'allowed_filetypes' => array('images')
			      )
			    ),
			  ),
			  SPAW_CFG_TRANSFER_SECURE
		);
	
    	// Go through all the known fields and get the post values
    	foreach(array_keys($this->rules) as $field)
    	{
    		$article->$field = (isset($_POST[$field])) ? $this->validation->$field : '';
    	}
        
        if ($this->validation->run()) {

        	if ($this->news_m->newArticle($_POST))
        	{
                $this->session->set_flashdata('success', 'The article "'.$this->input->post('title').'" was added.');
                
                // The twitter module is here, and enabled!
	    		$this->load->module_config('twitter', 'twitter');
                if($this->settings->item('twitter_news') == 1 && $this->input->post('status') == 'live')
                {
                	$url = shorten_url('news/'.$this->input->post('created_on_year').'/'.$this->input->post('created_on_month').'/'.url_title($this->input->post('title')));
					$this->twitter_m->update(sprintf('Posted "%s" %s', $this->input->post('title'), $url));
                }
                // End twitter code
            }
            
            else
            {
                $this->session->set_flashdata('error', 'An error occured.');
            }
            
            redirect('admin/news/index');
            
        }
        
    	$this->data->article =& $article;
        $this->layout->create('admin/form', $this->data);
    }
    
    // Admin: Edit an article
    function edit($id = 0){

    	if (!$id) redirect('admin/news/index');
    		
    	$this->load->library('validation');
    	$this->validation->set_rules($this->rules);
    	$this->validation->set_fields();

    	$article = $this->news_m->getArticle($id, 'all');

    	$spaw_cfg = array('name'=>'body', 'content'=>$article->body);
    	$this->load->library('spaw', $spaw_cfg);
    	// setting directories for a SPAW editor instance:
    	$this->spaw->setConfigItem(
			'PG_SPAWFM_DIRECTORIES',
    			array(
    				array(
				    	'dir'     => '/uploads/news/flash/',
				    	'caption' => 'Flash movies', 
				    	'params'  => array(
				     	'allowed_filetypes' => array('flash')
    					)
			    	),
			    	array(
					      'dir'     => '/uploads/news/images/',
					      'caption' => 'Images',
					      'params'  => array(
					        'default_dir' => true, // set directory as default (optional setting)
					        'allowed_filetypes' => array('images')
			    	)
    			),
    		),
    		SPAW_CFG_TRANSFER_SECURE
    	);

    	if ($this->validation->run())
    	{
    		if ($this->news_m->updateArticle($_POST, $id))
    		{
    			$this->session->set_flashdata(array('success'=>'The article "'.$this->input->post('title').'" was updated.'));

    			// The twitter module is here, and enabled!
    			$this->load->module_config('twitter', 'twitter');
    			if($this->settings->item('twitter_news') == 1 && ($article->status != 'live' && $this->input->post('status') == 'live'))
    			{
    				$url = shorten_url('news/'.$this->input->post('created_on_year').'/'.str_pad($this->input->post('created_on_month'), 2, '0', STR_PAD_LEFT).'/'.url_title($this->input->post('title')));
    				
					$this->load->module_model('twitter', 'twitter_m');
					$this->twitter_m->update(sprintf('Posted "%s" %s', $this->input->post('title'), $url));
    			}
    			// End twitter code
    		}

    		else
    		{
    			$this->session->set_flashdata(array('error'=>'An error occurred.'));
    		}

    		redirect('admin/news/index');

    	}
	
    	// Go through all the known fields and get the post values
    	foreach(array_keys($this->rules) as $field)
    	{
    		if(isset($_POST[$field]))
    		$article->$field = $this->validation->$field;
    	}
    	
    	$this->data->article =& $article;
    	$this->layout->create('admin/form', $this->data);
    }
    
    // Admin: Delete an article
    function delete($id = 0) {
		
        // Delete one
		if($id):
			$this->news_m->deleteArticle($id);
		
		// Delete multiple
		else:
			foreach (array_keys($this->input->post('delete')) as $id):
				$this->news_m->deleteArticle($id);
			endforeach;
		endif;
		
	    $this->session->set_flashdata('success', 'The article was deleted.');
        redirect('admin/news/index');
    }

    
    // Callback: from create()
    function _createTitleCheck($title = '') {
        if ($this->news_m->checkTitle($title)) {
            $this->validation->set_message('_createTitleCheck', 'A blog with this name already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    // Private: Create resize of Cropped Image to ensure it's a certain size
    function _create_resize($homeimg = '', $x, $y) {
        unset($img_cfg);
        $img_cfg['source_image'] = './assets/img/suppliers/' . $homeimg;
        $img_cfg['new_image'] = './assets/img/suppliers/' . $homeimg;
        $img_cfg['maintain_ratio'] = true;
        $img_cfg['width'] = $x;
        $img_cfg['height'] = $y;
        $this->load->library('image_lib');
        $this->image_lib->initialize($img_cfg);
        $this->image_lib->resize();
    }

}

?>