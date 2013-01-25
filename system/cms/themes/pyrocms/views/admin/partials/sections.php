<div class="sections_bar">
	<div class="wrapper">
	
		<ul>
			<?php foreach ($module_details['sections'] as $name => $section): ?>
			<?php if(isset($section['name']) && isset($section['uri'])): ?>
			<li class="<?php if ($name === $active_section) echo 'current' ?>">
				<?php echo anchor($section['uri'], (lang($section['name']) ? lang($section['name']) : $section['name'])); ?>
				<?php if ($name === $active_section): ?>
					<!-- <?php echo Asset::img('admin/section_arrow.png', ''); ?> -->
				<?php endif; ?>
			</li>
			<?php endif; ?>
			<?php endforeach; ?>
		</ul>

	</div>
</div>