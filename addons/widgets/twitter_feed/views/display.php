<ul class="rss">
    <?php foreach($tweets as $tweet): ?>
	<li>
	    <?php echo $tweet->text; ?>
	    <p class="date"><em><?php echo anchor($tweet->get_permalink(), $tweet->get_date(), 'target="_blank"'); ?></em></p>
	</li>
    <?php endforeach; ?>
</ul>