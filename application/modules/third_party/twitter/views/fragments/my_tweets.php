<?php
// The twitter module is here, and enabled!
$CI =& get_instance();
$CI->load->model('twitter/twitter_m');
$twitter_timeline = $CI->twitter_m->user_timeline(NULL, $this->settings->item('twitter_feed_count'));
// End twitter code
?>

<?php if($twitter_timeline): ?>
	<?php foreach($twitter_timeline as $tweet): ?>
		<p class="dark-grey-bg spacer-bottom padding-left">
			<strong><?php echo date('d/m/Y h:m', strtotime($tweet->created_at));?></strong> - <em><?php echo $tweet->text;?></em>
		</p>	
	<?php endforeach; ?>		
	<p class="align-center">
		<a href="http://twitter.com/<?php echo $this->settings->item('twitter_username') ?>" target="_blank"><?php echo lang('twitter_more');?></a>
	</p>
<?php else: ?>
	<p><?php echo lang('twitter_no_tweets');?></p>
<?php endif; ?>