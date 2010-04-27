<?php
class Forum_subscriptions_m extends MY_Model
{

	/**
	 * Adds a suscription
	 *
	 * @param int $user_id
	 * @param int $topic_id
	 */
	function add($user_id, $topic_id)
	{
		if(!$this->is_subscribed($user_id, $topic_id))
		{
			parent::insert(array('user_id' => $user_id, 'topic_id' => $topic_id));
		}
	}

	function is_subscribed($user_id, $topic_id)
	{
		if(parent::count_by(array('user_id' => $user_id, 'topic_id' => $topic_id)) > 0)
		{
			return TRUE;
		}
		return FALSE;
	}
}
?>