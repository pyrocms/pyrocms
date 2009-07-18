<?php
// The twitter module is here, and enabled!
$CI =& get_instance();
$CI->load->module_model('twitter', 'twitter_m');
$twitter_timeline = $CI->twitter_m->user_timeline(NULL, $this->settings->item('twitter_feed_count'));
// End twitter code
?>

<? if($twitter_timeline): ?>
	<? foreach($twitter_timeline as $tweet): ?>
		<p class="dark-grey-bg spacer-bottom padding-left">
			<strong><?=date('d/m/Y h:m', strtotime($tweet->created_at));?></strong> - <em><?= $tweet->text;?></em>
		</p>	
	<? endforeach; ?>		
	<p class="align-center">
		<a href="http://twitter.com/<?=$this->settings->item('twitter_username') ?>" target="_blank"><?= lang('twitter_more');?></a>
	</p>
<? else: ?>
	<p><?= lang('twitter_no_tweets');?></p>
<? endif; ?>