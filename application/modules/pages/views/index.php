
<? if($page->slug == 'home'): ?>

	<h2><?= $page->title; ?></h2>
	
	<?= $page->body; ?>

<? else: ?>

	<h2><?= $page->title; ?></h2>

	<? if (!empty($page->attachment)) {
		echo '<div class="img">' . image($page->attachment) . '</div>';
	} ?>
	
	<?= $page->body; ?>

<? endif; ?>
