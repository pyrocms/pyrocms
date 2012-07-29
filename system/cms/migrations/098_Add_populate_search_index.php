<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration to add search pages and their chunks.
 */
class Migration_Add_populate_search_index extends CI_Migration
{
	public function up()
	{
		$this->load->model('search/search_index_m');
		$this->load->library('keywords/keywords');

		foreach ($this->db->get('pages')->result() as $page)
		{
			// Only index live articles
	    	if ($page->status === 'live')
	    	{
	    		$hash = Keywords::process($page->meta_keywords);

	    		$this->db
	    			->set('meta_keywords', $hash)
	    			->where('id', $page->id)
	    			->update('pages');

	    		$this->search_index_m->index(
	    			'pages',
	    			'pages:page', 
	    			'pages:pages', 
	    			$page->id,
	    			$page->uri,
	    			$page->title,
	    			$page->meta_description ? $page->meta_description : null, 
	    			array(
	    				'cp_edit_uri' 	=> 'admin/pages/edit/'.$page->id,
	    				'cp_delete_uri' => 'admin/pages/delete/'.$page->id,
	    				'keywords' 		=> $hash,
	    			)
	    		);
	    	}
		}

		foreach ($this->db->get('blog')->result() as $post)
		{
			// Only index live articles
	    	if ($post->status === 'live')
	    	{
	    		$this->search_index_m->index(
	    			'blog', 
	    			'blog:post', 
	    			'blog:posts', 
	    			$post->id,
	    			'blog/'.date('Y/m/', $post->created_on).$post->slug,
	    			$post->title,
	    			$post->intro, 
	    			array(
	    				'cp_edit_uri' 	=> 'admin/blog/edit/'.$post->id,
	    				'cp_delete_uri' => 'admin/blog/delete/'.$post->id,
	    				'keywords' 		=> $post->keywords,
	    			)
	    		);
	    	}
		}

		// Now that pages have hashes instead of keywords set the keywords
		$this->dbforge->modify_column('pages', array(
			'meta_keywords' => array('type' => 'CHAR', 'constraint' => 32, 'null' => true),
		));
	}

	public function down()
	{
		
	}
}