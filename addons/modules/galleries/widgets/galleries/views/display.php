<?php if(is_array($galleries)): ?>
<ul>
	<?php foreach($galleries as $gallery): ?>
	<li>
		<?php echo anchor("galleries/{$gallery->slug}", $gallery->title); ?>
	</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
