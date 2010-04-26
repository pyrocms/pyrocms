<?php

/**
 * PyroCMS Forums Library
 *
 * @author Dan Horrigan
 */
class Pyro_forums
{
	private $CI;

	public function  __construct()
	{
		$this->CI =& get_instance();
	}
	public function notify_reply($recipients, $reply)
	{
		$this->CI->load->library('email');
		$this->CI->load->helper('url');
		
		$text_body = 'View the reply here: ' . site_url('forums/posts/view_reply/' . $reply->id) . '\n\n';
		$text_body .= 'Message:\n';
		$text_body .= parse_bbcode($reply->content, TRUE);

		foreach($recipients as $person)
		{
			$this->CI->email->clear();
			$this->CI->email->from('forums@example.com', 'Forums');
			$this->CI->email->to($person->email);

			$this->CI->email->subject('Subscription Notification: ' . $reply->title);
			$text_body = 'Reply to "' . $reply->title . '".\n\n' . $text_body;

			$this->CI->email->message($text_body);
			$this->CI->email->send();
		}
	}

	public function get_recipients($topic_id)
	{
		$recipients = array();
		$subscriptions = $this->CI->forum_subscriptions_m->get_many_by(array('topic_id' => $topic_id));
		foreach($subscriptions as& $sub)
		{
			$this->CI->db->or_where('users.id', $sub->user_id);
		}
		$this->CI->db->select('email');
		return $this->CI->db->get($this->CI->ion_auth_model->tables['users'])->result();

	}

}
?>
