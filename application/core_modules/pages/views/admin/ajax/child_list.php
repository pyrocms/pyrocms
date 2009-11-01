<? foreach ($pages as $page): ?>
<li>
	<span class="<?php echo $page->has_children ? 'folder' : 'file' ?>">
		<a href="#" rel="page-<?php echo $page->id; ?>">
			<?php echo $page->title; ?> <small>(#<?php echo $page->id; ?>)</small>
		</a>
	</span>
	<?php if ($page->has_children) :?>
		<ul></ul>
	<?php endif;?>
</li>
<?php endforeach;?>
