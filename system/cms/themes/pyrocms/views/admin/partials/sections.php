<div class="sections_bar">
	<div class="wrapper">
	
		<ul>
			<?php foreach ($module_details['sections'] as $name => $section): ?>
			<li class="<?php if ($name === $active_section) echo 'current' ?>">
				<?php echo anchor($section['uri'], lang($section['name'])); ?>
				<?php if ($name === $active_section): ?>
					<?php echo image('admin/section_arrow.png'); ?>
				<?php endif; ?>
			</li>
			<?php endforeach; ?>
		</ul>

	</div>
</div>
