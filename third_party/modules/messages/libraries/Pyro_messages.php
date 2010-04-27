<?php

/**
 * PyroCMS Messages Library
 *
 * @author Dan Horrigan
 */
class Pyro_messages
{
	private $CI;

	public function  __construct()
	{
		$this->CI =& get_instance();
	}
	public function notify($email, $message)
	{
		$this->CI->load->library('email');
		$this->CI->load->helper('url');
		
		$text_body = 'View the message here: ' . anchor('messages/view/' . $message->id) . '<br /><br />';
		$text_body .= '<strong>From: </strong>' . $message->from . '<br />';
		$text_body .= '<strong>Message:</strong><br />';
		$text_body .= parse_bbcode($message->content);

		$this->CI->email->clear();
		$this->CI->email->from($this->CI->settings->item('server_email'), $this->CI->config->item('forums_title'));
		$this->CI->email->to($email);

		$this->CI->email->subject('New Message: ' . $message->subject);

		$this->CI->email->message($text_body);
		$this->CI->email->send();
	}

}
?>
