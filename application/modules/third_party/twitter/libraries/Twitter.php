<?php

/**
* A CodeIgniter library to allow use of the Twitter API
*
* Example Usage:
*
*	$this->load->library('twitter');
*	$this->twitter->auth('someuser','somepass');
*	$this->twitter->update('My awesome tweet!');
*
* Methods return a mixture of boolean and stdObjects
*
* @author Simon Maddox <simon@simonmaddox.com>
* @modified Phil Sturgeon <email@philsturgeon.co.uk>
* @license Creative Commons Attribution-Share Alike 3.0 Unported
* http://creativecommons.org/licenses/by-sa/3.0/
**/

class Twitter {
	var $type = 'xml';
	var $user_agent = 'CodeIgniter-Twitter Library by Simon Maddox (http://simonmaddox.com)';
	var $api_location = 'api.twitter.com/1';
	
	var $username;
	var $password;
	var $auth;
	var $user;
	
	var $last_error;
	
	var $friends_timeline;
	var $replies;
	var $friends;
	var $followers;
	var $direct_messages;
	var $sent_direct_messages;
	var $favorites;
	
	function auth($username,$password){
		$this->username = $username;
		$this->password = $password;
		
		$user = $this->_fetch('account/verify_credentials.' . $this->type);
		
		if ($user == false){
			$this->auth = false;
			return false;
		} else {
			$this->user = $user;
			$this->auth = true;
			return true;
		}
	}
	
	function get_user(){
		if (!$this->auth){ return false; }
		return $this->user;
	}
	
	/*
		GET Methods
	*/
	
	function public_timeline(){
		return $this->_fetch('statuses/public_timeline.' . $this->type);
	}
	
	function friends_timeline($count = '', $since = '', $since_id = '', $page = ''){
		if (!$this->auth){ return false; }
		
		$params = $this->_build_params(array('count' => $count, 'since' => $since, 'since_id' => $since_id, 'page' => $page));
		
		if (empty($this->friends_timeline)){
			$this->friends_timeline = $this->_fetch('statuses/friends_timeline.' . $this->type . $params);
		}
		
		return $this->friends_timeline;
	}
	
	function user_timeline($id = '', $count = '', $since = '', $since_id = '', $page = ''){

		$params = $this->_build_params(array('count' => $count, 'since' => $since, 'since_id' => $since_id, 'page' => $page));

		$this->user_timeline = $this->_fetch('statuses/user_timeline/' . $id . '.' . $this->type . $params);
		
		if(!empty($this->user_timeline))
		{
			if($count > 1)
			{
				foreach($this->user_timeline as &$message)
				{
					$message->text = $this->_parse_message($message->text);
				}
			}
			
			else
			{
				$this->user_timeline->text = $this->_parse_message($this->user_timeline->text);
			}
		}
		
		return $this->user_timeline;
	}
	
	function show($id = 55){
		if (!$this->auth){ return false; }
		$message =& $this->_fetch('statuses/show/'.$id.'.xml');
	}
	
	function replies($since = '', $since_id = '', $page = ''){
		if (!$this->auth){ return false; }
		
		$params = $this->_build_params(array('since' => $since, 'since_id' => $since_id, 'page' => $page));
		
		if (empty($this->replies)){
			$this->replies = $this->_fetch('statuses/replies.' . $this->type . $params);
		}
		
		return $this->replies;
	}
	
	function friends($id = '', $page = ''){
		if (!$this->auth){ return false; }
		
		$params = $this->_build_params(array('id' => $id, 'page' => $page));
		
		if (empty($this->friends)){
			$this->friends = $this->_fetch('statuses/friends.' . $this->type . $params);
		}
		
		return $this->friends;
	}
	
	function followers($id = '', $page = ''){
		if (!$this->auth){ return false; }
		
		$params = $this->_build_params(array('id' => $id, 'page' => $page));
		
		if (empty($this->followers)){
			$this->followers = $this->_fetch('statuses/friends.' . $this->type . $params);
		}	
			
		return $this->followers;
	}
	
	function user_show($id = ''){
		if (!$this->auth){ return false; }
		return $this->_fetch('users/show/id.'.$this->type.'?id=' . $id);
	}
	
	function direct_messages($since = '', $since_id = '', $page = ''){
		if (!$this->auth){ return false; }
		
		$params = $this->_build_params(array('since' => $since, 'since_id' => $since_id, 'page' => $page));
		
		if (empty($this->direct_messages)){
			$this->direct_messages = $this->_fetch('direct_messages.' . $this->type . $params);
		}
		
		return $this->direct_messages;
	}
	
	function sent_direct_messages($since = '', $since_id = '', $page = ''){
		if (!$this->auth){ return false; }
		
		$params = $this->_build_params(array('since' => $since, 'since_id' => $since_id, 'page' => $page));
		
		if (empty($this->sent_direct_messages)){
			$this->sent_direct_messages = $this->_fetch('direct_messages/sent.' . $this->type . $params);
		}
		
		return $this->sent_direct_messages;
	}
	
	function friendship_exists($user_a = '', $user_b = ''){
		if (!$this->auth){ return false; }
		$friends = (string) $this->_fetch('friendships/exists.'.$this->type.'?user_a='.$user_a.'&user_b=' . $user_b);
		return ($friends == 'true') ? true : false;
	}
	
	function rate_limit_status(){
		if (!$this->auth){ return false; }
		return $this->_fetch('account/rate_limit_status.' . $this->type);
	}
	
	function favorites($id = '', $page = ''){
		if (!$this->auth){ return false; }
		
		$params = $this->_build_params(array('id' => $id, 'page' => $page));
		
		if (empty($this->favorites)){
			$this->favorites = $this->_fetch('favorites.' . $this->type);
		}
		
		return $this->favorites;
	}
	
	function downtime_schedule(){
		return $this->_fetch('help/downtime_schedule.' . $this->type);
	}
	
	/*
		POST Methods
	*/
	
	function update($status = '', $in_reply_to_status_id = ''){
		$params = array();
		$params['status'] = $status;
		
		if (!empty($in_reply_to_status_id)){
			$params['in_reply_to_status_id'] = $in_reply_to_status_id;
		}
		
		return $this->_post('statuses/update.' . $this->type, $params);
	}
	
	function destroy($id = ''){
		$params = array();
		
		if (!empty($id)){
			$params['id'] = $id;
		}
		
		return $this->_post('statuses/destroy/id.' . $this->type, $params);
	}
	
	function new_direct_message($user = '', $text = ''){
		$params = array();
		
		if (!empty($user)){
			$params['user'] = $user;
		}
		
		if (!empty($text)){
			$params['text'] = $text;
		}
		
		return $this->_post('direct_messages/new.' . $this->type, $params);
	}
	
	function destroy_direct_message($id = ''){
		$params = array();
		
		if (!empty($id)){
			$params['id'] = $id;
		}
		
		return $this->_post('direct_messages/destroy/id.' . $this->type, $params);
	}
	
	function create_friendship($id = '', $follow = ''){
		$params = array();
		
		if (!empty($id)){
			$params['id'] = $id;
		}
		
		$params = array();
		
		if (!empty($follow)){
			$params['follow'] = $follow;
		}
				
		return $this->_post('friendships/create/id.' . $this->type, $params);
	}
	
	function destroy_friendship($id = ''){
		$params = array();
		
		if (!empty($id)){
			$params['id'] = $id;
		}
		
		return $this->_post('friendships/destroy/id.' . $this->type, $params);
	}
	
	function update_profile($name = '', $email = '', $url = '', $location = '', $description = ''){
		$params = array();
		
		if (!empty($name)){
			$params['name'] = $name;
		}
		
		if (!empty($email)){
			$params['email'] = $email;
		}
		
		if (!empty($url)){
			$params['url'] = $url;
		}
		
		if (!empty($location)){
			$params['location'] = $location;
		}
		
		if (!empty($description)){
			$params['description'] = (strlen($description) > 160) ? substr($description,0,160) : $description;
		}
		
		return $this->_post('account/update_profile.' . $this->type, $params);
	}
	
	function update_delivery_device($device = 'none'){
		$params = array('device' => $device);
		
		return $this->_post('account/update_delivery_device.' . $this->type, $params);
	}
	
	function update_profile_colors($profile_background_color = '', $profile_text_color = '', $profile_link_color = '', $profile_sidebar_fill_color = '', $profile_sidebar_border_color = ''){
		if (!empty($profile_background_color)){
			$params['profile_background_color'] = $profile_background_color;
		}
		
		if (!empty($profile_text_color)){
			$params['profile_text_color'] = $profile_text_color;
		}
		
		if (!empty($profile_link_color)){
			$params['profile_link_color'] = $profile_link_color;
		}
		
		if (!empty($profile_sidebar_fill_color)){
			$params['profile_sidebar_fill_color'] = $profile_sidebar_fill_color;
		}
		
		if (!empty($profile_sidebar_border_color)){
			$params['profile_sidebar_border_color'] = $profile_sidebar_border_color;
		}
		
		return $this->_post('account/update_profile_colors.' . $this->type, $params);
	}
	
	function update_profile_image($image = ''){ // this should be raw multipart data, not a url
		if (!empty($image)){
			$params['image'] = $image;
		}
		
		return $this->_post('account/update_profile_image.' . $this->type, $params);
	}
	
	/*function update_profile_image_url($url){
		$image = file_get_contents($url);
		return $this->update_profile_image($image);
	}*/
	
	function update_profile_background_image($image = ''){ // this should be raw multipart data, not a url
		if (!empty($image)){
			$params['image'] = $image;
		}
		
		return $this->_post('account/update_profile_background_image.' . $this->type, $params);
	}
	
	/*function update_profile_background_image_url($url){
		$image = file_get_contents($url);
		return $this->update_profile_background_image($image);
	}*/
	
	/*
		Search Methods
	*/
	
	function search($query = 'twitter', $lang = '', $rpp = '', $page = '', $since_id = '', $geocode = '', $show_user = FALSE){
		$params = $this->_build_params(array(
				'q' => $query,
				'lang' => $lang,
				'rpp' => $rpp,
				'page' => $page,
				'since_id' => $since_id,
				'geocode' => $geocode,
				'show_user' => $show_user
			));
			
		return $this->_fetch('search.json' . $params);
	}
	
	function trends(){
		if (!function_exists('json_decode')){
			return false;
		}

		return $this->_fetch('trends.json');
	}
	
	/*
		System Methods
	*/
	
	function _fetch($url){
		
		if (!function_exists('curl_init')) {
            
			if(function_exists('log_message')) {
				log_message('error', 'Twitter - PHP was not built with cURL enabled. Rebuild PHP with --with-curl to use cURL.') ;
			}
			
			return false;
		}
		
		$url = 'http://' . $this->api_location . '/' . $url;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERPWD, $this->username . ':' . $this->password);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
		$returned = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close ($ch);
		
		if ($status == '200'){
			return $this->_parse_returned($returned, $url);
		} else {
			$error_data = $this->_parse_returned($returned, $url);
			
			// Server not found fix #1
			if($error_data) {
				$this->last_error = array('status' => $status, 'request' => $error_data->request, 'error' => $error_data->error);
			}
			
			return false;
		}
	}
	
	function _post($url,$array){
		$params = $this->_build_params($array,FALSE);
		
		$url = 'http://' . $this->api_location . '/' . $url;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERPWD, $this->username . ':' . $this->password);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		$returned = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close ($ch);

		if ($status == '200'){
			return $this->_parse_returned($returned, $url);
		} else {
			$error_data = $this->_parse_returned($returned, $url);
			$this->last_error = array('status' => $status, 'request' => $error_data->request, 'error' => $error_data->error);
			return false;
		}
	}
	
	function _parse_returned($xml, $url){		
		
		// Server not found fix #2
		if(empty($xml)) return false;
		
		switch ($this->type){
			case 'xml':
			case 'atom':
			case 'rss':
				return $this->_build_return(new SimpleXMLElement($xml),$this->type);
				break;
			case 'json':
				return $this->_build_return(json_decode($xml),$this->type);
				break;
		}
	}
	
	/*
		Message parsing by Phil Sturgeon - http://philsturgeon.co.uk
	*/
	
	function _parse_message($text){
		
		$patterns = array(
	
			// Detect URL's
			'|([a-z]{3,9}://[a-z0-9-_./\\\?&\+]*)|i'
				=>
			'<a href="$0" target="_blank">$0</a>',
			
			// Detect Email
			'|[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,6}|i'
				=>
			'<a href="mailto:$0">$0</a>',
			
			// Detect Twitter @usernames
			'|@([a-z0-9-_]+)|i'
				=>
			'<a href="http://twitter.com/$1" target="_blank">$0</a>',
			
			// Detect Twitter #tags
			'|#([a-z0-9-_]+)|i'
				=>
			'<a href="http://twitter.com/search?q=%23$1" target="_blank">$0</a>'
		);
		
		foreach($patterns as $regex => $replace)
		{
			$text = preg_replace($regex, $replace, $text);
		}
		
		return $text;
	}
	
	
	function _build_return($data,$type){
		if ($type == 'xml'){
			$data = json_decode(json_encode($data)); // convert SimpleXML object to stdObject
			
			// We need to figure out if there is only one "real" node (aside from @attributes - if there is, return that as the parent)
			
			$keys = array();

			foreach($data as $key => $value){
				if ($key !== '@attributes'){
					$keys[] = $key;
				}
			}
			if (count($keys) == 1){
				return $data->$keys[0];
			}
		}
		
		return $data;
	}
	
	function _build_params($array, $query_string = TRUE){
		$params = '';
		
		foreach ($array as $key => $value){
			if (!empty($value)){
				$params .= urlencode($key) . '=' . urlencode($value) . '&';
			}
		}
		
		$character = ($query_string) ? '?' : '';
		
		return (!empty($params)) ? $character . $params : '';
	}
	
	function get_last_error(){
		return $this->last_error;
	}
}