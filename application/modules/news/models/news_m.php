<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class News_m extends Model {

    function __construct() {
        parent::Model();
    }
    
    function checkTitle($title = '')
    {
        $this->db->select('COUNT(title) AS total');
        $query = $this->db->getwhere('news', array('slug'=>url_title($title)));
        $row = $query->row();
        if ($row->total == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function getArticle($id = 0, $status = 'live')
    {
    	$this->db->select('news.*, categories.title AS category_title, categories.slug AS category_slug');
       	$this->db->join('categories', 'news.category_id = categories.id', 'left');
    	
    	if(is_numeric($id))  $this->db->where('news.id', $id);
    	else  				 $this->db->where('news.slug', $id);
    	
    	if($status != 'all')
    	{
    		$this->db->where('status', $status);
    	}
    	
    	$query = $this->db->get('news');
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->row();
        }
    }
    
    function getNews($params = array())
    {
    	$this->load->helper('date');
        
    	$this->db->select('news.*, categories.title AS category_title, categories.slug AS category_slug');
       	$this->db->join('categories', 'news.category_id = categories.id', 'left');
    	
    	if(!empty($params['category'])):
	    	if(is_numeric($params['category']))  $this->db->where('categories.id', $params['category']);
	    	else  				 				 $this->db->where('categories.slug', $params['category']);
    	endif;
    	
    	if(!empty($params['month'])):
    		$this->db->where('MONTH(FROM_UNIXTIME(created_on))', $params['month']);
    	endif;
    	
    	if(!empty($params['year'])):
    		$this->db->where('YEAR(FROM_UNIXTIME(created_on))', $params['year']);
    	endif;
    	
    	// Is a status set?
    	if( !empty($params['status']) )
    	{
    		// If it's all, then show whatever the status
    		if($params['status'] != 'all')
    		{
	    		// Otherwise, show only the specific status
    			$this->db->where('status', $params['status']);
    		}
    	}
    	
    	// Nothing mentioned, show live only (general frontend stuff)
    	else
    	{
    		$this->db->where('status', 'live');
    	}
    	
    	// By default, dont show future articles
    	if(!isset($params['show_future']) || (isset($params['show_future']) && $params['show_future'] == FALSE)):
       		$this->db->where('created_on <=', now());
       	endif;
       	
       	// Limit the results based on 1 number or 2 (2nd is offset)
       	if(isset($params['limit']) && is_array($params['limit'])) $this->db->limit($params['limit'][0], $params['limit'][1]);
       	elseif(isset($params['limit'])) $this->db->limit($params['limit']);
    	
    	$this->db->order_by('created_on', 'DESC');
        $query = $this->db->get('news');
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

	function countArticles($params = array())
    {
    	$this->db->join('categories', 'news.category_id = categories.id', 'left');
    	
    	if(!empty($params['category'])):
	    	if(is_numeric($params['category']))  $this->db->where('categories.id', $params['category']);
	    	else  				 				 $this->db->where('categories.slug', $params['category']);
    	endif;
    	
    	if(!empty($params['month'])):
    		$this->db->where('MONTH(FROM_UNIXTIME(created_on))', $params['month']);
    	endif;
    	
    	if(!empty($params['year'])):
    		$this->db->where('YEAR(FROM_UNIXTIME(created_on))', $params['year']);
    	endif;
    	
    	// Is a status set?
    	if( !empty($params['status']) )
    	{
    		// If it's all, then show whatever the status
    		if($params['status'] != 'all')
    		{
	    		// Otherwise, show only the specific status
    			$this->db->where('status', $params['status']);
    		}
    	}
    	
    	// Nothing mentioned, show live only (general frontend stuff)
    	else
    	{
    		$this->db->where('status', 'live');
    	}
       	
		return $this->db->count_all_results('news');
    }

    function newArticle($input = array())
    {
    	$this->load->helper('date');

    	if(isset($input['created_on_day']) && isset($input['created_on_month']) && isset($input['created_on_year']) )
    	{
    		$created_on = mktime(@$input['created_on_hour'], @$input['created_on_minute'], 0, $input['created_on_month'], $input['created_on_day'], $input['created_on_year']);
    	}
    	
    	// Otherwise, use now
    	else
    	{
    		$created_on = now();
    	}

    	$this->db->insert('news', array(
            'title'			=> $input['title'],
            'slug'			=> url_title($input['title']),
            'category_id'	=> $input['category_id'],
            'intro'			=> $input['intro'],
            'body'			=> $input['body'],
            'status'		=> $input['status'],
            'created_on'	=> $created_on,
    		'updated_on'	=> 0
    	));

    	return $this->db->insert_id();
    }
    
    function updateArticle($input, $id = 0)
    {
    	if(is_numeric($id))  $this->db->where('id', $id);
    	else  				 $this->db->where('slug', $id);
    	
    	$this->load->helper('date');
            
    	$set = array(
            'title'			=> $input['title'],
            'slug'			=> url_title($input['title']),
            'category_id'	=> $input['category_id'],
            'intro'			=> $input['intro'],
            'body'			=> $input['body'],
            'status'		=> $input['status'],
    		'updated_on'	=> now()
    	);

    	if($input['created_on_day']){
    		$set['created_on'] = mktime($input['created_on_hour'], $input['created_on_minute'], 0, $input['created_on_month'], $input['created_on_day'], $input['created_on_year']);
    	}

    	return $this->db->update('news', $set);
    }
    
    function publishArticle($id = 0)
    {
    	$this->db->where('id', $id);
    	return $this->db->update('news', array('status' => 'live'));
    }

	function deleteArticle($id = 0)
	{
    	if(is_numeric($id))  $this->db->where('id', $id);
    	else  				 $this->db->where('slug', $id);
    	
        $this->db->delete('news');
		return $this->db->affected_rows();
    }

    // -- Archive ---------------------------------------------
    
    function getArchiveMonths()
    {
    	$this->load->helper('date');
    	
    	$this->db->select('UNIX_TIMESTAMP(DATE_FORMAT(FROM_UNIXTIME(t1.created_on), "%Y-%m-02")) AS `date`', FALSE);
    	$this->db->distinct();
		$this->db->select('(SELECT count(id) FROM news t2 
							WHERE MONTH(FROM_UNIXTIME(t1.created_on)) = MONTH(FROM_UNIXTIME(t2.created_on)) 
								AND YEAR(FROM_UNIXTIME(t1.created_on)) = YEAR(FROM_UNIXTIME(t2.created_on)) 
								AND status = "live"
								AND created_on <= '.now().'
						   ) as article_count');
		
		$this->db->where('status', 'live');
    	$this->db->where('created_on <=', now());
		$this->db->having('article_count >', 0);
		$this->db->order_by('t1.created_on DESC');
		$query = $this->db->get('news t1');

		if ($query->num_rows() == 0)
    	{
            return FALSE;
        }
        
        else
        {
            return $query->result();
        }
    	
    }

    // DIRTY frontend functions. Move to views
    
    function getNewsHome($params = array())
    {
    	$this->load->helper('date');
    	
    	$this->db->where('status', 'live');
    	$this->db->where('created_on <=', now());
       	
       	$string = '';
        $this->db->order_by('created_on', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get('news');
        if ($query->num_rows() > 0) {
        		$this->load->helper('text');
            foreach ($query->result() as $blogs) {
                $string .= '<p>' . anchor('news/' . date('Y/m') . '/'. $blogs->slug, $blogs->title) . '<br />' . strip_tags($blogs->intro). '</p>';
            }
        }
        return $string ;
    }
}

?>
