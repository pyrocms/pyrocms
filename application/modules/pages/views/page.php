<!-- Page layout: <?php echo $page->layout->title ?> -->

<?php echo $page->layout->body; ?>

<?php if($page->comments_enabled): ?>

	<br class="clear-both" />

	<?php echo display_comments($page->id); ?>

<?php endif; ?>