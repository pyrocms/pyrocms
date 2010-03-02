<?php if(!empty($tweets)): ?>

	<ul>
	<?php foreach($tweets as $tweet): ?>
		<li>
			<em class="tweet"><?php echo $tweet->text;?></em> <small class="date">(<?php echo date('d/m/Y h:m', strtotime($tweet->created_at));?>)</small>
		</li>
	<?php endforeach; ?>
	</ul>
	
	<p class="align-center">
		<a href="http://twitter.com/<?php echo $options['username'] ?>" target="_blank"><?php echo lang('twitter_more');?></a>
	</p>
	
<?php else: ?>
	<p><?php echo lang('twitter_no_tweets');?></p>
<?php endif; ?>