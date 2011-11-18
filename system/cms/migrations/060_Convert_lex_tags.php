<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Convert_lex_tags extends CI_Migration {

	public function up()
	{	
		$page_chunks = $this->db->get('page_chunks')->result();
		
		foreach ($page_chunks as $chunk)
		{
			$new_body = preg_replace(array(
				'/{(\/)?(pyro:)?([^}]+)}/',
				'/{{\scontact:form.*?}}/'
			), array(
				'{{ $1$3 }}',
				'<p>To contact us please fill out the form below.</p>
				{{ contact:form name="text|required" email="text|required|valid_email" subject="dropdown|Support|Sales|Feedback|Other" message="textarea" attachment="file|zip" }}
					<div><label for="name">Name:</label>{{ name }}</div>
					<div><label for="email">Email:</label>{{ email }}</div>
					<div><label for="subject">Subject:</label>{{ subject }}</div>
					<div><label for="message">Message:</label>{{ message }}</div>
					<div><label for="attachment">Attach  a zip file:</label>{{ attachment }}</div>
				{{ /contact:form }}'
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