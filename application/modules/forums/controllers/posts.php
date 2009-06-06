<?php
class Posts extends Controller {

	var $data;
	var $userID;

	function Posts()
	{
		parent::Controller();
		
		$this->load->module_model('account', 'usermodel');

		$this->load->model('forum_model');
		$this->load->model('post_model');

		$this->lang->load('forum');
		$this->config->load('forums');
		
		// Add a link to the forum CSS into the head
		$this->template->extra_head( css_asset('forum.css', 'forum') );
		
		$this->userID = getUserProperty('id');
		
		$this->data = array(
			'userID' =>$this->userID,
			// we need this so that there would not be a Notice: Undefined variable: message
			'message'	=> '',
		);
		
	}
	
	
	function index()
	{
		redirect('forums');
	}

	function view_reply($replyID = 0)
	{
		$replyID = intval($replyID);
		$reply_data = $this->post_model->getReplyData($replyID);
		// Check if reply exists
		if(!empty($reply_data))
		{
			if($reply_data['parentID'] != 0)
				$threadID = $reply_data['parentID'];
			else 
				$threadID = $reply_data['postID'];	
			redirect('forums/topics/view_topic/'.$threadID.'/#'.$replyID);
		} else {
			
			show_error('The reply doesn\'t exist!');
			$this->template->create('message', $this->data);
		}
	}

	
	function report($postID = 0)
	{
		$this->freakauth_light->check();
		
		$postID = intval($postID);
		$post_data = $this->post_model->getReplyData($postID);
		// Check if reply exists
		if(!empty($post_data))
		{
			if($post_data['parentID'] != 0):
				$topicID = $post_data['parentID'];
			else:
				$topicID = $post_data['postID'];
			endif;
			
			$data = array(
				'postID'		=>	$post_data['postID'],
				'topic_name'	=>	$post_data['post_title'],
				'topicID'		=>	$topicID
			);
			$this->data = array_merge($this->data, $data);

			if(!empty($_POST['submit'])) 
			{
					$message = trim($this->input->post('message', TRUE));
					$message = strip_tags($message);
					if(empty($message)) 
					{
						$this->template->error("Error Message:  Report Text field is empty.");
						$this->template->create('report', $this->data);
					} else {
						$report_text = $this->lang->line('report_text');
						$report_text = str_replace('<#USERNAME#>', getUserFullNameFromId($this->userID), $report_text);
						$report_text = str_replace('<#TOPIC#>', anchor('forums/topics/view_topic/'.$this->data['topicID'], $this->data['topic_name']), $report_text);
						$report_text = str_replace('<#LINK_TO_POST#>', anchor('forums/posts/view_reply/'.$postID, '#'.$postID), $report_text);
						$report_text = str_replace('<#REPORT#>', $message, $report_text);
						$report_text = addslashes($report_text);
						$data = array(
							'message_to' 		=> $this->config->item('default_moderator'),
							'message_subject' 	=> 'Report',
							'message_content' 	=> $report_text
						);
						
						$this->CI->load->module_model('messages', 'message_model');
						$this->message_model->insert('inbox', $data);

						$this->data['message'] = "Report Successfully Added, Moderators will check it out.";
						$this->template->create('message', $this->data);
					}
			} else {
				$this->template->title('Forums > Report');
				$this->template->create('report', $this->data);	
			}			
		} else {
			show_error("The post doesn`t exist!");		
		}

	}


	function new_reply($topicID = 0, $quote_message = "")
	{
		$this->freakauth_light->check();
		$this->load->helpers(array('smiley', 'bbcode'));

		$topicID = intval($topicID);
		
		$topic = array(
			'userID'		=>	$this->userID,
			'forumID'		=>	'',
			'topicID'		=>	$topicID,
			'topic_name' 	=>	'',
			'message'		=>	'',
			'notify'		=>	0,
			'smileys'		=>	1
		);
		
		// Get the topic name
		$topic_data = $this->post_model->getTopicData($topicID);
		// Check if topic exists
		if(!empty($topic_data))
		{
			// It reterns double array, so we need to get the 2 one with data
			$topic_data = $topic_data[0];
	
			// Take only what we need
			$topic['forumID'] = $topic_data['forumID'];
			$topic['topic_name'] = $topic_data['post_title'];
	
			// Get the forum name
			$forum = $this->forum_model->getForum($topic['forumID']);
			
			$this->data = array_merge($this->data, $forum, $topic);
	
			if(!empty($_POST['submit'])) {
				$topicID = intval($this->input->post('topicID'));
				$message = trim($this->input->post('message'));
				$message = strip_tags($message);
				$smileys = intval($this->input->post('smileys'));
				if($smileys != 1) $smileys = 0;
				$notify = intval($this->input->post('notify'));
				if($notify != 1) $notify = 0;
				if(!empty($message) && $topicID > 0)
				{
					if($this->post_model->postReply($this->userID, $topicID, $message, $smileys))
					{
						// Notify about new post
						$this->post_model->NewPostNotify($topicID, $this->userID);
						// Add user to notify
						if($notify) $this->post_model->AddNotify($topicID, $this->userID);
						
						// Get New topic ID
						$last_data = $this->post_model->getLastPost('user', $this->userID);

						redirect('forums/posts/view_reply/'.$last_data['postID']);
					} else {
						show_error('Error Accured While Adding Reply.');
					}
				}
			} else if(!empty($_POST['preview'])) {
				// Get message
				$message = $this->input->post('message');
				$message = strip_tags($message);
				$smileys = intval($this->input->post('smileys'));
				if($smileys != 1) $smileys = 0;
				$notify = intval($this->input->post('notify'));
				if($notify != 1) $notify = 0;
				// If empty message field display error
				if(empty($message)) $this->template->error('Error Message: Your message field is empty');					
				// Define data
				$this->data['preview'] = $this->post_model->postParse($message, $smileys);
				$this->data['message'] = stripslashes($message);
				$this->data['smileys'] = $smileys;
				$this->data['notify'] = $notify;
				// Load View
				$this->template->title('Replying to \''.$this->data['topic_name'].'\'');
				$this->template->crumb($this->data['forum_name'], 'forums/view_forum/'.$forumID);
				$this->template->crumb('Replying to \''.$this->data['topic_name'].'\'');
				$this->template->create('new_reply', $this->data);
			} else {
				
				if(!empty($quote_message))
				{
					$this->data['message'] = '[quote author="'.getUserPropertyFromId('user_name', $quote_message['authorID']).'" date="'.$quote_message['post_date'].'"]'.$quote_message["post_text"].'[/quote]';
				}
				
				$this->template->title('Forums > '. $this->data['forum_name'] .' > '.$this->data['topic_name']);
				$this->template->create('new_reply', $this->data);
			}
		} else {
			show_error("The topic doesn`t exist!");
		}
	}


	function quote_reply($quoteID = 0)
	{
		$quoteID = intval($quoteID);
		$quote_data = $this->post_model->getReplyData($quoteID);
		// Check if reply exists
		if(!empty($quote_data))
		{
			if($quote_data['parentID'] != 0)
			{
				$topicID = $quote_data['parentID'];
				$this->new_reply($topicID, $quote_data);
			} else {
				$topicID = $quote_data['postID'];
				$this->new_reply($topicID, $quote_data);
			}
		} else {
			show_error('The Post You Are Trying to Quote doesn`t exist!');
		}

	}


	function edit_reply($postID = 0)
	{
		$this->freakauth_light->check();
		$this->load->helpers(array('smiley', 'bbcode'));

		$postID = intval($postID);
		$post_data = $this->post_model->getReplyData($postID);
		// Check if reply exists
		if(!empty($post_data))
		{
			if($post_data['authorID'] == $this->userID)
			{
				if($post_data['parentID'] != 0)
					$topicID = $post_data['parentID'];
				else
					$topicID = $post_data['postID'];

				$topic = array(
					'userID'		=>	$this->userID,
					'forumID'		=>	'',
					'topicID'		=>	$topicID,
					'topic_name' 	=>	'',
					'postID'		=>	$postID
				);
				// Get the topic name
				$topic_data = $this->post_model->getTopicData($topicID);
				// It reterns double array, so we need to get the 2 one with data
				$topic_data = $topic_data[0];
		
				// Take only what we need
				$topic['forumID'] = $topic_data['forumID'];
				$topic['topic_name'] = $topic_data['post_title'];
		
				// Get the forum name
				$forum = $this->forum_model->getForum($topic['forumID']);

				$this->data = array_merge($this->data, $post_data, $forum, $topic);

				if(!empty($_POST['submit'])) {
					$postID = intval($this->input->post('postID'));
					$message = trim($this->input->post('message'));
					$message = strip_tags($message);
					if(!empty($message) && $topicID > 0)
					{
						if($this->post_model->editReply($postID, $message)):
							redirect('forums/posts/view_reply/'.$postID);
							
						else:
							show_error('Error Accured While Editing a Reply.');
						endif;
					}
				} else if(!empty($_POST['preview'])) {
					// Get message
					$message = $this->input->post('message');
					$message = strip_tags($message);
					// If empty message field display error
					if(empty($message)) $this->template->error("Error Message:  Your message field is empty");					
					// Define data
					$this->data['preview'] = $this->post_model->postParse($message);
					$this->data['message'] = $message;
					// Load View
					$this->template->title('Forums > '. $this->data['forum_name'] .' > '.$this->data['topic_name']);
					$this->template->create('edit_reply', $this->data);
					
				} else {
					$this->data['message'] = $post_data['post_text'];
					$this->template->title('Forums > '. $this->data['forum_name'] .' > '.$this->data['topic_name']);
					
					$this->template->crumb($this->data['forum_name'], 'forums/view_forum/'.$forumID);
					$this->template->crumb('Edit: '.$this->data['topic_name']);
					$this->template->create('edit_reply', $this->data);
				}
			} else {
				show_error('You can edit only youre own posts.');
			}				
		} else {
			show_error('The Post You Are Trying to Edit doesn`t exist.');
		}
			
	}


	function delete_reply($postID = 0)
	{
		$this->freakauth_light->check();
		$this->load->helpers(array('smiley', 'bbcode'));

		$postID = intval($postID);
		$post_data = $this->post_model->getReplyData($postID);
		// Check if reply exists
		if(!empty($post_data))
		{
			if($post_data['authorID'] == $this->userID)
			{
				if($this->post_model->deleteReply($postID))
				{
					$this->data['message'] = "Post Successfully Deleted";
					$this->template->create('message', $this->data);
				} else {
					$this->template->error("Error Message:  Error Accured While Trying to Delete a Reply");
				}
			} else {
				$this->template->error("You can delete only youre own posts!");
			}				
		} else {
			$this->template->error("The Post You Are Trying to Edit doesn`t exist!");
		}
		
		if(!empty($this->template->error_string)) $this->template->create('message', $this->data);
	}

}
?>