<ul class="rss">
    <?php foreach($tweets as $tweet): ?>
	<li>
	    <?php echo $tweet->text; ?>
	    <p class="date"><em><?php echo anchor('https://twitter.com/' . $username . '/status/' . $tweet->id, format_date($tweet->created_at, Settings::get('date_format') . ' h:i'), 'target="_blank"'); ?></em></p>
	</li>
    <?php endforeach; ?>
</ul>