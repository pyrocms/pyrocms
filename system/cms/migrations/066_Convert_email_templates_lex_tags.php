<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Convert_email_templates_lex_tags extends CI_Migration {

	public function up()
	{	
		$page_chunks = $this->db->get('email_templates')->result();
		
		foreach ($page_chunks as $template)
		{
			$new_subject = preg_replace('/{(\/)?(pyro:)?([^}]+)}/', '{{ $1$3 }}', $template->subject);
			$new_body = preg_replace('/{(\/)?(pyro:)?([^}]+)}/', '{{ $1$3 }}', $template->body);
			
			$this->db
				->set('subject', $new_subject)
				->set('body', $new_body)
				->where('id', $template->id)
				->update('email_templates');
		}
		
	}

	public function down()
	{
		$page_chunks = $this->db->get('email_templates')->result();
		
		foreach ($page_chunks as $chunk)
		{
			$new_subject = preg_replace('/{{/s?([^}]+)/s?}}/', '{pyro:$1}', $template->subject);
			$new_body = preg_replace('/{{/s?([^}]+)/s?}}/', '{pyro:$1}', $template->body);
			
			$this->db
				->set('subject', $new_subject)
				->set('body', $new_body)
				->where('id', $template->id)
				->update('email_templates');
		}
		
	}

}