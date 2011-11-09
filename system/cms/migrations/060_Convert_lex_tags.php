<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Convert_lex_tags extends CI_Migration {

	public function up()
	{	
		$page_chunks = $this->db->get('page_chunks')->result();
		
		foreach ($page_chunks as $chunk)
		{
			$new_body = preg_replace(array(
				'/{(\/)?(pyro:)?([^}]+)}/'
			), array(
				'{{ $1$3 }}'
			), $chunk->body);
			
			$this->db
				->set('body', $new_body)
				->where('id', $chunk->id)
				->update('page_chunks');
		}
		
		$page_layouts = $this->db->get('page_layouts')->result();
		
		foreach ($page_layouts as $layout)
		{
			$new_body = preg_replace(array(
				'/{(\/)?(pyro:)?([^}]+)}/'
			), array(
				'{{ $1$3 }}'
			), $layout->body);
			
			$this->db
				->set('body', $new_body)
				->where('id', $layout->id)
				->update('page_layouts');
		}
		
	}

	public function down()
	{
		$page_chunks = $this->db->get('page_chunks')->result();
		
		foreach ($page_chunks as $chunk)
		{
			$new_body = preg_replace('/{{/s?([^}]+)/s?}}/', '{pyro:$1}', $chunk->body);
			
			$this->db
				->set('body', $new_body)
				->where('id', $chunk->id)
				->update('page_chunks');
		}
		
	}

}