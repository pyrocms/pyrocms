<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Pages helper
 *
 * @author Phil Sturgeon - PyroCMS Dev Team
 * @package PyroCMS
 * @subpackage Pages Module
 * @category Modules
 * 
 */

/**
 * Get a page's URL
 * 
 * @param int $id The ID of the page
 * @return string
 */
#deprecated
function page_url($id)
{
	$CI =& get_instance();
	$uri = $CI->pages_m->get_path_by_id($id);
  
	return site_url($uri);
}

/**
 * Create an anchor to the page
 *
 * @param int $id The ID of the page
 * @param string $text The text to display in the anchor
 * @param array $options Optional options, how awesome sounds that?
 * @return string
 */
#deprecated
function page_anchor($id, $text = '', $options = array())
{
	$CI =& get_instance();
	$uri = $CI->pages_m->get_path_by_id($id);
  
	return anchor($uri, $text, $options);
}

// #TODO: Document the functions below
/**
 * Create a navigation tree
 * 
 * @param array $tree ?
 * @param int $ParentID The ID of the parent item
 * @param int $lvl The amount of items to include in the tree
 * @param string $c_parent ?
 * @param string $c_id ?
 */
function create_tree_select($tree, $ParentID, $lvl, $c_parent = "", $c_id = "")
{
    if (!isset($tree[$ParentID])) return;

    foreach($tree[$ParentID] as $item) {
    	if($c_id != "" && $c_id == $item->id) continue;
    	
        if($lvl > 0) 
        {
        	echo '<option value="'.$item->id.'"';
        	if ($c_parent == $item->id) echo ' selected="selected" ';
        	echo '>';
        	for($i=0; $i<($lvl*2); $i++) echo "&nbsp;";
        	echo "-&nbsp;";
        	echo $item->title.'</option>';
        } else {
        	echo '<option value="'.$item->id.'"';
        	if ($c_parent == $item->id) echo ' selected="selected" ';
        	echo '>'.$item->title.'</option>';
        }
        create_tree_select($tree, $item->id, $lvl+1, $c_parent, $c_id);
    }
}

/**
 * Creates an array where sub elements are stored in array[id]->sub
 * 
 * @param array $tree
 * @param int $ParentID The ID of the parent
 * @param int $lvl The amount of items to include in the tree
 */
function create_tree_array($tree, $ParentID = 0, $lvl = 0)
{
	$return = array();
	if (!isset($tree[$ParentID])) return $return;
	foreach($tree[$ParentID] as $key => $item) {
		$return[$key] = $item;
		$return[$key]->level = $lvl;
		$return[$key]->children = create_tree_array($tree, $item->id, $lvl+1);
	}
	return $return;
}