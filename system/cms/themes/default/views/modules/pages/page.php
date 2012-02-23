<article class="page">
	<?php echo $page->layout->body; ?>

	<?php if($page->comments_enabled): ?>
		<?php echo display_comments($page->id); ?>
	<?php endif; ?>
</article>