<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Categories model
 *
 * @package     PyroCMS
 * @subpackage  Categories Module
 * @category    Modules
 * @author      Alexandru Bucur (CoolGoose)
 */
class News_tags_m extends MY_Model
{
    /**
    * Check to see if a tag has news associated
    *
    * @param string $id
    * @return bool
    * @author Alexandru Bucur (CoolGoose)
    */
    function has_posts($id) 
    {
        $results_no = $this->db->from('news_to_tag')
                           ->where('tag_id', $id)
                           ->count_all_results();
                           
        if ($results_no > 0) 
        {
            return TRUE;
        }
        return FALSE;
    }
    
    /**
    * Delete entries from post to tag association
    *
    * @param string $id
    * @return bool
    * @author Alexandru Bucur (CoolGoose)
    */
    function delete_related($id)
    {
        $this->db->where('tag_id', $tag_id)
                 ->delete('news_to_tag');
        
        return TRUE;
    }

    /**
    * Check to see if a tag exists
    *
    * @param string $tag
    * @return bool
    * @author Alexandru Bucur (CoolGoose)
    */
    function tag_exists($tag) 
    {
        $results_no = $this->db->from('news_tags')
                           ->where('tag', $tag)
                           ->count_all_results();
                           
        if ($results_no > 0) 
        {
            return TRUE;
        }
        return FALSE;
    }

    
}
    