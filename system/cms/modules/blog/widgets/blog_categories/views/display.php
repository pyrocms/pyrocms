<?php
/* Sort categories by ID */
usort($categories, function($a, $b) { return $a->id - $b->id; });

<?php if (is_array($categories)): ?>
<ul>
	<?php foreach ($categories as $category): ?>
	<li>
		<?php echo anchor("blog/category/{$category->slug}", $category->title) ?>
	</li>
	<?php endforeach ?>
</ul>
<?php endif
