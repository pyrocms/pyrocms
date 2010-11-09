<?php defined('BASEPATH') OR exit('No direct script access allowed');

class News_m extends MY_Model
{
    function get_all()
    {
    	$this->db->select('news.*, c.title AS category_title, c.slug AS category_slug');
       	$this->db->join('news_categories c', 'news.category_id = c.id', 'left');
    	
    	$this->db->order_by('created_on', 'DESC');
           
        return $this->db->get('news')->result();
    }
	
	function get_many_by($params = array())
    {
    	$this->load->helper('date');
        
    	if ( ! empty($params['category']))
    	{
	    	if (is_numeric($params['category']))  $this->db->where('c.id', $params['category']);
	    	else  				 				 $this->db->where('c.slug', $params['category']);
    	}
    	
    	if ( ! empty($params['month']))
    	{
    		$this->db->where('MONTH(FROM_UNIXTIME(created_on))', $params['month']);
    	}
    	
    	if ( ! empty($params['year']))
    	{
    		$this->db->where('YEAR(FROM_UNIXTIME(created_on))', $params['year']);
    	}
    	
    	// Is a status set?
    	if ( ! empty($params['status']) )
    	{
    		// If it's all, then show whatever the status
    		if ($params['status'] != 'all')
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
    	if ( ! isset($params['show_future']) || (isset($params['show_future']) && $params['show_future'] == FALSE))
    	{
       		$this->db->where('created_on <=', now());
    	}
       	
       	// Limit the results based on 1 number or 2 (2nd is offset)
       	if (isset($params['limit']) && is_array($params['limit'])) $this->db->limit($params['limit'][0], $params['limit'][1]);
       	elseif (isset($params['limit'])) $this->db->limit($params['limit']);
    	
    	return $this->get_all();
    }

	function count_by($params = array())
    {
    	$this->db->join('news_categories c', 'news.category_id = c.id', 'left');
    	
    	if ( ! empty($params['category']))
    	{
	    	if (is_numeric($params['category']))  $this->db->where('c.id', $params['category']);
	    	else  				 				 $this->db->where('c.slug', $params['category']);
    	}
    	
    	if ( ! empty($params['month']))
    	{
    		$this->db->where('MONTH(FROM_UNIXTIME(created_on))', $params['month']);
    	}
    	
    	if ( ! empty($params['year']))
    	{
    		$this->db->where('YEAR(FROM_UNIXTIME(created_on))', $params['year']);
    	}
    	
    	// Is a status set?
    	if ( ! empty($params['status']) )
    	{
    		// If it's all, then show whatever the status
    		if ($params['status'] != 'all')
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

    function insert($input = array())
    {
    	if (isset($input['created_on_day']) && isset($input['created_on_month']) && isset($input['created_on_year']) )
    	{
    		$input['created_on'] = gmmktime(@$input['created_on_hour'], @$input['created_on_minute'], 0, $input['created_on_month'], $input['created_on_day'], $input['created_on_year']);

			unset($input['created_on_hour'], $input['created_on_minute'], $input['created_on_month'], $input['created_on_day'], $input['created_on_year']);
    	}
    	
    	// Otherwise, use now
    	else
    	{
    		$this->load->helper('date');
    		$input['created_on'] = now();
    	}

    	return parent::insert($input);
    }
    
    function update($id, $input)
    {
    	$this->load->helper('date');
            
    	$input['updated_on'] = now();

    	if (isset($input['created_on_day']) && isset($input['created_on_month']) && isset($input['created_on_year']) )
    	{
    		$input['created_on'] = mktime($input['created_on_hour'], $input['created_on_minute'], 0, $input['created_on_month'], $input['created_on_day'], $input['created_on_year']);
    		
    		unset($input['created_on_hour'], $input['created_on_minute'], $input['created_on_month'], $input['created_on_day'], $input['created_on_year']);
    	}

    	return parent::update($id, $input);
    }
    
    function publish($id = 0)
    {
    	return parent::update($id, array('status' => 'live'));
    }


    // -- Archive ---------------------------------------------
    
    function get_archive_months()
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

		return $query->result();
    }

    // DIRTY frontend functions. Move to views
    function get_news_fragment($params = array())
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

    function check_slug($slug = '')
    {
		return parent::count_by('slug', $slug) == 0;
    }
    
    /**
     * Searches news articles based on supplied data array
     * @param $data array
     * @return array
     */
    public function search($data = array())
    {
	if (array_key_exists('category_id', $data))
	{
		$this->db->where('category_id', $data['category_id']);
	}

	if (array_key_exists('status', $data))
	{
		$this->db->where('status', $data['status']);
	}

	if (array_key_exists('keywords', $data))
	{
	    $matches = array();
	    if (strstr($data['keywords'], '%'))
	    {
		preg_match_all('/%.*?%/i', $data['keywords'], $matches);
	    }
	    
	    if ( ! empty($matches[0]))
	    {
		foreach($matches[0] as $match)
		{
		    $phrases[] = str_replace('%', '', $match);
		}
	    }
	    else
	    {
		$temp_phrases = explode(' ', $data['keywords']);
		foreach($temp_phrases as $phrase)
		{
		    $phrases[] = str_replace('%', '', $phrase);
		}
	    }
	    
	    $counter = 0;
	    foreach($phrases as $phrase)
	    {
		if ($counter == 0)
		{
		    $this->db->like('news.title', $phrase);
		}
		else
		{
		    $this->db->or_like('news.title', $phrase);
		}
		
		$this->db->or_like('news.body', $phrase);
		$this->db->or_like('news.intro', $phrase);
		$counter++;
	    }
	}
	return $this->get_all();
    }
}