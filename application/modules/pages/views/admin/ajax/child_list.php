<?php foreach ($pages as $page): ?>
<li>
	<span class="<?php echo $page->has_children ? 'folder' : 'file' ?>">
		<a href="#" rel="page-<?php echo $page->id; ?>">
			<?php echo $page->title; ?> <small>(#<?php echo $page->id; ?>)</small>
		</a>
	</span>
	<?php if ($page->has_children): ?>
		<?php if (in_array($page->id, $open_parent_pages)): ?>
			<ul>
				<?php echo $controller->recurse_page_tree($page->id, $open_parent_pages); ?>
			</ul>
		<?php else: ?>
			<ul style="display:none"></ul>
		<?php endif; ?>
	<?php endif; ?>
</li>
<?php endforeach;?>
